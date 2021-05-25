<?php

namespace App\Http\Livewire\Staff;

use App\Models\Task;
use Livewire\Component;
use Livewire\WithPagination;

class Tasks extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $ready_to_load = false;

    public function loadTasks()
    {
        $this->ready_to_load = true;
    }

    public function getTasks()
    {
        return Task::latest()->paginate(50);
    }

    public function render()
    {
        return view('livewire.staff.tasks', [
            'tasks' => $this->ready_to_load ? $this->getTasks() : [],
            'count' => $this->ready_to_load ? Task::count('id') : [],
        ]);
    }
}
