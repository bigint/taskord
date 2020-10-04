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
    
    public function test_sitemap_products_url()
    {
        $response = $this->get('sitemap_products.txt');

        $response->assertStatus(200);
    }

    public function test_sitemap_products_displays_sitemap_products_page()
    {
        $response = $this->get('sitemap_products.txt');

        $response->assertStatus(200);
        $response->assertViewIs('seo.sitemap_products');
    }
    
    public function test_sitemap_tasks_url()
    {
        $response = $this->get('sitemap_tasks.txt');

        $response->assertStatus(200);
    }

    public function test_sitemap_tasks_displays_sitemap_tasks_page()
    {
        $response = $this->get('sitemap_tasks.txt');

        $response->assertStatus(200);
        $response->assertViewIs('seo.sitemap_tasks');
    }
    
    public function test_sitemap_comments_url()
    {
        $response = $this->get('sitemap_comments.txt');

        $response->assertStatus(200);
    }

    public function test_sitemap_comments_displays_sitemap_comments_page()
    {
        $response = $this->get('sitemap_comments.txt');

        $response->assertStatus(200);
        $response->assertViewIs('seo.sitemap_comments');
    }
}
