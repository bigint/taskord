<?php

namespace Tests\Feature;

use Tests\TestCase;

class PasswordResetTest extends TestCase
{
    public function test_password_reset_url()
    {
        $response = $this->get('password/reset');

        $response->assertStatus(200);
    }

    public function test_password_reset_displays_the_password_reset_form()
    {
        $response = $this->get('password/reset');

        $response->assertStatus(200);
        $response->assertViewIs('auth.passwords.email');
    }
}
