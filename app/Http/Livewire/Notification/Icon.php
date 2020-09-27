<?php

namespace App\Http\Livewire\Notification;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Icon extends Component
{
    public function render()
    {
        return view('livewire.notification.icon');
    }
}
