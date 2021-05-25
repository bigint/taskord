<?php

namespace App\Http\Livewire\Explore;

use App\Models\User;
use Livewire\Component;

class TrendingMakers extends Component
{
    public $readyToLoad = false;

    public function loadTrendingMakers()
    {
        $this->readyToLoad = true;
    }

    public function getTrendingMakers()
    {
        return User::withCount('tasks')
            ->where([
                ['spammy', false],
                ['is_staff', false],
            ])
            ->latest('last_active')
            ->take(50)
            ->orderByDesc('tasks_count')
            ->take(5)
            ->get()
            ->sortByDesc('reputations');
    }

    public function render()
    {
        return view('livewire.explore.trending-makers', [
            'users' => $this->readyToLoad ? $this->getTrendingMakers() : [],
        ]);
    }
}
