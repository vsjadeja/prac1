<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Spatie\Permission\Models\Role;
use App\Http\Requests\StoreRole;

class RoleTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test */
    public function only_admin_can_see_role_list()
    {
        $response = $this->get('/roles')->assertRedirect('/login');
    }

    /** @test */
    public function user_with_grant_can_see_role_list_after_login()
    {
        $user = $this->createUserWithRoleAndPermission('test', ['role-list']);
        $this->actingAs($user);

        $response = $this->get('/roles')->assertOk();
    }

    /** @test */
    public function a_role_can_be_added_through_the_form()
    {
        $user = $this->createUserWithRoleAndPermission('test', ['role-list','role-create']);
        $this->actingAs($user);

        $response = $this->post('/roles', ['name' => 'student']);
        
        $this->assertCount(1, Role::where('name', 'student')->get());
    }

    /** @test */
    public function user_with_grant_can_see_detail_of_role_after_login()
    {
        $user = $this->createUserWithRoleAndPermission('test', ['role-list']);
        $this->actingAs($user);

        $response = $this->get('/roles/1')->assertOk();
    }

    /** @test */
    public function user_with_grant_can_update_detail_of_role_after_login()
    {
        $user = $this->createUserWithRoleAndPermission('test', ['role-list','role-edit']);
        $this->actingAs($user);

        $response = $this->put('/roles/1', ['name' => 'administrator','permission[]' => 'role-list','permission[]' => 'role-create','permission[]' => 'role-edit']);

        $this->assertCount(1, Role::where('name', 'administrator')->get());
    }

    /** @test */
    public function user_with_grant_can_delete_role_after_login()
    {
        $user = $this->createUserWithRoleAndPermission('test', ['role-list','role-delete']);
        $this->actingAs($user);

        $response = $this->delete('/roles/1');

        $this->assertCount(0, Role::all());
    }
}
