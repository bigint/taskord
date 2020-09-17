<?php

namespace App\Http\Livewire\Task;

use App\Gamify\Points\PraiseCreated;
use App\Gamify\Points\TaskCompleted;
use App\Notifications\TaskPraised;
use App\Notifications\TelegramLogger;
use Carbon\Carbon;
use GrahamCampbell\Throttle\Facades\Throttle;
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
        $throttler = Throttle::get(Request::instance(), 50, 5);
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
            if (Auth::user()->hasLiked($this->task)) {
                Auth::user()->unlike($this->task);
                $this->task->refresh();
                if ($this->task->source !== 'GitHub' and $this->task->source !== 'GitLab') {
                    undoPoint(new PraiseCreated($this->task));
                }
                Auth::user()->touch();
                $this->task->user->notify(
                    new TelegramLogger(
                        '*👏 Task was un-praised* by @'
                        .Auth::user()->username."\n\n"
                        .$this->task->task."\n\nhttps://taskord.com/task/"
                        .$this->task->id
                    )
                );
            } else {
                Auth::user()->like($this->task);
                $this->task->refresh();
                $this->task->user->notify(new TaskPraised($this->task, Auth::id()));
                if ($this->task->source !== 'GitHub' and $this->task->source !== 'GitLab') {
                    givePoint(new PraiseCreated($this->task));
                }
                Auth::user()->touch();
                $this->task->user->notify(
                    new TelegramLogger(
                        '*👏 Task was praised* by @'
                        .Auth::user()->username."\n\n"
                        .$this->task->task."\n\nhttps://taskord.com/task/"
                        .$this->task->id
                    )
                );
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
        return view('livewire.task.single-task');
    }
}
