<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Spatie\Permission\Models\Role;
use App\Http\Requests\StoreRole;

class RoleTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_name_is_required()
    {
        $user = $this->createUserWithRoleAndPermission('test', ['role-list','role-create']);
        $this->actingAs($user);

        $response = $this->post('/roles', ['name' => null])->assertSessionHasErrors(['name' => 'The name field is required.']);
    }

    /** @test */
    public function a_name_must_be_minimum_3_character_long()
    {
        $user = $this->createUserWithRoleAndPermission('admin', ['role-list','role-create']);
        $this->actingAs($user);

        $response = $this->post('/roles', ['name' => 'st'])->assertSessionHasErrors(['name' => 'The name must be at least 3 characters.']);
    }

    /** @test */
    public function a_name_must_be_unique()
    {
        $user = $this->createUserWithRoleAndPermission('admin', ['role-list','role-create']);
        $this->actingAs($user);

        $response = $this->post('/roles', ['name' => 'admin'])->assertSessionHasErrors(['name' => 'The name has already been taken.']);
    }

    /** @test */
    public function permission_field_is_nullable()
    {
        $user = $this->createUserWithRoleAndPermission('admin', ['role-list','role-create']);
        $this->actingAs($user);

        $response = $this->post('/roles', ['name' => 'student', 'permission[]' => null]);
        $response->assertSessionHasNoErrors();
        $this->assertCount(1, Role::where('name', 'student')->get());
    }

}
