<?php

namespace App\Http\Livewire\Task;

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
        'addedToMilestone' => 'render',
    ];

    public Task $task;
    public $launched;
    public $showComments;

    public function mount($task, $showComments = true)
    {
        $this->task = $task;
        $this->showComments = $showComments;
    }

    public function checkTask()
    {
        $throttler = Throttle::get(Request::instance(), 20, 5);
        $throttler->hit();
        if (count($throttler) > 30) {
            Helper::flagAccount(auth()->user());
        }
        if (! $throttler->check()) {
            loggy(request(), 'Throttle', auth()->user(), 'Rate limited while checking a task');

            return $this->dispatchBrowserEvent('toast', [
                'type' => 'error',
                'body' => 'Your are rate limited, try again later!',
            ]);
        }

        if (auth()->check()) {
            if (auth()->user()->id === $this->task->user->id) {
                if ($this->task->done) {
                    $this->task->done_at = carbon();
                    auth()->user()->touch();
                    loggy(request(), 'Task', auth()->user(), 'Updated a task as pending | Task ID: '.$this->task->id);
                } else {
                    $this->task->done_at = carbon();
                    auth()->user()->touch();
                    if (auth()->user()->hasGoal) {
                        auth()->user()->daily_goal_reached++;
                        auth()->user()->save();
                        CheckGoal::dispatch(auth()->user(), $this->task);
                    }
                    givePoint(new TaskCompleted($this->task));
                    loggy(request(), 'Task', auth()->user(), 'Updated a task as done | Task ID: '.$this->task->id);
                }
                $this->task->done = ! $this->task->done;
                $this->task->save();
                $this->emit('taskChecked');

                return true;
            } else {
                return $this->dispatchBrowserEvent('toast', [
                    'type' => 'error',
                    'body' => 'Forbidden!',
                ]);
            }
        } else {
            return $this->dispatchBrowserEvent('toast', [
                'type' => 'error',
                'body' => 'Forbidden!',
            ]);
        }
    }

    public function togglePraise()
    {
        $throttler = Throttle::get(Request::instance(), 30, 5);
        $throttler->hit();
        if (count($throttler) > 30) {
            Helper::flagAccount(auth()->user());
        }
        if (! $throttler->check()) {
            loggy(request(), 'Throttle', auth()->user(), 'Rate limited while praising a task');

            return $this->dispatchBrowserEvent('toast', [
                'type' => 'error',
                'body' => 'Your are rate limited, try again later!',
            ]);
        }

        if (auth()->check()) {
            if (! auth()->user()->hasVerifiedEmail()) {
                return $this->dispatchBrowserEvent('toast', [
                    'type' => 'error',
                    'body' => 'Your email is not verified!',
                ]);
            }

            if (auth()->user()->isFlagged) {
                return $this->dispatchBrowserEvent('toast', [
                    'type' => 'error',
                    'body' => 'Your account is flagged!',
                ]);
            }
            if (auth()->user()->id === $this->task->user->id) {
                return $this->dispatchBrowserEvent('toast', [
                    'type' => 'error',
                    'body' => 'You can\'t praise your own task!',
                ]);
            }
            Helper::togglePraise($this->task, 'TASK');
            loggy(request(), 'Task', auth()->user(), 'Toggled task praise | Task ID: '.$this->task->id);
        } else {
            return $this->dispatchBrowserEvent('toast', [
                'type' => 'error',
                'body' => 'Forbidden!',
            ]);
        }
    }

    public function hide()
    {
        if (auth()->check()) {
            if (auth()->user()->isStaff and auth()->user()->staffShip) {
                Helper::hide($this->task);
                loggy(request(), 'Admin', auth()->user(), 'Toggled task hide | Task ID: '.$this->task->id);

                return $this->dispatchBrowserEvent('toast', [
                    'type' => 'success',
                    'body' => 'Task is hidden from public!',
                ]);
            } else {
                return $this->dispatchBrowserEvent('toast', [
                    'type' => 'error',
                    'body' => 'Forbidden!',
                ]);
            }
        } else {
            return $this->dispatchBrowserEvent('toast', [
                'type' => 'error',
                'body' => 'Forbidden!',
            ]);
        }
    }

    public function deleteTask()
    {
        if (auth()->check()) {
            if (auth()->user()->isFlagged) {
                return $this->dispatchBrowserEvent('toast', [
                    'type' => 'error',
                    'body' => 'Your account is flagged!',
                ]);
            }

            if (auth()->user()->staffShip or auth()->user()->id === $this->task->user->id) {
                loggy(request(), 'Task', auth()->user(), 'Deleted a task | Task ID: '.$this->task->id);
                foreach ($this->task->images ?? [] as $image) {
                    Storage::delete($image);
                }
                $this->task->delete();
                $this->emitUp('taskDeleted');
                auth()->user()->touch();

                return $this->dispatchBrowserEvent('toast', [
                    'type' => 'success',
                    'body' => 'Task has been deleted successfully!',
                ]);
            } else {
                return $this->dispatchBrowserEvent('toast', [
                    'type' => 'error',
                    'body' => 'Forbidden!',
                ]);
            }
        } else {
            return $this->dispatchBrowserEvent('toast', [
                'type' => 'error',
                'body' => 'Forbidden!',
            ]);
        }
    }

    public function render()
    {
        $this->launched = false;
        $launchList = [
            'launched',
            'launch',
            'shipped',
            'ship',
        ];

        $launchFound = false;
        foreach ($launchList as $keyword) {
            if (preg_match("/\b$keyword\b/", strtolower($this->task->task))) {
                $launchFound = true;
                break;
            }
        }

        if (($launchFound and (bool) $this->task->done)) {
            $this->launched = true;
        }

        return view('livewire.task.single-task');
    }
}
