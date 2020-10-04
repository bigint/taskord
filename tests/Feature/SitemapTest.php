<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class SitemapTest extends TestCase
{
    public function test_sitemap_users_url()
    {
        $response = $this->get('sitemap_users.txt');

        $response->assertStatus(200);
    }

    public function test_sitemap_users_displays_sitemap_users_page()
    {
        $response = $this->get('sitemap_users.txt');

        $response->assertStatus(200);
        $response->assertViewIs('seo.sitemap_users');
    }
}
