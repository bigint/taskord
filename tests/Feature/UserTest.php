<?php

namespace Tests\Feature;

use Tests\TestCase;

class UserTest extends TestCase
{
    public function test_user_done_url()
    {
        $response = $this->get(route('user.done', ['username' => 'dabbit']));

        $response->assertStatus(200);
    }

    public function test_user_done_displays_the_user_done_page()
    {
        $response = $this->get(route('user.done', ['username' => 'dabbit']));

        $response->assertStatus(200);
        $response->assertViewIs('user.done');
    }

    public function test_user_pending_url()
    {
        $response = $this->get(route('user.pending', ['username' => 'dabbit']));

        $response->assertStatus(200);
    }

    public function test_user_pending_displays_the_user_pending_page()
    {
        $response = $this->get(route('user.pending', ['username' => 'dabbit']));

        $response->assertStatus(200);
        $response->assertViewIs('user.pending');
    }

    public function test_user_products_url()
    {
        $response = $this->get(route('user.products', ['username' => 'dabbit']));

        $response->assertStatus(200);
    }

    public function test_user_products_displays_the_user_products_page()
    {
        $response = $this->get(route('user.products', ['username' => 'dabbit']));

        $response->assertStatus(200);
        $response->assertViewIs('user.products');
    }

    public function test_user_questions_url()
    {
        $response = $this->get(route('user.questions', ['username' => 'dabbit']));

        $response->assertStatus(200);
    }

    public function test_user_questions_displays_the_user_questions_page()
    {
        $response = $this->get(route('user.questions', ['username' => 'dabbit']));

        $response->assertStatus(200);
        $response->assertViewIs('user.questions');
    }

    public function test_user_answers_url()
    {
        $response = $this->get(route('user.answers', ['username' => 'dabbit']));

        $response->assertStatus(200);
    }

    public function test_user_answers_displays_the_user_answers_page()
    {
        $response = $this->get(route('user.answers', ['username' => 'dabbit']));

        $response->assertStatus(200);
        $response->assertViewIs('user.answers');
    }
}
