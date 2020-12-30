<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
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
        if (Auth::check()) {
            Auth::user()->status = null;
            Auth::user()->status_emoji = null;
            Auth::user()->save();
            $this->emit('statusUpdated');
            activity()
                ->withProperties(['type' => 'User'])
                ->log('Cleared the account status');

            return $this->alert('success', 'Status cleared successfully!');
        } else {
            return $this->alert('error', 'Forbidden!');
        }
    }

    public function submit($event)
    {
        if (Auth::check()) {
            if (strlen($event['status_emoji']) === 0) {
                return $this->alert('warning', 'Select the emoji!');
            }

            if (strlen($event['status']) !== 0) {
                Auth::user()->status = $event['status'];
                Auth::user()->status_emoji = $event['status_emoji'];
                Auth::user()->save();
                $this->emit('statusUpdated');
                activity()
                    ->withProperties(['type' => 'User'])
                    ->log('Updated the account status');

                return $this->alert('success', 'Status set successfully!');
            } else {
                Auth::user()->status = null;
                Auth::user()->status_emoji = null;
                Auth::user()->save();
                $this->emit('statusUpdated');
                activity()
                    ->withProperties(['type' => 'User'])
                    ->log('Deleted the account status');

                return $this->alert('success', 'Status cleared successfully!');
            }
        } else {
            return $this->alert('error', 'Forbidden!');
        }
    }

    public function render()
    {
        return view('livewire.user.status');
    }
}
