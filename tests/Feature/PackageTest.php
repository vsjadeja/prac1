<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Package;
use App\Models\PackageType;
use App\Http\Requests\StorePackage;


use Illuminate\Http\Request;

class PackageTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $packgetype = PackageType::create(['name' => 'packtype', 'status' => true]);
        $package = Package::create(['name' => 'test pack', 'description' => 'description for test pack', 'price' => '1', 'package_type_id' => $packgetype->id, 'status' => '1']);
    }
    
    /** @test */
    public function a_user_needs_login_to_see_packages()
    {
        $response = $this->get('/packages')->assertRedirect('/login');
    }

    /** @test */
    public function user_with_grant_can_see_packages_list_after_login()
    {
        $user = $this->createUserWithRoleAndPermission('test', ['package-list']);
        $this->actingAs($user);

        $response = $this->get('/packages')->assertOk();
    }

    /** @test */
    public function user_with_grant_can_see_detail_of_package_after_login()
    {
        $user = $this->createUserWithRoleAndPermission('test', ['package-list']);
        $this->actingAs($user);

        $response = $this->get('/packages/1')->assertOk();
    }

    /** @test */
    public function user_with_grant_can_delete_package_after_login()
    {
        $user = $this->createUserWithRoleAndPermission('test', ['package-list','package-delete']);
        $this->actingAs($user);

        $response = $this->delete('/packages/1');

        $this->assertEquals(302, $response->getStatusCode());
        $this->assertCount(0, Package::all());
    }

    /** @test */
    public function a_package_can_be_added_through_the_form()
    {
        $user = $this->createUserWithRoleAndPermission('test', ['package-list','package-create']);
        $this->actingAs($user);

        $response = $this->post('/packages', ['name' => 'test package', 'description' => 'description for test pack', 'price' => '1', 'package_type_id' => 1, 'status' => '1']);
        
        $this->assertEquals(302, $response->getStatusCode());
        $this->assertCount(1, Package::where('name', 'test package')->get());
    }

    /** @test */
    public function user_with_grant_can_update_detail_of_package_after_login()
    {
        $user = $this->createUserWithRoleAndPermission('test', ['package-list','package-edit']);
        $this->actingAs($user);

        $response = $this->put('/packages/1', ['name' => 'sub package', 'description' => 'description for test pack', 'price' => '1', 'package_type_id' => 1, 'status' => '1']);

        $this->assertEquals(302, $response->getStatusCode());
        $this->assertCount(1, Package::where('name', 'sub package')->get());
    }
    
}
