<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class SettingsTest extends TestCase
{
    public $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::where(['email' => 'test@taskord.com'])->first();
    }
    
    public function test_profile_settings_url()
    {
        $response = $this->get(route('user.settings.profile'));

        $response->assertStatus(302);
    }

    public function test_auth_profile_settings_url()
    {
        $this->withoutMiddleware(\Illuminate\Auth\Middleware\RequirePassword::class);
        $response = $this->actingAs($this->user)->get(route('user.settings.profile'));

        $response->assertStatus(200);
    }

    public function test_auth_profile_settings_displays_the_profile_settings_page()
    {
        $this->withoutMiddleware(\Illuminate\Auth\Middleware\RequirePassword::class);
        $response = $this->actingAs($this->user)->get(route('user.settings.profile'));

        $response->assertStatus(200);
        $response->assertViewIs('user.settings.profile');
    }

    public function test_account_settings_url()
    {
        $this->withoutMiddleware(\Illuminate\Auth\Middleware\RequirePassword::class);
        $response = $this->get(route('user.settings.account'));

        $response->assertStatus(302);
    }

    public function test_auth_account_settings_url()
    {
        $this->withoutMiddleware(\Illuminate\Auth\Middleware\RequirePassword::class);
        $response = $this->actingAs($this->user)->get(route('user.settings.account'));

        $response->assertStatus(200);
    }

    public function test_auth_account_settings_displays_the_account_settings_page()
    {
        $this->withoutMiddleware(\Illuminate\Auth\Middleware\RequirePassword::class);
        $response = $this->actingAs($this->user)->get(route('user.settings.account'));

        $response->assertStatus(200);
        $response->assertViewIs('user.settings.account');
    }

    public function test_password_settings_url()
    {
        $this->withoutMiddleware(\Illuminate\Auth\Middleware\RequirePassword::class);
        $response = $this->get(route('user.settings.password'));

        $response->assertStatus(302);
    }

    public function test_auth_password_settings_url()
    {
        $this->withoutMiddleware(\Illuminate\Auth\Middleware\RequirePassword::class);
        $response = $this->actingAs($this->user)->get(route('user.settings.password'));

        $response->assertStatus(200);
    }

    public function test_auth_password_settings_displays_the_password_settings_page()
    {
        $this->withoutMiddleware(\Illuminate\Auth\Middleware\RequirePassword::class);
        $response = $this->actingAs($this->user)->get(route('user.settings.password'));

        $response->assertStatus(200);
        $response->assertViewIs('user.settings.password');
    }

    public function test_delete_settings_url()
    {
        $this->withoutMiddleware(\Illuminate\Auth\Middleware\RequirePassword::class);
        $response = $this->get(route('user.settings.delete'));

        $response->assertStatus(302);
    }

    public function test_auth_delete_settings_url()
    {
        $this->withoutMiddleware(\Illuminate\Auth\Middleware\RequirePassword::class);
        $response = $this->actingAs($this->user)->get(route('user.settings.delete'));

        $response->assertStatus(200);
    }

    public function test_auth_delete_settings_displays_the_delete_settings_page()
    {
        $this->withoutMiddleware(\Illuminate\Auth\Middleware\RequirePassword::class);
        $response = $this->actingAs($this->user)->get(route('user.settings.delete'));

        $response->assertStatus(200);
        $response->assertViewIs('user.settings.delete');
    }
}
