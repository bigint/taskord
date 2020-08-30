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
}
