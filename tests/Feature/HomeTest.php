<?php

namespace Tests\Feature;

use App\Http\Livewire\Home\Onboarding;
use App\Http\Livewire\Home\OnlyFollowing;
use App\Http\Livewire\Home\LoadMore;
use App\Http\Livewire\Home\Tasks;
use App\Models\Answer;
use App\Models\Question;
use App\Models\User;
use Livewire;
use Tests\TestCase;

class HomeTest extends TestCase
{
    public $user;
    public $onboarded_user;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::find(10);
        $this->onboarded_user = User::find(1);
    }
    
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
    
    public function test_see_onboarding()
    {
        $this->actingAs($this->user);
        
        Livewire::test(Onboarding::class)
            ->assertSeeHtml('Getting Started');
    }
    
    public function test_done_see_onboarding()
    {
        $this->actingAs($this->onboarded_user);
        
        Livewire::test(Onboarding::class)
            ->assertDontSeeHtml('Getting Started');
    }
    
    public function test_toggle_only_following()
    {
        $this->actingAs($this->user);
        
        Livewire::test(OnlyFollowing::class)
            ->call('onlyFollowingsTasks')
            ->assertEmitted('onlyFollowings');
    }
}
