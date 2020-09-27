<?php

namespace App\Http\Livewire\Task;

use App\Gamify\Points\TaskCompleted;
use App\Jobs\CheckGoal;
use App\Notifications\TelegramLogger;
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
        if (! $throttler->check()) {
            return session()->flash('error', 'Your are rate limited, try again later!');
        }

        if (Auth::check()) {
            if (Auth::id() === $this->task->user->id) {
                if ($this->task->done) {
                    $this->task->done_at = Carbon::now();
                    Auth::user()->touch();
                    $this->task->user->notify(
                        new TelegramLogger(
                            '*⏳ Task was mark as pending* by @'
                            .Auth::user()->username."\n\n"
                            .$this->task->task."\n\nhttps://taskord.com/task/"
                            .$this->task->id
                        )
                    );
                } else {
                    $this->task->done_at = Carbon::now();
                    Auth::user()->touch();
                    if (Auth::user()->hasGoal) {
                        Auth::user()->daily_goal_reached++;
                        Auth::user()->save();
                        CheckGoal::dispatch(Auth::user(), $this->task);
                    }
                    givePoint(new TaskCompleted($this->task));
                    $this->task->user->notify(
                        new TelegramLogger(
                            '*✅ Task was mark as done* by @'
                            .Auth::user()->username."\n\n"
                            .$this->task->task."\n\nhttps://taskord.com/task/"
                            .$this->task->id
                        )
                    );
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
                Storage::delete($this->task->image);
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
