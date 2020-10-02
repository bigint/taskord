<?php

namespace Tests\Feature;

use App\Http\Livewire\Pages\CreateDeal;
use App\Models\Task;
use App\Models\User;
use Livewire;
use Tests\TestCase;

class PagesTest extends TestCase
{
    public function test_deals_url()
    {
        $response = $this->get(route('deals'));

        $response->assertStatus(200);
    }

    public function test_deals_displays_the_deals_page()
    {
        $response = $this->get(route('deals'));

        $response->assertStatus(200);
        $response->assertViewIs('pages.deals');
    }

    public function test_create_deal()
    {
        Livewire::test(CreateDeal::class)
            ->set('name', "Test Deal")
            ->set('description', "Test Deal Dexription")
            ->set('offer', "20")
            ->set('coupon', "TASKORDTEST")
            ->set('website', "https://taskord.com")
            ->set('logo', "https://taskord.com/images/logo.svg")
            ->call('submit')
            ->assertSeeHtml('Forbidden!');
    }

    public function test_admin_create_deal()
    {
        $this->actingAs($this->user);
        
        Livewire::test(CreateDeal::class)
            ->set('name', "Test Deal")
            ->set('description', "Test Deal Dexription")
            ->set('offer', "20")
            ->set('coupon', "TASKORDTEST")
            ->set('website', "https://taskord.com")
            ->set('logo', "https://taskord.com/images/logo.svg")
            ->call('submit')
            ->assertRedirect('/deals');
    }

    public function test_admin_create_deal_required()
    {
        $this->actingAs($this->user);
        
        Livewire::test(CreateDeal::class)
            ->call('submit')
            ->assertHasErrors([
                'name' => 'required',
                'description' => 'required',
                'offer' => 'required',
                'website' => 'required',
                'logo' => 'required',
            ])
            ->assertSeeHtml('The name field is required.');
    }
}
