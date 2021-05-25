<?php

namespace App\Http\Livewire\Home;

use Livewire\Component;

class OnlyFollowing extends Component
{
    public function onlyFollowingsTasks()
    {
        if (! auth()->check()) {
            return toast($this, 'error', 'Forbidden!');
        }

        auth()->user()->only_followings_tasks = ! auth()->user()->only_followings_tasks;
        auth()->user()->save();
        $this->emit('refreshTasks');
        loggy(request(), 'User', auth()->user(), 'Toggled only followings tasks');

        if (auth()->user()->only_followings_tasks) {
            return toast($this, 'success', 'Only following users tasks will be visible!');
        } else {
            return toast($this, 'success', 'All users tasks will be visible!');
        }
    }
}
