<?php

namespace App\Http\Livewire\Notification;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Jobs\AuthGetIP;

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
