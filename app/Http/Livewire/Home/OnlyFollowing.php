<?php

namespace App\Http\Livewire\Home;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class OnlyFollowing extends Component
{
    public function onlyFollowingsTasks()
    {
        if (Auth::check()) {
            user()->onlyFollowingsTasks = ! user()->onlyFollowingsTasks;
            user()->save();
            $this->emit('onlyFollowings');
            activity()
                    ->withProperties(['type' => 'User'])
                    ->log('Toggled only followings tasks');

            if (user()->onlyFollowingsTasks) {
                return $this->alert('success', 'Only following users tasks will be visible!');
            } else {
                return $this->alert('success', 'All users tasks will be visible!');
            }
        } else {
            return $this->alert('error', 'Forbidden!');
        }
    }
}
