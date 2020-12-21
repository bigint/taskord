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
            activity()
                ->withProperties(['type' => 'Notification'])
                ->log('Notifications mark as read');
        } else {
            return $this->alert('error', 'Forbidden!', [
                'showCancelButton' => true,
            ]);
        }
    }

    public function render()
    {
        return view('livewire.notification.mark-as-read');
    }
}
