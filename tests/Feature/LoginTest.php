<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class LoginTest extends TestCase
{
    public $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::where(['email' => 'test@taskord.com'])->first();
    }

    public function test_login_url()
    {
        $response = $this->get(route('login'));

        $response->assertStatus(200);
    }

    public function test_auth_login_back_to_home_url()
    {
        $response = $this->actingAs($this->user)->get(route('login'));

        $response->assertStatus(302);
        $response->assertRedirect('/');
    }

    public function test_login_displays_the_login_form()
    {
        $response = $this->get(route('login'));

        $response->assertStatus(200);
        $response->assertViewIs('auth.login');
    }

    // public function test_user_can_login_with_username()
    // {
    //     $response = $this->post('/login', [
    //         'username' => 'test',
    //         'password' => 'test',
    //     ]);

    //     $response->assertRedirect('/');
    //     $this->assertAuthenticatedAs($this->user);
    // }

    // public function test_user_can_login_with_email()
    // {
    //     $response = $this->post('/login', [
    //         'username' => 'test@taskord.com',
    //         'password' => 'test',
    //     ]);

    //     $response->assertRedirect('/');
    //     $this->assertAuthenticatedAs($this->user);
    // }

    public function test_user_can_login_with_wrong_credentials()
    {
        $response = $this->post('/login', [
            'username' => 'test',
            'password' => 'wrong-password',
        ]);

        $this->assertFalse(session()->hasOldInput('password'));
    }
}
