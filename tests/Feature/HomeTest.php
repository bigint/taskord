<?php

namespace Tests\Feature;

use Tests\TestCase;

class HomeTest extends TestCase
{
    public function test_home_url()
    {
        $response = $this->get(route('home'));

        $response->assertStatus(200);
    }

    public function test_home_displays_the_home_page()
    {
        $response = $this->get(route('home'));

        $response->assertStatus(200);
        $response->assertViewIs('home.home');
    }
}
