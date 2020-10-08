<?php

namespace Tests\Feature;

use App\Http\Livewire\Notification\MarkAsRead;
use App\Http\Livewire\Notification\Delete;
use App\Http\Livewire\Notification\Follow;
use App\Http\Livewire\Home\Tasks;
use App\Models\Task;
use App\Models\User;
use Livewire;
use Tests\TestCase;

class NotificationTest extends TestCase
{
    public $user;
    public $user1;
    
    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::find(1);
        $this->user1 = User::find(2);
    }
    
    public function test_see_unread()
    {
        $response = $this->get(route('notifications.unread'));

        $response->assertStatus(302);
    }

    public function test_auth_see_unread()
    {
        $this->actingAs($this->user);
        $response = $this->get(route('notifications.unread'));

        $response->assertStatus(200);
    }
    
    public function test_see_all()
    {
        $response = $this->get(route('notifications.all'));

        $response->assertStatus(302);
    }

    public function test_auth_see_all()
    {
        $this->actingAs($this->user);
        $response = $this->get(route('notifications.all'));

        $response->assertStatus(200);
    }

    public function test_unread_displays_the_unread_page()
    {
        $this->actingAs($this->user);
        $response = $this->get(route('notifications.unread'));

        $response->assertStatus(200);
        $response->assertViewIs('notifications.unread');
    }
    
    public function test_all_displays_the_all_page()
    {
        $this->actingAs($this->user);
        $response = $this->get(route('notifications.all'));

        $response->assertStatus(200);
        $response->assertViewIs('notifications.all');
    }
    
    public function test_click_mark_as_read()
    {
        $this->actingAs($this->user);

        Livewire::test(MarkAsRead::class)
            ->call('markAsRead')
            ->assertEmitted('markAsRead');
    }
    
    public function test_click_delete()
    {
        $this->actingAs($this->user);

        Livewire::test(Delete::class)
            ->call('deleteAll')
            ->assertEmitted('deleteAll');
    }
    
    public function test_follow_user()
    {
        $this->actingAs($this->user);

        Livewire::test(Follow::class, ['user' => $this->user1])
            ->call('followUser');
    }
}
