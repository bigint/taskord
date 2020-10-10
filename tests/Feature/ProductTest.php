<?php

namespace Tests\Feature;

use App\Http\Livewire\Product\EditProduct;
use App\Http\Livewire\Product\NewProduct;
use App\Http\Livewire\Product\Subscribe;
use App\Http\Livewire\Product\AddMember;
use App\Http\Livewire\Product\Leave;
use App\Http\Livewire\Product\LoadMore;
use App\Http\Livewire\Product\Subscribers;
use App\Http\Livewire\Product\Team;
use App\Http\Livewire\Product\Tasks;
use App\Http\Livewire\Product\Updates;
use App\Http\Livewire\Product\Update\NewUpdate;
use App\Http\Livewire\Product\Update\SingleUpdate;
use App\Models\Product;
use App\Models\ProductUpdate;
use App\Models\User;
use App\Models\Question;
use App\Models\Task;
use Illuminate\Support\Str;
use Livewire;
use Tests\TestCase;

class ProductTest extends TestCase
{
    public $user;
    public $product;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::find(1);
        $this->product = Product::find(1);
    }

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

    public function test_create_product()
    {
        Livewire::test(NewProduct::class)
            ->set('name', 'Test Product')
            ->set('slug', Str::random(5))
            ->set('description', 'Test Product Description')
            ->set('website', 'https://taskord.com')
            ->set('twitter', 'phpunit')
            ->set('repo', 'https://gitlab.com/taskord/taskord')
            ->set('producthunt', 'phpunit')
            ->set('sponsor', 'https://taskord.com/patron')
            ->set('launched', true)
            ->call('submit')
            ->assertSeeHtml('Forbidden!');
    }

    public function test_auth_create_product()
    {
        $this->actingAs($this->user);

        Livewire::test(NewProduct::class)
            ->set('name', 'Test Product')
            ->set('slug', Str::random(5))
            ->set('description', 'Test Product Description')
            ->set('website', 'https://taskord.com')
            ->set('twitter', 'phpunit')
            ->set('repo', 'https://gitlab.com/taskord/taskord')
            ->set('producthunt', 'phpunit')
            ->set('sponsor', 'https://taskord.com/patron')
            ->call('submit')
            ->assertStatus(200);
    }

    public function test_auth_create_product_required()
    {
        $this->actingAs($this->user);

        Livewire::test(NewProduct::class)
            ->set('description', 'Test Product Description')
            ->set('website', 'phpunit')
            ->set('twitter', 'phpunit')
            ->set('repo', 'https://gitlab.com/taskord/taskord')
            ->set('producthunt', 'phpunit')
            ->set('sponsor', 'https://taskord.com/patron')
            ->set('launched', true)
            ->call('submit')
            ->assertHasErrors([
                'slug' => 'required',
                'name' => 'required',
            ]);
    }

    public function test_auth_create_product_repo_validation()
    {
        $this->actingAs($this->user);

        Livewire::test(NewProduct::class)
            ->set('name', 'Test Product')
            ->set('slug', Str::random(5))
            ->set('description', 'Test Product Description')
            ->set('website', 'https://taskord.com')
            ->set('twitter', 'phpunit')
            ->set('repo', 'https://gitlab.com')
            ->set('producthunt', 'phpunit')
            ->set('sponsor', 'https://taskord.com/patron')
            ->call('submit')
            ->assertSeeHtml('Repo should be GitHub / GitLab / Bitbucket URL');
    }

    public function test_edit_product()
    {
        $product = Product::find(10);
        
        Livewire::test(EditProduct::class, ['product' => $product])
            ->set('name', 'Test Product')
            ->set('slug', Str::random(5))
            ->set('description', 'Test Product Description')
            ->set('website', 'https://taskord.com')
            ->set('twitter', 'phpunit')
            ->set('repo', 'https://gitlab.com/taskord/taskord')
            ->set('producthunt', 'phpunit')
            ->set('sponsor', 'https://taskord.com/patron')
            ->set('launched', true)
            ->call('submit')
            ->assertSeeHtml('Forbidden!');
    }

    public function test_auth_edit_product()
    {
        $this->actingAs($this->user);
        $product = Product::find(10);

        Livewire::test(EditProduct::class, ['product' => $product])
            ->set('name', 'Test Product')
            ->set('slug', Str::random(5))
            ->set('description', 'Test Product Description')
            ->set('website', 'https://taskord.com')
            ->set('twitter', 'phpunit')
            ->set('repo', 'https://gitlab.com/taskord/taskord')
            ->set('producthunt', 'phpunit')
            ->set('sponsor', 'https://taskord.com/patron')
            ->call('submit')
            ->assertStatus(200);
    }

    public function test_auth_edit_product_repo_validation()
    {
        $this->actingAs($this->user);

        Livewire::test(EditProduct::class, ['product' => $this->product])
            ->set('name', 'Test Product')
            ->set('slug', Str::random(5))
            ->set('description', 'Test Product Description')
            ->set('website', 'https://taskord.com')
            ->set('twitter', 'phpunit')
            ->set('repo', 'https://gitlab.com')
            ->set('producthunt', 'phpunit')
            ->set('sponsor', 'https://taskord.com/patron')
            ->call('submit')
            ->assertSeeHtml('Repo should be GitHub / GitLab / Bitbucket URL');
    }

    public function test_create_product_update()
    {
        Livewire::test(NewUpdate::class, ['product' => $this->product])
            ->set('title', md5(microtime()))
            ->set('body', md5(microtime()))
            ->call('submit')
            ->assertSeeHtml('Forbidden!');
    }

    public function test_auth_product_update()
    {
        $this->actingAs($this->user);

        Livewire::test(NewUpdate::class, ['product' => $this->product])
            ->set('title', md5(microtime()))
            ->call('submit')
            ->assertHasErrors(['body' => 'required'])
            ->set('body', md5(microtime()))
            ->call('submit')
            ->assertStatus(200);
    }

    public function test_auth_product_update_required()
    {
        $this->actingAs($this->user);

        Livewire::test(NewUpdate::class, ['product' => $this->product])
            ->call('submit')
            ->assertHasErrors([
                'title' => 'required',
                'body' => 'required',
            ])
            ->assertSeeHtml('The title field is required.')
            ->assertSeeHtml('The body field is required.');
    }

    public function test_subscribe_product()
    {
        $this->actingAs($this->user);

        Livewire::test(Subscribe::class, ['product' => $this->product])
            ->call('subscribeProduct');
    }
    
    public function test_see_subscribers()
    {
        Livewire::test(Subscribers::class, ['product' => $this->product])
            ->assertStatus(200);
    }

    public function test_see_done_tasks()
    {
        $task = Task::where([
            ['product_id', $this->product->id],
            ['done', true],
        ])
            ->latest()
            ->first();

        Livewire::test(Tasks::class, ['product' => $this->product, 'type' => 'product.done', 'page' => 1])
            ->assertSeeHtml($task->task);
    }

    public function test_see_pending_tasks()
    {
        $task = Task::where([
            ['product_id', $this->product->id],
            ['done', false],
        ])
            ->latest()
            ->first();

        Livewire::test(Tasks::class, ['product' => $this->product, 'type' => 'product.pending', 'page' => 1])
            ->assertSeeHtml($task->task);
    }

    public function test_load_more_done_tasks()
    {
        Livewire::test(LoadMore::class, ['product' => $this->product, 'type' => 'product.done', 'page' => 1])
            ->call('loadMore')
            ->assertStatus(200);
    }

    public function test_load_more_pending_tasks()
    {
        Livewire::test(LoadMore::class, ['product' => $this->product, 'type' => 'product.pending', 'page' => 1])
            ->call('loadMore')
            ->assertStatus(200);
    }
    
    public function test_see_single_update()
    {
        $update = ProductUpdate::create([
            'user_id' =>  $this->user->id,
            'product_id' =>  $this->product->id,
            'title' => 'Test Update',
            'body' => 'Test Update',
        ]);

        Livewire::test(SingleUpdate::class, ['update' => $update])
            ->assertSeeHtml($update->title);
    }
    
    public function test_praise_single_update()
    {
        $this->actingAs($this->user);
        $update = ProductUpdate::create([
            'user_id' =>  $this->user->id,
            'product_id' =>  $this->product->id,
            'title' => 'Test Update',
            'body' => 'Test Update',
        ]);

        Livewire::test(SingleUpdate::class, ['update' => $update])
            ->call('togglePraise')
            ->assertStatus(200);
    }
    
    public function test_delete_single_update()
    {
        $this->actingAs($this->user);
        $update = ProductUpdate::create([
            'user_id' =>  $this->user->id,
            'product_id' =>  $this->product->id,
            'title' => 'Test Update',
            'body' => 'Test Update',
        ]);

        Livewire::test(SingleUpdate::class, ['update' => $update])
            ->call('confirmDelete')
            ->call('deleteUpdate')
            ->assertEmitted('updateDeleted');
    }
}
