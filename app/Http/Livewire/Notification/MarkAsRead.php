<?php

namespace App\Http\Livewire\Notification;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class MarkAsRead extends Component
{
    public function markAsRead()
    {
        if (Auth::check()) {
            Auth::user()->unreadNotifications->markAsRead();
            $this->emit('markAsRead');
            Auth::user()->touch();
        } else {
            return session()->flash('global', 'Forbidden!');
        }
    }

    public function render()
    {
        return view('livewire.notification.mark-as-read');
    }
}
