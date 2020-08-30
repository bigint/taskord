<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class TasksTest extends TestCase
{
    public $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::where(['email' => 'test@taskord.com'])->first();
    }
    
    public function test_tasks_url()
    {
        $response = $this->get(route('tasks'));

        $response->assertStatus(302);
    }

    public function test_auth_tasks_url()
    {
        $response = $this->actingAs($this->user)->get(route('tasks'));

        $response->assertStatus(200);
    }

    public function test_auth_tasks_displays_the_tasks_form()
    {
        $response = $this->actingAs($this->user)->get(route('tasks'));

        $response->assertStatus(200);
        $response->assertViewIs('tasks.tasks');
    }
}
