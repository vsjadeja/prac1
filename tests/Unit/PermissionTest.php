<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Spatie\Permission\Models\Role;
use App\Http\Requests\StorePermission;

class PermissionTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_name_is_required()
    {
        $user = $this->createUserWithRoleAndPermission('admin', ['permission-list','permission-create']);
        $this->actingAs($user);

        $response = $this->post('/permissions', ['name' => null])->assertSessionHasErrors(['name' => 'Name is required.']);
    }

    /** @test */
    public function a_name_must_be_minimum_3_character_long()
    {
        $user = $this->createUserWithRoleAndPermission('admin', ['permission-list','permission-create']);
        $this->actingAs($user);

        $response = $this->post('/permissions', ['name' => 'fr'])->assertSessionHasErrors(['name' => 'Name must be atleast 3 character long.']);
    }

    /** @test */
    public function a_name_must_be_maximum_50_character_long()
    {
        $user = $this->createUserWithRoleAndPermission('admin', ['permission-list','permission-create']);
        $this->actingAs($user);

        $response = $this->post('/permissions', ['name' => 'Instead of generating random string, you might also want to generate long string.'])->assertSessionHasErrors(['name' => 'Name must be less than 50 character.']);
    }

    /** @test */
    public function a_guard_name_is_required()
    {
        $user = $this->createUserWithRoleAndPermission('admin', ['permission-list','permission-create']);
        $this->actingAs($user);

        $response = $this->post('/permissions', ['name' => 'guard-create', 'guard_name' => null])->assertSessionHasErrors(['guard_name' => 'Guard Name is required.']);
    }

    /** @test */
    public function a_guard_name_must_be_minimum_3_character_long()
    {
        $user = $this->createUserWithRoleAndPermission('admin', ['permission-list','permission-create']);
        $this->actingAs($user);

        $response = $this->post('/permissions', ['name' => 'permission-edit', 'guard_name' => 'we'])->assertSessionHasErrors(['guard_name' => 'Guard Name must be atleast 3 character long.']);
    }

    /** @test */
    public function a_guard_name_must_be_maximum_50_character_long()
    {
        $user = $this->createUserWithRoleAndPermission('admin', ['permission-list','permission-create']);
        $this->actingAs($user);

        $response = $this->post('/permissions', ['name' => 'permission-edit', 'guard_name' => 'Instead of generating random string, you might also want to generate long string.'])->assertSessionHasErrors(['guard_name' => 'Guard Name must be less than 50 character.']);
    }
}
