<?php

namespace App\Http\Livewire\Task;

use Livewire\Component;

class Comments extends Component
{
    public $task;
    public $readyToLoad = false;

    public function mount($task)
    {
        $this->task = $task;
    }

    public function loadComments()
    {
        $this->readyToLoad = true;
    }

    public function render()
    {
        return view('livewire.task.comments', [
            'comments' => $this->readyToLoad ? $this->task->comments : [],
        ]);
    }
}
