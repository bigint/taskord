<?php

namespace App\Http\Livewire\Tasks;

use Livewire\Component;
use Livewire\WithPagination;

class AllTasks extends Component
{
    public $listeners = [
        'refreshTasks' => 'render',
    ];
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $ready_to_load = false;

    public function loadAllTasks()
    {
        $this->ready_to_load = true;
    }

    public function getAllTasks()
    {
        return auth()->user()->tasks()
            ->whereDone(false)
            ->latest()
            ->paginate(30);
    }

    public function render()
    {
        return view('livewire.tasks.all-tasks', [
            'tasks' => $this->ready_to_load ? $this->getAllTasks() : [],
        ]);
    }
}
