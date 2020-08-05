<?php

namespace App\Http\Livewire\Notification;

use Auth;
use Livewire\Component;

class MarkAsRead extends Component
{
    public function markAsRead()
    {
        Auth::user()->unreadNotifications->markAsRead();
        $this->emit('markAsRead');
    }

    public function render()
    {
        return view('livewire.notification.mark-as-read');
    }
}
