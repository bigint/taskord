<?php

namespace App\Http\Livewire\Home;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class OnlyFollowing extends Component
{
    public function onlyFollowingsTasks()
    {
        if (Auth::check()) {
            auth()->user()->onlyFollowingsTasks = ! auth()->user()->onlyFollowingsTasks;
            auth()->user()->save();
            $this->emit('onlyFollowings');
            loggy('User', auth()->user(), 'Toggled only followings tasks');

            if (auth()->user()->onlyFollowingsTasks) {
                return $this->alert('success', 'Only following users tasks will be visible!');
            } else {
                return $this->alert('success', 'All users tasks will be visible!');
            }
        } else {
            return $this->alert('error', 'Forbidden!');
        }
    }
}
