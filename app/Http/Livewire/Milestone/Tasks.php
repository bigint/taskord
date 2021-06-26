<?php

namespace App\Http\Livewire\Milestone;

use App\Models\Milestone;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Tasks extends Component
{
    public Milestone $milestone;
    public $page;
    public $readyToLoad = false;

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
        $this->readyToLoad = true;
    }

    public function getTasks()
    {
        return $this->milestone->tasks()
            ->with(['user', 'product', 'milestone', 'comments.user', 'oembed'])
            ->orderBy('created_at', 'desc')
            ->paginate(10, '*', null, $this->page);
    }

    public function render(): View
    {
        return view('livewire.milestone.tasks', [
            'tasks' => $this->readyToLoad ? $this->getTasks() : [],
            'page' => $this->page,
        ]);
    }
}
