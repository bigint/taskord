<?php

namespace App\Http\Livewire\Task;

use App\Notifications\Subscribed;
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
            return session()->flash('error', 'Please slow down!');
        }

        if (Auth::check()) {
            if (! Auth::user()->hasVerifiedEmail()) {
                return session()->flash('error', 'Your email is not verified!');
            }
            if (Auth::user()->isFlagged) {
                return session()->flash('error', 'Your account is flagged!');
            }
            if (Auth::id() === $this->task->user->id) {
                return session()->flash('error', 'You can\'t subscribe your own task!');
            } else {
                Auth::user()->toggleSubscribe($this->task);
                $this->task->refresh();
                Auth::user()->touch();
            }
        } else {
            return session()->flash('error', 'Forbidden!');
        }
    }
    
    public function render()
    {
        return view('livewire.task.subscribe');
    }
}
