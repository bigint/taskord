<?php

namespace App\Http\Livewire\User;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Status extends Component
{
    public $user;
    public $status;

    public function mount($user)
    {
        $this->user = $user;
        $this->status = $user->status;
    }

    public function resetStatus()
    {
        if (Auth::check()) {
            Auth::user()->status = null;
            Auth::user()->status_emoji = null;
            Auth::user()->save();
        } else {
            return session()->flash('error', 'Forbidden!');
        }
    }

    public function setStatus()
    {
        if (Auth::check()) {
            Auth::user()->status = $this->status;
            Auth::user()->save();
        } else {
            return session()->flash('error', 'Forbidden!');
        }
    }

    public function render()
    {
        return view('livewire.user.status');
    }
}
