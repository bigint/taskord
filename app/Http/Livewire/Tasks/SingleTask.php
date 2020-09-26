<?php

namespace App\Http\Livewire\Tasks;

use App\Gamify\Points\TaskCompleted;
use App\Jobs\CheckGoal;
use App\Notifications\TelegramLogger;
use Carbon\Carbon;
use GrahamCampbell\Throttle\Facades\Throttle;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
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
        $throttler = Throttle::get(Request::instance(), 20, 5);
        $throttler->hit();
        if (! $throttler->check()) {
            return session()->flash('error', 'Your are rate limited, try again later!');
        }

        if (Auth::check()) {
            $this->task->done = ! $this->task->done;
            $this->task->done_at = Carbon::now();
            Auth::user()->touch();
            givePoint(new TaskCompleted($this->task));
            $this->task->save();
            $this->emit('taskChecked');
            if (Auth::user()->hasGoal and $this->task->done) {
                Auth::user()->daily_goal_reached++;
                Auth::user()->save();
                CheckGoal::dispatch(Auth::user());
            }
            $this->task->user->notify(
                new TelegramLogger(
                    '*✅ Task was mark as done* by @'
                    .Auth::user()->username."\n\n"
                    .$this->task->task."\n\nhttps://taskord.com/task/"
                    .$this->task->id
                )
            );

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
