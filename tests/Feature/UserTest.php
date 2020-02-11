<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function only_logged_in_user_can_see_users_list()
    {
        $response = $this->get('/users')->assertRedirect('/login');
    }

    /** @test */
    public function authenticated_users_can_see_users_list()
    {
        $user = $this->createUserWithRoleAndPermission('test', ['user-list']);
        $this->actingAs($user);

        $response = $this->get('/users')->assertOk();
    }

    
}
