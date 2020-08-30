<?php

namespace Tests\Feature;

use App\Http\Livewire\Product\NewUpdate;
use App\Models\Product;
use App\Models\User;
use Livewire;
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

    public function test_product_updates_url()
    {
        $response = $this->get(route('product.updates', ['slug' => 'taskord']));

        $response->assertStatus(200);
    }

    public function test_product_updates_displays_the_product_updates_page()
    {
        $response = $this->get(route('product.updates', ['slug' => 'taskord']));

        $response->assertStatus(200);
        $response->assertViewIs('product.updates');
    }

    public function test_create_product_update()
    {
        $product = Product::where(['slug' => 'taskord'])->first();

        Livewire::test(NewUpdate::class, ['product' => $product])
            ->set('title', md5(microtime()))
            ->set('body', md5(microtime()))
            ->call('submit')
            ->assertSeeHtml('Forbidden!');
    }

    public function test_auth_product_update()
    {
        $user = User::where(['email' => 'test@taskord.com'])->first();
        $this->actingAs($user);
        $product = Product::where(['slug' => 'taskord'])->first();

        Livewire::test(NewUpdate::class, ['product' => $product])
            ->set('title', md5(microtime()))
            ->call('submit')
            ->assertHasErrors(['body' => 'required'])
            ->set('body', md5(microtime()))
            ->call('submit')
            ->assertStatus(200);
    }

    public function test_auth_product_update_required()
    {
        $user = User::where(['email' => 'test@taskord.com'])->first();
        $this->actingAs($user);
        $product = Product::where(['slug' => 'taskord'])->first();

        Livewire::test(NewUpdate::class, ['product' => $product])
            ->call('submit')
            ->assertHasErrors([
                'title' => 'required',
                'body' => 'required',
            ])
            ->assertSeeHtml('The title field is required.')
            ->assertSeeHtml('The body field is required.');
    }
}
