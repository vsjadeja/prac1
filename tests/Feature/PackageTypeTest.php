<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\PackageType;
use App\Http\Requests\StorePackageType;

class PackageTypeTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->seed();
    }
    
    /** @test */
    public function a_user_needs_login_to_see_packagetype()
    {
        $response = $this->get('/packagetypes')->assertRedirect('/login');
    }

    /** @test */
    public function user_with_grant_can_see_packagetype_list_after_login()
    {
        $user = $this->createUserWithRoleAndPermission('test', ['packagetype-list']);
        $this->actingAs($user);

        $response = $this->get('/packagetypes')->assertOk();
    }

    /** @test */
    public function a_packagetype_can_be_added_through_the_form()
    {
        $user = $this->createUserWithRoleAndPermission('test', ['packagetype-list','packagetype-create']);
        $this->actingAs($user);

        $response = $this->post('/packagetypes', ['name' => 'test pack', 'status' => true]);
        
        $this->assertCount(1, PackageType::where('name', 'test pack')->get());
    }

    /** @test */
    public function user_with_grant_can_see_detail_of_packagetype_after_login()
    {
        $user = $this->createUserWithRoleAndPermission('test', ['packagetype-list']);
        $this->actingAs($user);

        $response = $this->get('/packagetypes/1')->assertOk();
    }

    /** @test */
    public function user_with_grant_can_update_detail_of_packagetype_after_login()
    {
        $user = $this->createUserWithRoleAndPermission('test', ['packagetype-list','packagetype-edit']);
        $this->actingAs($user);

        $response = $this->put('/packagetypes/1', ['name' => 'sub package', 'status' => true]);

        $this->assertCount(1, PackageType::where('name', 'sub package')->get());
    }

    /** @test */
    public function user_with_grant_can_delete_packagetype_after_login()
    {
        $user = $this->createUserWithRoleAndPermission('test', ['packagetype-list','packagetype-delete']);
        $this->actingAs($user);

        $response = $this->delete('/packagetypes/1');

        $this->assertEquals(302, $response->getStatusCode());
        $this->assertCount(1, PackageType::all());
    }
}
