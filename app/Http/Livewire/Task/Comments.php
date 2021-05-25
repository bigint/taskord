<?php

namespace App\Http\Livewire\Task;

use Livewire\Component;

class Comments extends Component
{
    public $task;
    public $ready_to_load = false;

    public function mount($task)
    {
        $this->task = $task;
    }

    public function loadComments()
    {
        $this->ready_to_load = true;
    }

    public function render()
    {
        return view('livewire.task.comments', [
            'comments' => $this->ready_to_load ? $this->task->comments : [],
        ]);
    }
}
