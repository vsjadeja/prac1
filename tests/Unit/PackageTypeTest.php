<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Spatie\Permission\Models\Role;
use App\Http\Requests\StorePackageType;

class PackageTypeTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_name_is_required()
    {
        $user = $this->createUserWithRoleAndPermission('admin', ['packagetype-list','packagetype-create']);
        $this->actingAs($user);

        $response = $this->post('/packagetypes', ['name' => null])->assertSessionHasErrors(['name' => 'Name is required.']);
    }

    /** @test */
    public function a_name_must_be_minimum_3_character_long()
    {
        $user = $this->createUserWithRoleAndPermission('admin', ['packagetype-list','packagetype-create']);
        $this->actingAs($user);

        $response = $this->post('/packagetypes', ['name' => 'fr'])->assertSessionHasErrors(['name' => 'Name must be atleast 3 character long.']);
    }

    /** @test */
    public function a_name_must_be_maximum_50_character_long()
    {
        $user = $this->createUserWithRoleAndPermission('admin', ['packagetype-list','packagetype-create']);
        $this->actingAs($user);

        $response = $this->post('/packagetypes', ['name' => 'Instead of generating random string, you might also want to generate long string.'])->assertSessionHasErrors(['name' => 'Name must be less than 50 characters.']);
    }

    /** @test */
    public function a_status_is_required()
    {
        $user = $this->createUserWithRoleAndPermission('admin', ['packagetype-list','packagetype-create']);
        $this->actingAs($user);

        $response = $this->post('/packagetypes', ['status' => null])->assertSessionHasErrors(['status' => 'Status is required.']);
    }

    /** @test */
    public function a_status_must_be_boolean()
    {
        $user = $this->createUserWithRoleAndPermission('admin', ['packagetype-list','packagetype-create']);
        $this->actingAs($user);

        $response = $this->post('/packagetypes', ['name' => 'Dummy Pack','status' => 'YES'])->assertSessionHasErrors(['status' => 'Status must be either enable or disable.']);
    }
}
