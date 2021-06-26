<?php

namespace App\Http\Livewire\Tasks;

use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class AllTasks extends Component
{
    use WithPagination;

    public $listeners = [
        'refreshTasks' => 'render',
    ];

    public $readyToLoad = false;
    protected $paginationTheme = 'bootstrap';

    public function loadAllTasks()
    {
        $this->readyToLoad = true;
    }

    public function getAllTasks()
    {
        return auth()->user()->tasks()
            ->whereDone(false)
            ->latest()
            ->paginate(30);
    }

    public function render(): View
    {
        return view('livewire.tasks.all-tasks', [
            'tasks' => $this->readyToLoad ? $this->getAllTasks() : [],
        ]);
    }
}
