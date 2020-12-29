<?php

namespace App\Http\Livewire\Home;

use Livewire\Component;
use App\Models\User;
use Carbon\Carbon;

class RecentlyJoined extends Component
{
    public $readyToLoad = false;

    public function loadRecentlyJoined()
    {
        $this->readyToLoad = true;
    }

    public function render()
    {
        $recent_users = User::cacheFor(60 * 60)
            ->select('id', 'username', 'firstname', 'lastname', 'avatar', 'bio', 'isVerified', 'created_at')
            ->where([
                ['created_at', '>=', Carbon::now()->subdays(7)],
                ['isFlagged', false],
            ])
            ->orderBy('created_at', 'DESC');
        $recently_joined = $recent_users->take(5)
            ->get();
        $recently_joined_count = $recent_users->count('id');

        return view('livewire.home.recently-joined', [
            'recently_joined' => $this->readyToLoad ? $recently_joined : [],
            'recently_joined_count' => $recently_joined_count,
        ]);
    }
}
