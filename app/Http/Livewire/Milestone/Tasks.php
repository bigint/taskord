<?php

namespace App\Http\Livewire\Milestone;

use App\Models\Milestone;
use Livewire\Component;

class Tasks extends Component
{
    public Milestone $milestone;
    public $page;
    public $ready_to_load = false;

    public $listeners = [
        'refreshTasks' => 'render',
    ];

    public function mount($milestone, $page)
    {
        $this->milestone = $milestone;
        $this->page = $page ? $page : 1;
    }

    public function loadTasks()
    {
        $this->ready_to_load = true;
    }

    public function getTasks()
    {
        return $this->milestone->tasks()
            ->orderBy('created_at', 'desc')
            ->paginate(10, '*', null, $this->page);
    }

    public function render()
    {
        return view('livewire.milestone.tasks', [
            'tasks' => $this->ready_to_load ? $this->getTasks() : [],
            'page' => $this->page,
        ]);
    }
}
