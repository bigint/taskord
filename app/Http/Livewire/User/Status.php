<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Status extends Component
{
    public $listeners = [
        'refreshStatus' => 'render',
    ];

    public User $user;

    public function mount($user)
    {
        $this->user = $user;
    }

    public function clearStatus()
    {
        if (! auth()->check()) {
            return toast($this, 'error', config('taskord.toast.deny'));
        }

        auth()->user()->status = null;
        auth()->user()->status_emoji = null;
        auth()->user()->save();
        $this->emit('refreshStatus');
        loggy(request(), 'User', auth()->user(), 'Cleared the account status');

        return toast($this, 'success', 'Status cleared successfully!');
    }

    public function submit($event)
    {
        if (! auth()->check()) {
            return toast($this, 'error', config('taskord.toast.deny'));
        }

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
        }
        auth()->user()->status = null;
        auth()->user()->status_emoji = null;
        auth()->user()->save();
        $this->emit('refreshStatus');
        loggy(request(), 'User', auth()->user(), 'Deleted the account status');

        return toast($this, 'success', 'Status cleared successfully!');
    }

    public function render(): View
    {
        return view('livewire.user.status');
    }
}
