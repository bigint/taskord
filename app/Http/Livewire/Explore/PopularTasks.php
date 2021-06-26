<?php

namespace App\Http\Livewire\Explore;

use App\Models\Task;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class PopularTasks extends Component
{
    public $listeners = [
        'refreshTasks' => 'render',
    ];

    public $readyToLoad = false;

    public function loadPopularTasks()
    {
        $this->readyToLoad = true;
    }

    public function getPopularTasks()
    {
        return Task::with(['user', 'comments.user', 'product', 'oembed', 'milestone'])
            ->whereHas('user', function ($q) {
                $q->where([
                    ['spammy', false],
                    ['is_private', false],
                ]);
            })
            ->latest('created_at')
            ->take(50)
            ->has('comments')
            ->limit(10)
            ->get()
            ->sortByDesc('likers_count')
            ->sortByDesc('comments_count')
            ->shuffle();
    }

    public function render(): View
    {
        return view('livewire.explore.popular-tasks', [
            'tasks' => $this->readyToLoad ? $this->getPopularTasks() : [],
        ]);
    }
}
