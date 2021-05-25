<?php

namespace App\Http\Livewire\Home;

use App\Models\User;
use Livewire\Component;

class RecentlyJoined extends Component
{
    public $ready_to_load = false;

    public function loadRecentlyJoined()
    {
        $this->ready_to_load = true;
    }

    public function getRecentlyJoined()
    {
        return User::select('id', 'username', 'firstname', 'lastname', 'avatar', 'bio', 'is_verified', 'status', 'status_emoji', 'created_at')
            ->where([
                ['spammy', false],
            ])
            ->orderBy('created_at', 'DESC')
            ->take(5)
            ->get();
    }

    public function render()
    {
        return view('livewire.home.recently-joined', [
            'recently_joined' => $this->ready_to_load ? $this->getRecentlyJoined() : [],
        ]);
    }
}
