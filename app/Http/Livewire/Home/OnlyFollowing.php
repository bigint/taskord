<?php

namespace App\Http\Livewire\Home;

use Livewire\Component;

class OnlyFollowing extends Component
{
    public function onlyFollowingsTasks()
    {
        if (auth()->check()) {
            auth()->user()->onlyFollowingsTasks = ! auth()->user()->onlyFollowingsTasks;
            auth()->user()->save();
            $this->emit('refreshTasks');
            loggy(request(), 'User', auth()->user(), 'Toggled only followings tasks');

            if (auth()->user()->onlyFollowingsTasks) {
                return toast($this, 'success', 'Only following users tasks will be visible!');
            } else {
                return toast($this, 'success', 'All users tasks will be visible!');
            }
        } else {
            return toast($this, 'error', 'Forbidden!');
        }
    }
}
