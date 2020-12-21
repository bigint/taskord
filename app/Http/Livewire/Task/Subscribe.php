<?php

namespace App\Http\Livewire\Task;

use GrahamCampbell\Throttle\Facades\Throttle;
use Helper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Livewire\Component;

class Subscribe extends Component
{
    public $listeners = [
        'taskSubscribed' => 'render',
    ];

    public $task;

    public function mount($task)
    {
        $this->task = $task;
    }

    public function subscribeTask()
    {
        $throttler = Throttle::get(Request::instance(), 10, 5);
        $throttler->hit();
        if (count($throttler) > 20) {
            Helper::flagAccount(Auth::user());
        }
        if (! $throttler->check()) {
            activity()
                ->withProperties(['type' => 'Throttle'])
                ->log('Rate limited while subscribing to the task');

            return session()->flash('error', 'Please slow down!');
        }

        if (Auth::check()) {
            if (! Auth::user()->hasVerifiedEmail()) {
                return session()->flash('error', 'Your email is not verified!');
            }
            if (Auth::user()->isFlagged) {
                return $this->alert('error', 'Your account is flagged!', [
                    'showCancelButton' => true,
                ]);
            }
            if (Auth::id() === $this->task->user->id) {
                return $this->alert('warning', 'You can\'t subscribe your own task!', [
                    'showCancelButton' => true,
                ]);
            } else {
                Auth::user()->toggleSubscribe($this->task);
                $this->task->refresh();
                Auth::user()->touch();
                activity()
                    ->withProperties(['type' => 'Task'])
                    ->log('Task subscribe was toggled T: '.$this->task->id);
            }
        } else {
            return $this->alert('error', 'Forbidden!', [
                'showCancelButton' => true,
            ]);
        }
    }

    public function render()
    {
        return view('livewire.task.subscribe');
    }
}
