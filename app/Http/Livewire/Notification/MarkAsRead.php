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

            return $this->alert('success', 'Notifications has been marked as read!', [
                'showCancelButton' =>  false,
          ]);
        } else {
            return $this->alert('error', 'Forbidden!', [
                'showCancelButton' =>  false,
          ]);
        }
    }
}
