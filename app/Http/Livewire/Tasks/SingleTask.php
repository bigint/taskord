<?php

namespace App\Http\Livewire\Tasks;

use App\Gamify\Points\TaskCompleted;
use Auth;
use Carbon\Carbon;
use Livewire\Component;

class SingleTask extends Component
{
    public $task;
    public $confirming;

    public function mount($task)
    {
        $this->task = $task;
    }

    public function checkTask()
    {
        if (Auth::check()) {
            $this->task->done = ! $this->task->done;
            $this->task->done_at = Carbon::now();
            $this->task->updated_at = Carbon::now();
            givePoint(new TaskCompleted($this->task));
            $this->task->save();
            $this->emit('taskChecked');

            return true;
        } else {
            return session()->flash('error', 'Forbidden!');
        }
    }

    public function confirmDelete()
    {
        $this->confirming = $this->task->id;
    }

    public function deleteTask()
    {
        if (Auth::check()) {
            if (Auth::user()->isFlagged) {
                return session()->flash('error', 'Your account is flagged!');
            }

            if (Auth::user()->staffShip or Auth::id() === $this->task->user->id) {
                $this->task->delete();
                $this->emitUp('taskDeleted');
            } else {
                return session()->flash('error', 'Forbidden!');
            }
        } else {
            return session()->flash('error', 'Forbidden!');
        }
    }

    public function render()
    {
        return view('livewire.tasks.single-task');
    }
}
