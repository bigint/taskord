<?php

namespace Tests\Feature;

use App\Http\Livewire\User\Follow;
use App\Http\Livewire\User\Moderator;
use App\Models\User;
use Livewire;
use Tests\TestCase;

class UserTest extends TestCase
{
    public $admin;
    public $target;

    public function setUp(): void
    {
        parent::setUp();
        $this->admin = User::find(1);
        $this->target = User::find(10);
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
        $this->actingAs($this->admin);

        Livewire::test(Follow::class, ['user' => $this->target])
            ->call('followUser');
    }
    
    public function test_mod_enroll_beta()
    {
        $this->actingAs($this->admin);

        Livewire::test(Moderator::class, ['user' => $this->target])
            ->call('enrollBeta')
            ->assertStatus(200);
    }
    
    public function test_mod_enroll_staff()
    {
        $this->actingAs($this->admin);

        Livewire::test(Moderator::class, ['user' => $this->target])
            ->call('enrollStaff')
            ->assertStatus(200);
    }
    
    public function test_mod_enroll_developer()
    {
        $this->actingAs($this->admin);

        Livewire::test(Moderator::class, ['user' => $this->target])
            ->call('enrollDeveloper')
            ->assertStatus(200);
    }
    
    public function test_mod_enroll_private()
    {
        $this->actingAs($this->admin);

        Livewire::test(Moderator::class, ['user' => $this->target])
            ->call('privateUser')
            ->assertStatus(200);
    }
    
    public function test_mod_flag_user()
    {
        $this->actingAs($this->admin);

        Livewire::test(Moderator::class, ['user' => $this->target])
            ->call('flagUser')
            ->assertStatus(200);
    }
    
    public function test_mod_suspend_user()
    {
        $this->actingAs($this->admin);

        Livewire::test(Moderator::class, ['user' => $this->target])
            ->call('suspendUser')
            ->assertStatus(200);
    }
    
    public function test_mod_enroll_patron()
    {
        $this->actingAs($this->admin);

        Livewire::test(Moderator::class, ['user' => $this->target])
            ->call('enrollPatron')
            ->assertStatus(200);
    }
    
    public function test_mod_enroll_dark_mode()
    {
        $this->actingAs($this->admin);

        Livewire::test(Moderator::class, ['user' => $this->target])
            ->call('enrollDarkMode')
            ->assertStatus(200);
    }
    
    public function test_mod_verify_user()
    {
        $this->actingAs($this->admin);

        Livewire::test(Moderator::class, ['user' => $this->target])
            ->call('verifyUser')
            ->assertStatus(200);
    }
}
