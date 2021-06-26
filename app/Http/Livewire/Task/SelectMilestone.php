<?php

namespace App\Http\Livewire\Task;

use App\Models\Milestone;
use App\Models\Task;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Gate;
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
        $this->emitUp('refreshSingleTask');
        loggy(request(), 'Milestone', auth()->user(), "Removed milestone from the task | Task ID: {$this->task->id}");

        return toast($this, 'success', 'Milestone has been removed from the task!');
    }

    public function selectMilestone(Milestone $milestone)
    {
        $milestone = Milestone::find($milestone->id);

        if (Gate::denies('edit/delete', $milestone)) {
            return toast($this, 'error', config('taskord.toast.deny'));
        }

        $this->task->milestone()->associate($milestone);
        $this->task->save();
        $this->emitUp('refreshSingleTask');
        loggy(request(), 'Milestone', auth()->user(), "Added milestone to the task | Task ID: {$this->task->id}");

        return toast($this, 'success', "Task has been added to the milestone <b>{$milestone->name}</b>");
    }

    public function render(): View
    {
        return view('livewire.task.select-milestone');
    }
}
