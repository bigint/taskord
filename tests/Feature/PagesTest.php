<?php

namespace Tests\Feature;

use Tests\TestCase;

class PagesTest extends TestCase
{
    public function test_deals_url()
    {
        $response = $this->get(route('deals'));

        $response->assertStatus(200);
    }

    public function test_deals_displays_the_deals_page()
    {
        $response = $this->get(route('deals'));

        $response->assertStatus(200);
        $response->assertViewIs('pages.deals');
    }

    public function test_about_url()
    {
        $response = $this->get(route('about'));

        $response->assertStatus(200);
    }

    public function test_about_displays_the_about_page()
    {
        $response = $this->get(route('about'));

        $response->assertStatus(200);
        $response->assertViewIs('pages.about');
    }

    public function test_reputation_url()
    {
        $response = $this->get(route('reputation'));

        $response->assertStatus(200);
    }

    public function test_reputation_displays_the_reputation_page()
    {
        $response = $this->get(route('reputation'));

        $response->assertStatus(200);
        $response->assertViewIs('pages.reputation');
    }

    public function test_terms_url()
    {
        $response = $this->get(route('terms'));

        $response->assertStatus(200);
    }

    public function test_terms_displays_the_terms_page()
    {
        $response = $this->get(route('terms'));

        $response->assertStatus(200);
        $response->assertViewIs('pages.terms');
    }

    public function test_privacy_url()
    {
        $response = $this->get(route('privacy'));

        $response->assertStatus(200);
    }

    public function test_privacy_displays_the_privacy_page()
    {
        $response = $this->get(route('privacy'));

        $response->assertStatus(200);
        $response->assertViewIs('pages.privacy');
    }

    public function test_security_url()
    {
        $response = $this->get(route('security'));

        $response->assertStatus(200);
    }

    public function test_security_displays_the_security_page()
    {
        $response = $this->get(route('security'));

        $response->assertStatus(200);
        $response->assertViewIs('pages.security');
    }

    public function test_sponsors_url()
    {
        $response = $this->get(route('sponsors'));

        $response->assertStatus(200);
    }

    public function test_sponsors_displays_the_sponsors_page()
    {
        $response = $this->get(route('sponsors'));

        $response->assertStatus(200);
        $response->assertViewIs('pages.sponsors');
    }

    public function test_open_url()
    {
        $response = $this->get(route('open'));

        $response->assertStatus(200);
    }

    public function test_open_displays_the_open_page()
    {
        $response = $this->get(route('open'));

        $response->assertStatus(200);
        $response->assertViewIs('pages.open');
    }
}
