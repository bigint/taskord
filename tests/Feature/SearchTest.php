<?php

namespace Tests\Feature;

use App\Http\Livewire\Search;
use App\Models\Task;
use Livewire;
use Tests\TestCase;

class SearchTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_search()
    {
        Task::create([
            'user_id' => 1,
            'task' => 'Test Search',
            'source' => 'PHPUnit',
            'done' => true,
        ]);

        Livewire::test(Search::class)
            ->set('query', 'Test Search')
            ->assertSee('Test Search')
            ->set('query', '')
            ->assertDontSee('Test Search');
    }
    
    public function test_search_url()
    {
        $response = $this->get(route('search.home'));

        $response->assertStatus(200);
    }

    public function test_search_displays_the_search_page()
    {
        $response = $this->get(route('search.home'));

        $response->assertStatus(200);
        $response->assertViewIs('search.search');
    }
    
    public function test_empty_search_tasks_url()
    {
        $response = $this->get(route('search.tasks'));

        $response->assertStatus(302);
    }

    public function test_search_tasks_url()
    {
        $response = $this->get(route('search.tasks', ['q' => 'a']));

        $response->assertStatus(200);
    }

    public function test_search_tasks_displays_the_search_tasks_page()
    {
        $response = $this->get(route('search.tasks', ['q' => 'a']));

        $response->assertStatus(200);
        $response->assertViewIs('search.result');
    }
}
