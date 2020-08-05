<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;

class LoginTest extends TestCase
{
    public function test_login_url()
    {
        $response = $this->get(route('login'));

        $response->assertStatus(200);
    }

    public function test_auth_login_back_to_home_url()
    {
        $user = User::where(['email' => 'dabbit@tuta.io'])->first();
        $response = $this->actingAs($user)->get(route('login'));

        $response->assertStatus(302);
        $response->assertRedirect('/');
    }

    public function test_login_displays_the_login_form()
    {
        $response = $this->get(route('login'));

        $response->assertStatus(200);
        $response->assertViewIs('auth.login');
    }

    public function test_user_can_login_with_username()
    {
        $user = User::where(['email' => 'dabbit@tuta.io'])->first();
        $response = $this->post('/login', [
            'username' => 'dabbit',
            'password' => 'test',
        ]);

        $response->assertRedirect('/');
        $this->assertAuthenticatedAs($user);
    }

    public function test_user_can_login_with_email()
    {
        $user = User::where(['email' => 'dabbit@tuta.io'])->first();
        $response = $this->post('/login', [
            'username' => 'dabbit@tuta.io',
            'password' => 'test',
        ]);

        $response->assertRedirect('/');
        $this->assertAuthenticatedAs($user);
    }

    public function test_user_can_login_with_wrong_credentials()
    {
        $user = User::where(['email' => 'dabbit@tuta.io'])->first();
        $response = $this->post('/login', [
            'username' => 'dabbit',
            'password' => 'wrong-password',
        ]);

        $this->assertFalse(session()->hasOldInput('password'));
    }
}
