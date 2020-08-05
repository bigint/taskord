<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;

class TasksTest extends TestCase
{
    public function test_tasks_url()
    {
        $response = $this->get(route('tasks'));

        $response->assertStatus(302);
    }

    public function test_auth_tasks_url()
    {
        $user = User::where(['email' => 'dabbit@tuta.io'])->first();
        $response = $this->actingAs($user)->get(route('tasks'));

        $response->assertStatus(200);
    }

    public function test_auth_tasks_displays_the_tasks_form()
    {
        $user = User::where(['email' => 'dabbit@tuta.io'])->first();
        $response = $this->actingAs($user)->get(route('tasks'));

        $response->assertStatus(200);
        $response->assertViewIs('tasks.tasks');
    }
}
