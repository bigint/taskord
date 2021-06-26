<?php

namespace App\Http\Livewire\Task;

use Illuminate\Contracts\View\View;
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

    public function getComments()
    {
        return $this->task->comments()
            ->with(['user'])
            ->withCount('replies')
            ->oldest()
            ->get();
    }

    public function render(): View
    {
        return view('livewire.task.comments', [
            'comments' => $this->readyToLoad ? $this->getComments() : [],
        ]);
    }
}
