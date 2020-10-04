<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class ResetTest extends TestCase
{
    public function test_reset_url()
    {
        $response = $this->get(route('password.request'));

        $response->assertStatus(200);
    }

    public function test_auth_show_reset_url()
    {
        $user = User::where(['email' => 'test@taskord.com'])->first();
        $response = $this->actingAs($user)->get(route('password.request'));

        $response->assertStatus(200);
    }

    public function test_reset_displays_the_reset_form()
    {
        $response = $this->get(route('password.request'));

        $response->assertStatus(200);
        $response->assertViewIs('auth.passwords.email');
    }
}
