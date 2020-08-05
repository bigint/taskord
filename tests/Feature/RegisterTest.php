<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    public function test_register_url()
    {
        $response = $this->get(route('register'));

        $response->assertStatus(200);
    }

    public function test_auth_register_back_to_home_url()
    {
        $user = User::where(['email' => 'dabbit@tuta.io'])->first();
        $response = $this->actingAs($user)->get(route('register'));

        $response->assertStatus(302);
        $response->assertRedirect('/');
    }

    public function test_register_displays_the_register_form()
    {
        $response = $this->get(route('register'));

        $response->assertStatus(200);
        $response->assertViewIs('auth.register');
    }
}
