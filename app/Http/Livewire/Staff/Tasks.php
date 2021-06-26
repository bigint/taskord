<?php

namespace App\Http\Livewire\Staff;

use App\Models\Task;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class Tasks extends Component
{
    use WithPagination;

    public $readyToLoad = false;
    protected $paginationTheme = 'bootstrap';

    public function loadTasks()
    {
        $this->readyToLoad = true;
    }

    public function getTasks()
    {
        return Task::latest()->paginate(50);
    }

    public function render(): View
    {
        return view('livewire.staff.tasks', [
            'tasks' => $this->readyToLoad ? $this->getTasks() : [],
            'count' => $this->readyToLoad ? Task::count('id') : [],
        ]);
    }
}
