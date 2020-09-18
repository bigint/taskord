<?php

namespace App\Http\Livewire\Notification;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Carbon\Carbon;

class Icon extends Component
{
    public function render()
    {
        if (Auth::check()) {
            Auth::user()->lastIP = request()->ip();
            Auth::user()->last_active = Carbon::now();
            Auth::user()->save();
        }

        return view('livewire.notification.icon');
    }
}
