<?php

namespace App\Http\Livewire\Tasks;

use App\Gamify\Points\TaskCompleted;
use App\Jobs\CheckGoal;
use App\Models\Task;
use GrahamCampbell\Throttle\Facades\Throttle;
use Helper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class SingleTask extends Component
{
    public Task $task;
    public $confirming;

    public function mount($task)
    {
        $this->task = $task;
    }

    public function checkTask()
    {
        $throttler = Throttle::get(Request::instance(), 20, 5);
        $throttler->hit();
        if (count($throttler) > 30) {
            Helper::flagAccount(user());
        }
        if (! $throttler->check()) {
            activity()
                ->withProperties(['type' => 'Throttle'])
                ->log('Rate limited while praising the task');

            return $this->alert('error', 'Your are rate limited, try again later!');
        }

        if (Auth::check()) {
            $this->task->done = ! $this->task->done;
            $this->task->done_at = carbon();
            user()->touch();
            givePoint(new TaskCompleted($this->task));
            $this->task->save();
            $this->emit('taskChecked');
            if (user()->hasGoal and $this->task->done) {
                user()->daily_goal_reached++;
                user()->save();
                CheckGoal::dispatch(user(), $this->task);
            }
            activity()
                ->withProperties(['type' => 'Task'])
                ->log('Updated a task as done | Task ID: '.$this->task->id);

            return true;
        } else {
            return $this->alert('error', 'Forbidden!');
        }
    }

    public function confirmDelete()
    {
        $this->confirming = $this->task->id;
    }

    public function deleteTask()
    {
        if (Auth::check()) {
            if (user()->isFlagged) {
                return $this->alert('error', 'Your account is flagged!');
            }

            if (user()->staffShip or Auth::id() === $this->task->user->id) {
                activity()
                    ->withProperties(['type' => 'Task'])
                    ->log('Deleted a task | Task ID: '.$this->task->id);
                foreach ($this->task->images ?? [] as $image) {
                    Storage::delete($image);
                }
                $this->task->delete();
                $this->emitUp('taskDeleted');
                user()->touch();
            } else {
                return $this->alert('error', 'Forbidden!');
            }
        } else {
            return $this->alert('error', 'Forbidden!');
        }
    }
}
