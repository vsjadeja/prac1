<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

use App\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Foundation\Testing\WithFaker;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * Create user for testing with role and assign permission to assigned role.
     *
     * @param  String  $roleName
     * @param  Array  $permissionName
     * @return \App\User
     */
    public function createUserWithRoleAndPermission($roleName, $permissionName = [])
    {
        //$this->withoutExceptionHandling();
        
        $user = factory(User::class)->create();
        $role = Role::create(['name' => $roleName]);
        $user->assignRole($role);

        foreach ($permissionName as $p) :
            $permission = Permission::create(['name' => $p]);
            $role->givePermissionTo($permission);
        endforeach;
        
        return $user;
    }
}
