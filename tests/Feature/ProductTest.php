<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;

class ProductTest extends TestCase
{
    public function test_product_done_url()
    {
        $response = $this->get(route('product.done', ['slug' => 'taskord']));

        $response->assertStatus(200);
    }

    public function test_product_done_displays_the_product_done_page()
    {
        $response = $this->get(route('product.done', ['slug' => 'taskord']));

        $response->assertStatus(200);
        $response->assertViewIs('product.done');
    }

    public function test_product_pending_url()
    {
        $response = $this->get(route('product.pending', ['slug' => 'taskord']));

        $response->assertStatus(200);
    }

    public function test_product_pending_displays_the_product_pending_page()
    {
        $response = $this->get(route('product.pending', ['slug' => 'taskord']));

        $response->assertStatus(200);
        $response->assertViewIs('product.pending');
    }

    public function test_new_product_url()
    {
        $response = $this->get(route('products.new'));

        $response->assertStatus(302);
    }

    public function test_auth_new_product_url()
    {
        $user = User::where(['email' => 'dabbit@tuta.io'])->first();
        $response = $this->actingAs($user)->get(route('products.new'));

        $response->assertStatus(200);
    }

    public function test_auth_new_product_displays_the_new_product_page()
    {
        $user = User::where(['email' => 'dabbit@tuta.io'])->first();
        $response = $this->actingAs($user)->get(route('products.new'));

        $response->assertStatus(200);
        $response->assertViewIs('product.new');
    }

    public function test_edit_product_url()
    {
        $response = $this->get(route('product.edit', ['slug' => 'taskord']));

        $response->assertStatus(302);
    }
}
