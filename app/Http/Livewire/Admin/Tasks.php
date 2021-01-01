<?php

namespace App\Http\Livewire\Admin;

use App\Models\Task;
use Livewire\Component;
use Livewire\WithPagination;

class Tasks extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $readyToLoad = false;

    public function loadTasks()
    {
        $this->readyToLoad = true;
    }

    public function render()
    {
        $tasks = Task::latest()->paginate(50);
        $count = Task::all()->count('id');

        return view('livewire.admin.tasks', [
            'tasks' => $this->readyToLoad ? $tasks : [],
            'count' => $this->readyToLoad ? $count : [],
        ]);
    }
}
