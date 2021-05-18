<?php

namespace App\Http\Livewire\Task;

use App\Models\Milestone;
use App\Models\Task;
use Livewire\Component;

class SelectMilestone extends Component
{
    public Task $task;

    public function mount($task)
    {
        $this->task = $task;
    }

    public function noMilestone()
    {
        $this->task->milestone()->disassociate();
        $this->task->save();
        $this->emitUp('addedToMilestone');
        loggy(request(), 'Milestone', auth()->user(), 'Removed milestone from the task | Task ID: '.$this->task->id);

        return $this->dispatchBrowserEvent('toast', [
            'type' => 'success',
            'body' => 'Milestone has been removed from the task!',
        ]);
    }

    public function selectMilestone(Milestone $milestone)
    {
        $milestone = Milestone::find($milestone->id);
        $this->task->milestone()->associate($milestone);
        $this->task->save();
        $this->emitUp('addedToMilestone');
        loggy(request(), 'Milestone', auth()->user(), 'Added milestone to the task | Task ID: '.$this->task->id);

        return $this->dispatchBrowserEvent('toast', [
            'type' => 'success',
            'body' => 'Task has been added to the milestone #'.$milestone->id,
        ]);
    }

    public function render()
    {
        return view('livewire.task.select-milestone');
    }
}
