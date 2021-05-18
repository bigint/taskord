<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use Livewire\Component;

class Status extends Component
{
    public $listeners = [
        'statusUpdated'  => 'render',
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
            $this->emit('statusUpdated');
            loggy(request(), 'User', auth()->user(), 'Cleared the account status');

            return $this->dispatchBrowserEvent('toast', [
                'type' => 'success',
                'body' => 'Status cleared successfully!',
            ]);
        } else {
            return $this->dispatchBrowserEvent('toast', [
                'type' => 'error',
                'body' => 'Forbidden!',
            ]);
        }
    }

    public function submit($event)
    {
        if (auth()->check()) {
            if (strlen($event['status_emoji']) === 0) {
                return $this->dispatchBrowserEvent('toast', [
                    'type' => 'error',
                    'body' => 'Select the emoji!',
                ]);
            }

            if (strlen($event['status']) !== 0) {
                auth()->user()->status = $event['status'];
                auth()->user()->status_emoji = $event['status_emoji'];
                auth()->user()->save();
                $this->emit('statusUpdated');
                loggy(request(), 'User', auth()->user(), 'Updated the account status');

                return $this->dispatchBrowserEvent('toast', [
                    'type' => 'success',
                    'body' => 'Status set successfully!',
                ]);
            } else {
                auth()->user()->status = null;
                auth()->user()->status_emoji = null;
                auth()->user()->save();
                $this->emit('statusUpdated');
                loggy(request(), 'User', auth()->user(), 'Deleted the account status');

                return $this->dispatchBrowserEvent('toast', [
                    'type' => 'success',
                    'body' => 'Status cleared successfully!',
                ]);
            }
        } else {
            return $this->dispatchBrowserEvent('toast', [
                'type' => 'error',
                'body' => 'Forbidden!',
            ]);
        }
    }

    public function render()
    {
        return view('livewire.user.status');
    }
}
