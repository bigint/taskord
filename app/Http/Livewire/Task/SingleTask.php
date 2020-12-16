<?php

namespace App\Http\Livewire\Task;

use App\Gamify\Points\TaskCompleted;
use App\Jobs\CheckGoal;
use Carbon\Carbon;
use GrahamCampbell\Throttle\Facades\Throttle;
use Helper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Component;

class SingleTask extends Component
{
    public $task;
    public $confirming;
    public $launched;
    public $bug;
    public $learn;

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
            return session()->flash('error', 'Your are rate limited, try again later!');
        }

        if (Auth::check()) {
            if (Auth::id() === $this->task->user->id) {
                if ($this->task->done) {
                    $this->task->done_at = Carbon::now();
                    Auth::user()->touch();
                    activity()
                        ->withProperties(['type' => 'Task'])
                        ->log('Task was marked as pending T: ' . $this->task->id);
                } else {
                    $this->task->done_at = Carbon::now();
                    Auth::user()->touch();
                    if (Auth::user()->hasGoal) {
                        Auth::user()->daily_goal_reached++;
                        Auth::user()->save();
                        CheckGoal::dispatch(Auth::user(), $this->task);
                    }
                    givePoint(new TaskCompleted($this->task));
                    activity()
                        ->withProperties(['type' => 'Task'])
                        ->log('Task was marked as done T: ' . $this->task->id);
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
        $throttler = Throttle::get(Request::instance(), 20, 5);
        $throttler->hit();
        if (count($throttler) > 30) {
            Helper::flagAccount(Auth::user());
        }
        if (! $throttler->check()) {
            return session()->flash('error', 'Your are rate limited, try again later!');
        }

        if (Auth::check()) {
            if (! Auth::user()->hasVerifiedEmail()) {
                return session()->flash('warning', 'Your email is not verified!');
            }

            if (Auth::user()->isFlagged) {
                return session()->flash('error', 'Your account is flagged!');
            }
            if (Auth::id() === $this->task->user->id) {
                return session()->flash('error', 'You can\'t praise your own task!');
            }
            Helper::togglePraise($this->task, 'TASK');
            activity()
                ->withProperties(['type' => 'Task'])
                ->log('Task praise was toggled T: ' . $this->task->id);
        } else {
            return session()->flash('error', 'Forbidden!');
        }
    }

    public function hide()
    {
        if (Auth::check()) {
            if (Auth::user()->isStaff and Auth::user()->staffShip) {
                Helper::hide($this->task);
                activity()
                    ->withProperties(['type' => 'Admin'])
                    ->log('Task hide was toggled T: ' . $this->task->id);
            } else {
                return session()->flash('error', 'Forbidden!');
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
                activity()
                    ->withProperties(['type' => 'Task'])
                    ->log('Task was deleted T: ' . $this->task->id);
                foreach ($this->task->images ?? [] as $image) {
                    Storage::delete($image);
                }
                $this->task->delete();
                $this->emitUp('taskDeleted');
                Auth::user()->touch();
            } else {
                return session()->flash('error', 'Forbidden!');
            }
        } else {
            return session()->flash('error', 'Forbidden!');
        }
    }

    public function render()
    {
        $this->launched = false;
        $this->bug = false;
        $this->learn = false;
        $launchList = [
            'launched',
            'launch',
            'shipped',
            'ship',
        ];
        if (Str::contains(strtolower($this->task->task), $launchList) and (bool) $this->task->done) {
            $this->launched = true;
        }

        $bugList = [
            'bug',
            'fix',
            'fixed',
            'fixes',
        ];
        if (Str::contains(strtolower($this->task->task), $bugList) and (bool) $this->task->done) {
            $this->bug = true;
        }

        $learnList = [
            'learned',
            'learning',
            'learn',
        ];
        if (Str::contains(strtolower($this->task->task), $learnList) and (bool) $this->task->done) {
            $this->learn = true;
        }

        return view('livewire.task.single-task');
    }
}
