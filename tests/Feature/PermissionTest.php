<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Spatie\Permission\Models\Permission;
use App\Http\Requests\StorePermission;

class PermissionTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }
    
    /** @test */
    public function a_user_needs_login_to_see_permissions()
    {
        $response = $this->get('/permissions')->assertRedirect('/login');
    }

    /** @test */
    public function user_with_grant_can_see_permission_list_after_login()
    {
        $user = $this->createUserWithRoleAndPermission('test', ['permission-list']);
        $this->actingAs($user);

        $response = $this->get('/permissions')->assertOk();
    }

    /** @test */
    public function a_permission_can_be_added_through_the_form()
    {
        $user = $this->createUserWithRoleAndPermission('test', ['permission-list','permission-create']);
        $this->actingAs($user);

        $response = $this->post('/permissions', ['name' => 'test-permission', 'guard_name' => 'web']);
        
        $this->assertCount(1, Permission::where('name', 'test-permission')->get());
    }

    /** @test */
    public function user_with_grant_can_see_detail_of_permission_after_login()
    {
        $user = $this->createUserWithRoleAndPermission('test', ['permission-list']);
        $this->actingAs($user);

        $response = $this->get('/permissions/1')->assertOk();
    }

    /** @test */
    public function user_with_grant_can_update_detail_of_permission_after_login()
    {
        $user = $this->createUserWithRoleAndPermission('test', ['permission-list','permission-edit']);
        $this->actingAs($user);

        $response = $this->put('/permissions/1', ['name' => 'permission-delete', 'guard_name' => 'web']);

        $this->assertCount(1, Permission::where('name', 'permission-delete')->get());
    }

    /** @test */
    public function user_with_grant_can_delete_permission_after_login()
    {
        $user = $this->createUserWithRoleAndPermission('test', ['permission-list','permission-delete']);
        $this->actingAs($user);

        $response = $this->delete('/permissions/1');
        $response->assertSessionHasNoErrors();
        $this->assertEquals(302, $response->getStatusCode());
    }
}
