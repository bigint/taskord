<?php

namespace App\Http\Livewire\Home;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class RecentlyJoined extends Component
{
    public $readyToLoad = false;

    public function loadRecentlyJoined()
    {
        $this->readyToLoad = true;
    }

    public function getRecentlyJoined()
    {
        return User::select('id', 'username', 'firstname', 'lastname', 'avatar', 'bio', 'is_verified', 'status', 'status_emoji', 'created_at')
            ->where([
                ['spammy', false],
                ['is_private', false],
            ])
            ->orderBy('created_at', 'DESC')
            ->take(5)
            ->get();
    }

    public function render(): View
    {
        return view('livewire.home.recently-joined', [
            'recently_joined' => $this->readyToLoad ? $this->getRecentlyJoined() : [],
        ]);
    }
}
