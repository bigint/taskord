<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use Livewire\Component;

class Status extends Component
{
    public $listeners = [
        'refreshStatus'  => 'render',
    ];

    public User $user;

    public function mount($user)
    {
        $this->user = $user;
    }

    public function clearStatus()
    {
        if (auth()->check()) {
            auth()->user()->status = null;
            auth()->user()->status_emoji = null;
            auth()->user()->save();
            $this->emit('refreshStatus');
            loggy(request(), 'User', auth()->user(), 'Cleared the account status');

            return toast($this, 'success', 'Status cleared successfully!');
        } else {
            return toast($this, 'error', 'Forbidden!');
        }
    }

    public function submit($event)
    {
        if (auth()->check()) {
            if (strlen($event['status_emoji']) === 0) {
                return toast($this, 'error', 'Select the emoji!');
            }

            if (strlen($event['status']) !== 0) {
                auth()->user()->status = $event['status'];
                auth()->user()->status_emoji = $event['status_emoji'];
                auth()->user()->save();
                $this->emit('refreshStatus');
                loggy(request(), 'User', auth()->user(), 'Updated the account status');

                return toast($this, 'success', 'Status set successfully!');
            } else {
                auth()->user()->status = null;
                auth()->user()->status_emoji = null;
                auth()->user()->save();
                $this->emit('refreshStatus');
                loggy(request(), 'User', auth()->user(), 'Deleted the account status');

                return toast($this, 'success', 'Status cleared successfully!');
            }
        } else {
            return toast($this, 'error', 'Forbidden!');
        }
    }

    public function render()
    {
        return view('livewire.user.status');
    }
}
