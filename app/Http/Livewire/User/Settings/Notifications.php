<?php

namespace App\Http\Livewire\User\Settings;

use App\Models\User;
use Livewire\Component;

class Notifications extends Component
{
    public User $user;

    public function mount()
    {
        $this->user = auth()->user();
    }

    public function notificationsEmail()
    {
        $this->user->notifications_email = ! $this->user->notifications_email;
        $this->user->save();
        $this->emit('toggledNotificationsEmail');
        loggy(request(), 'User', auth()->user(), 'Toggled the email notification settings');

        return toast($this, 'success', 'Notification settings has been updated');
    }

    public function notificationsWeb()
    {
        $this->user->notifications_web = ! $this->user->notifications_web;
        $this->user->save();
        $this->emit('toggledNotificationsWeb');
        loggy(request(), 'User', auth()->user(), 'Toggled the web notification settings');

        return toast($this, 'success', 'Notification settings has been updated');
    }
}
