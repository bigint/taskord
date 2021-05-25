<?php

namespace App\Http\Livewire\Milestone;

use App\Models\Milestone;
use Livewire\Component;

class LoadMoreTasks extends Component
{
    public $listeners = [
        'refreshTasks' => 'render',
    ];

    public Milestone $milestone;
    public $page;
    public $loadMore;
    public $ready_to_load = true;

    public function mount($milestone, $page = 1)
    {
        $this->milestone = $milestone;
        $this->page = $page + 1;
        $this->loadMore = false;
    }

    public function loadMore()
    {
        $this->loadMore = true;
    }

    public function render()
    {
        if ($this->loadMore) {
            $tasks = $this->milestone->tasks()
                ->orderBy('created_at', 'desc')
                ->paginate(10, '*', null, $this->page);

            return view('livewire.milestone.tasks', [
                'tasks' => $tasks,
            ]);
        } else {
            return view('livewire.load-more');
        }
    }
}
