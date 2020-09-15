<?php

namespace App\Http\Livewire\Notification;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Icon extends Component
{
    public function render()
    {
        if (Auth::check()) {
            Auth::user()->lastIP = request()->ip();
            Auth::user()->save();
        }
        return view('livewire.notification.icon');
    }
}
