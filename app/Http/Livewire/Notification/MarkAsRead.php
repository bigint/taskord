<?php

namespace App\Http\Livewire\Notification;

use Livewire\Component;

class MarkAsRead extends Component
{
    public function markAsRead()
    {
        if (! auth()->check()) {
            return toast($this, 'error', config('taskord.toast.deny'));
        }

        auth()->user()->unreadNotifications->markAsRead();
        $this->emit('refreshNotifications');
        loggy(request(), 'Notification', auth()->user(), 'All notifications are marked as read');

        return toast($this, 'success', 'Notifications has been marked as read!');
    }
}
