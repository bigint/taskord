<?php

namespace App\Http\Livewire\Notification\Type\Task;

use App\Models\Task;
use Livewire\Component;

class TaskLiked extends Component
{
    public $data;

    public function mount($data)
    {
        $this->data = $data;
    }

    public function render()
    {
        $task = Task::find($this->data['task_id']);

        return view('livewire.notification.type.task.task-liked', [
            'task' => $task,
        ]);
    }
}
