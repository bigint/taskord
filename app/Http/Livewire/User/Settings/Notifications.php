<?php

namespace App\Http\Livewire\User\Settings;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Notifications extends Component
{
    public User $user;

    public function mount($user)
    {
        $this->user = $user;
    }

    public function notificationsEmail()
    {
        if (Auth::check()) {
            if (auth()->user()->id === $this->user->id) {
                $this->user->notifications_email = ! $this->user->notifications_email;
                $this->user->save();
                loggy(request()->ip(), 'User', auth()->user(), 'Toggled "notificationsEmail" in notification settings');

                return $this->alert('success', 'Notification settings has been updated');
            } else {
                return $this->alert('error', 'Forbidden!');
            }
        } else {
            return $this->alert('error', 'Forbidden!');
        }
    }

    public function notificationsWeb()
    {
        if (Auth::check()) {
            if (auth()->user()->id === $this->user->id) {
                $this->user->notifications_web = ! $this->user->notifications_web;
                $this->user->save();
                loggy(request()->ip(), 'User', auth()->user(), 'Toggled "notificationsWeb" in notification settings');

                return $this->alert('success', 'Notification settings has been updated');
            } else {
                return $this->alert('error', 'Forbidden!');
            }
        } else {
            return $this->alert('error', 'Forbidden!');
        }
    }
}
