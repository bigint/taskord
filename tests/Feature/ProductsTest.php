<?php

namespace Tests\Feature;

use Tests\TestCase;

class ProductsTest extends TestCase
{
    public function test_products_newest_url()
    {
        $response = $this->get(route('products.newest'));

        $response->assertStatus(200);
    }

    public function test_products_newest_displays_the_products_newest_page()
    {
        $response = $this->get(route('products.newest'));

        $response->assertStatus(200);
        $response->assertViewIs('products.newest');
    }

    public function test_products_launched_url()
    {
        $response = $this->get(route('products.launched'));

        $response->assertStatus(200);
    }

    public function test_products_launched_displays_the_products_newest_page()
    {
        $response = $this->get(route('products.launched'));

        $response->assertStatus(200);
        $response->assertViewIs('products.launched');
    }
}
