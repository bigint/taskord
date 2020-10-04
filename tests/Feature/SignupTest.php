<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Str;
use Tests\TestCase;

class SignupTest extends TestCase
{
    public $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::where(['email' => 'test@taskord.com'])->first();
    }

    public function test_register_url()
    {
        $response = $this->get(route('register'));

        $response->assertStatus(200);
    }

    public function test_auth_register_back_to_home_url()
    {
        $response = $this->actingAs($this->user)->get(route('register'));

        $response->assertStatus(302);
        $response->assertRedirect('/');
    }

    public function test_register_displays_the_register_form()
    {
        $response = $this->get(route('register'));

        $response->assertStatus(200);
        $response->assertViewIs('auth.register');
    }

    public function test_user_can_register()
    {
        $response = $this->from('/register')->post('/register', [
            'username' => Str::random(10),
            'email' => Str::random(5).'@taskord.com',
            'password' => 'Taskord!test@Taskord',
            'password_confirmation' => 'Taskord!test@Taskord',
        ]);

        $response->assertRedirect('/');
        $response->assertSessionHasNoErrors();
    }

    public function test_user_can_register_with_disposable_email()
    {
        $response = $this->from('/register')->post('/register', [
            'username' => Str::random(10),
            'email' => Str::random(5).'@mailinator.com',
            'password' => 'Taskord!test@Taskord',
            'password_confirmation' => 'Taskord!test@Taskord',
        ]);

        $response->assertRedirect('/register');
        $response->assertSessionHasErrors('email');
        $this->assertTrue(session()->hasOldInput('email'));
        $this->assertFalse(session()->hasOldInput('password'));
        $this->assertGuest();
    }

    public function test_user_can_register_with_pwned_password()
    {
        $response = $this->from('/register')->post('/register', [
            'username' => Str::random(10),
            'email' => Str::random(5).'@taskord.com',
            'password' => 'qwerty',
            'password_confirmation' => 'qwerty',
        ]);

        $response->assertRedirect('/register');
        $response->assertSessionHasErrors('password');
        $this->assertTrue(session()->hasOldInput('email'));
        $this->assertFalse(session()->hasOldInput('password'));
        $this->assertGuest();
    }
}
