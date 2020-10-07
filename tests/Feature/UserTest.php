<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Http\Livewire\User\Follow;
use App\Models\User;
use Livewire;

class UserTest extends TestCase
{
    public $user1;
    public $user2;

    public function setUp(): void
    {
        parent::setUp();
        $this->user1 = User::find(1);
        $this->user2 = User::find(2);
    }
    
    public function test_user_done_url()
    {
        $response = $this->get(route('user.done', ['username' => 'test']));

        $response->assertStatus(200);
    }

    public function test_user_done_displays_the_user_done_page()
    {
        $response = $this->get(route('user.done', ['username' => 'test']));

        $response->assertStatus(200);
        $response->assertViewIs('user.done');
    }

    public function test_user_pending_url()
    {
        $response = $this->get(route('user.pending', ['username' => 'test']));

        $response->assertStatus(200);
    }

    public function test_user_pending_displays_the_user_pending_page()
    {
        $response = $this->get(route('user.pending', ['username' => 'test']));

        $response->assertStatus(200);
        $response->assertViewIs('user.pending');
    }

    public function test_user_products_url()
    {
        $response = $this->get(route('user.products', ['username' => 'test']));

        $response->assertStatus(200);
    }

    public function test_user_products_displays_the_user_products_page()
    {
        $response = $this->get(route('user.products', ['username' => 'test']));

        $response->assertStatus(200);
        $response->assertViewIs('user.products');
    }

    public function test_user_questions_url()
    {
        $response = $this->get(route('user.questions', ['username' => 'test']));

        $response->assertStatus(200);
    }

    public function test_user_questions_displays_the_user_questions_page()
    {
        $response = $this->get(route('user.questions', ['username' => 'test']));

        $response->assertStatus(200);
        $response->assertViewIs('user.questions');
    }

    public function test_user_answers_url()
    {
        $response = $this->get(route('user.answers', ['username' => 'test']));

        $response->assertStatus(200);
    }

    public function test_user_answers_displays_the_user_answers_page()
    {
        $response = $this->get(route('user.answers', ['username' => 'test']));

        $response->assertStatus(200);
        $response->assertViewIs('user.answers');
    }
    
    public function test_follow_other_user()
    {
        $this->actingAs($this->user1);
        
        Livewire::test(Follow::class, ['user' => $this->user2])
            ->call('followUser');
    }
}
