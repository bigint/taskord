<?php

namespace App\Http\Livewire\Tasks;

use App\Gamify\Points\TaskCompleted;
use App\Jobs\CheckGoal;
use App\Models\Task;
use GrahamCampbell\Throttle\Facades\Throttle;
use Helper;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class SingleTask extends Component
{
    public $listeners = [
        'refreshSingleTask' => 'render',
    ];

    public Task $task;
    public $show_delete = true;

    public function mount($task)
    {
        $this->task = $task;
    }

    public function checkTask()
    {
        $throttler = Throttle::get(Request::instance(), 20, 5);
        $throttler->hit();
        if (count($throttler) > 30) {
            Helper::flagAccount(auth()->user());
        }
        if (! $throttler->check()) {
            loggy(request(), 'Throttle', auth()->user(), 'Rate limited while praising a task');

            return toast($this, 'error', 'Your are rate limited, try again later!');
        }

        if (auth()->check()) {
            $this->task->done = ! $this->task->done;
            $this->task->done_at = carbon();
            auth()->user()->touch();
            givePoint(new TaskCompleted($this->task));
            $this->task->save();
            $this->emit('refreshTasks');
            if (auth()->user()->hasGoal and $this->task->done) {
                auth()->user()->daily_goal_reached++;
                auth()->user()->save();
                CheckGoal::dispatch(auth()->user(), $this->task);
            }
            loggy(request(), 'Task', auth()->user(), 'Updated a task as done | Task ID: '.$this->task->id);

            return true;
        } else {
            return toast($this, 'error', 'Forbidden!');
        }
    }

    public function deleteTask()
    {
        if (auth()->check()) {
            if (auth()->user()->isFlagged) {
                return toast($this, 'error', 'Your account is flagged!');
            }

            if (auth()->user()->staffShip or auth()->user()->id === $this->task->user->id) {
                loggy(request(), 'Task', auth()->user(), 'Deleted a task | Task ID: '.$this->task->id);
                foreach ($this->task->images ?? [] as $image) {
                    Storage::delete($image);
                }
                $this->task->delete();
                $this->emitUp('refreshTasks');
                auth()->user()->touch();
            } else {
                return toast($this, 'error', 'Forbidden!');
            }
        } else {
            return toast($this, 'error', 'Forbidden!');
        }
    }

    public function render()
    {
        return view('livewire.tasks.single-task');
    }
}
