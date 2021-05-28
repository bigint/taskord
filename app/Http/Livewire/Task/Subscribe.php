<?php

namespace App\Http\Livewire\Task;

use App\Models\Task;
use GrahamCampbell\Throttle\Facades\Throttle;
use Helper;
use Illuminate\Support\Facades\Gate;
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

        if (Gate::denies('praise', $this->question)) {
            return toast($this, 'error', "Oops! You can't perform this action");
        }

        auth()->user()->toggleSubscribe($this->task);
        $this->task->refresh();
        auth()->user()->touch();

        return loggy(request(), 'Task', auth()->user(), 'Toggled task subscribe | Task ID: '.$this->task->id);
    }

    public function render()
    {
        return view('livewire.task.subscribe');
    }
}
