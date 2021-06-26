<?php

namespace App\Http\Livewire\Explore;

use App\Models\User;
use Illuminate\Contracts\View\View;
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
            ->with(['reputations'])
            ->where([
                ['spammy', false],
                ['is_private', false],
                ['is_staff', false],
            ])
            ->latest('last_active')
            ->take(50)
            ->orderByDesc('tasks_count')
            ->take(5)
            ->get()
            ->sortByDesc('reputations');
    }

    public function render(): View
    {
        return view('livewire.explore.trending-makers', [
            'users' => $this->readyToLoad ? $this->getTrendingMakers() : [],
        ]);
    }
}
