<?php

namespace App\Http\Livewire\Tasks;

use App\Gamify\Points\TaskCompleted;
use App\Jobs\CheckGoal;
use Carbon\Carbon;
use GrahamCampbell\Throttle\Facades\Throttle;
use Helper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Storage;
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
        if (count($throttler) > 30) {
            Helper::flagAccount(Auth::user());
        }
        if (! $throttler->check()) {
            activity()
                ->withProperties(['type' => 'Throttle'])
                ->log('Rate limited while praising the task');

            return $this->alert('warning', 'Your are rate limited, try again later!', [
                'showCancelButton' => true,
            ]);
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
                CheckGoal::dispatch(Auth::user(), $this->task);
            }
            activity()
                ->withProperties(['type' => 'Task'])
                ->log('Task was marked as done T: '.$this->task->id);

            return true;
        } else {
            return $this->alert('error', 'Forbidden!', [
                'showCancelButton' => true,
            ]);
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
                return $this->alert('error', 'Your account is flagged!', [
                    'showCancelButton' => true,
                ]);
            }

            if (Auth::user()->staffShip or Auth::id() === $this->task->user->id) {
                activity()
                    ->withProperties(['type' => 'Task'])
                    ->log('Task was deleted T: '.$this->task->id);
                foreach ($this->task->images ?? [] as $image) {
                    Storage::delete($image);
                }
                $this->task->delete();
                $this->emitUp('taskDeleted');
                Auth::user()->touch();
            } else {
                return $this->alert('error', 'Forbidden!', [
                    'showCancelButton' => true,
                ]);
            }
        } else {
            return $this->alert('error', 'Forbidden!', [
                'showCancelButton' => true,
            ]);
        }
    }

    public function render()
    {
        return view('livewire.tasks.single-task');
    }
}
