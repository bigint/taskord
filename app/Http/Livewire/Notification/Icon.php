<?php

namespace App\Http\Livewire\Notification;

use App\Jobs\AuthGetIP;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Icon extends Component
{
    public function render()
    {
        if (Auth::check()) {
            AuthGetIP::dispatch(Auth::user(), request()->ip());
        }

        return view('livewire.notification.icon');
    }
}
