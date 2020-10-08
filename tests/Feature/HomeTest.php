<?php

namespace Tests\Feature;

use App\Http\Livewire\Home\Onboarding;
use App\Http\Livewire\Answer\CreateAnswer;
use App\Http\Livewire\Answer\LoadMore;
use App\Http\Livewire\Answer\SingleAnswer;
use App\Models\Answer;
use App\Models\Question;
use App\Models\User;
use Livewire;
use Tests\TestCase;

class HomeTest extends TestCase
{
    public $user;
    public $unverified;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::find(10);
        $this->onboarded_user = User::find(1);
        $this->unverified = User::find(2);
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
}
