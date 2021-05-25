<?php

namespace App\Http\Livewire\Task;

use App\Models\Task;
use GrahamCampbell\Throttle\Facades\Throttle;
use Helper;
use Illuminate\Support\Facades\Request;
use Livewire\Component;

class Subscribe extends Component
{
    public $listeners = [
        'refreshTaskSubscribed' => 'render',
    ];

    public Task $task;

    public function mount($task)
    {
        $this->task = $task;
    }

    public function subscribeTask()
    {
        $throttler = Throttle::get(Request::instance(), 10, 5);
        $throttler->hit();
        if (count($throttler) > 20) {
            Helper::flagAccount(auth()->user());
        }
        if (! $throttler->check()) {
            loggy(request(), 'Throttle', auth()->user(), 'Rate limited while subscribing to the task');

            return toast($this, 'error', 'Your are rate limited, try again later!');
        }

        if (! auth()->check()) {
            return toast($this, 'error', 'Forbidden!');
        }

        if (! auth()->user()->hasVerifiedEmail()) {
            return toast($this, 'error', 'Your email is not verified!');
        }
        if (auth()->user()->spammy) {
            return toast($this, 'error', 'Your account is flagged!');
        }
        if (auth()->user()->id === $this->task->user->id) {
            return toast($this, 'error', 'You can\'t subscribe your own task!');
        } else {
            auth()->user()->toggleSubscribe($this->task);
            $this->task->refresh();
            auth()->user()->touch();
            loggy(request(), 'Task', auth()->user(), 'Toggled task subscribe | Task ID: '.$this->task->id);
        }
    }

    public function render()
    {
        return view('livewire.task.subscribe');
    }
}
