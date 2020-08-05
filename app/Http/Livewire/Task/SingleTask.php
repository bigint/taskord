<?php

namespace App\Http\Livewire\Task;

use App\Gamify\Points\PraiseCreated;
use App\Gamify\Points\TaskCompleted;
use App\Notifications\TaskPraised;
use App\TaskPraise;
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
            if (Auth::id() === $this->task->user->id) {
                if ($this->task->done) {
                    $this->task->done_at = Carbon::now();
                    $this->task->updated_at = Carbon::now();
                } else {
                    $this->task->done_at = Carbon::now();
                    $this->task->updated_at = Carbon::now();
                    givePoint(new TaskCompleted($this->task));
                }
                $this->task->done = ! $this->task->done;
                $this->task->save();
                $this->emitUp('taskChecked');

                return true;
            } else {
                return session()->flash('error', 'Forbidden!');
            }
        } else {
            return session()->flash('error', 'Forbidden!');
        }
    }

    public function togglePraise()
    {
        if (Auth::check()) {
            if (Auth::user()->isFlagged) {
                return session()->flash('error', 'Your account is flagged!');
            }
            if (Auth::id() === $this->task->user->id) {
                return session()->flash('error', 'You can\'t praise your own task!');
            }
            $isPraised = TaskPraise::where([
                ['user_id', Auth::id()],
                ['task_id', $this->task->id],
            ])->count();
            if ($isPraised === 1) {
                $praise = TaskPraise::where([
                    ['user_id', Auth::id()],
                    ['task_id', $this->task->id],
                ])->first();
                $praise->delete();
                $this->task->refresh();
            } else {
                $praise = TaskPraise::create([
                    'user_id' => Auth::id(),
                    'task_id' => $this->task->id,
                ]);
                $this->task->refresh();
                $this->task->user->notify(new TaskPraised($this->task, Auth::id()));
                givePoint(new PraiseCreated($praise));
            }
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
        return view('livewire.task.single-task');
    }
}
