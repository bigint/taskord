<?php

namespace App\Http\Livewire\Home;

use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class LoadMore extends Component
{
    public $listeners = [
        'taskAdded' => 'render',
    ];

    public $page;
    public $loadMore;
    public $readyToLoad = true;

    public function mount($page = 1)
    {
        $this->page = $page + 1;
        $this->loadMore = false;
    }

    public function loadMore()
    {
        $this->loadMore = true;
    }

    public function render()
    {
        if ($this->loadMore) {
            $user = user();
            if (Auth::check() && $user->onlyFollowingsTasks) {
                $userIds = $user->followings->pluck('id');
                $userIds->push(Auth::id());
                $tasks = Task::cacheFor(60 * 60)
                    ->select('id', 'task', 'done', 'type', 'done_at', 'user_id', 'product_id', 'source', 'images')
                    ->whereIn('user_id', $userIds)
                    ->whereHas('user', function ($q) {
                        $q->where([
                            ['isFlagged', false],
                            ['isPrivate', false],
                        ]);
                    })
                    ->where('done', true)
                    ->orderBy('done_at', 'desc')
                    ->paginate(10, null, null, $this->page);
            } else {
                $tasks = Task::cacheFor(60 * 60)
                    ->select('id', 'task', 'done', 'type', 'done_at', 'user_id', 'product_id', 'source', 'images')
                    ->whereHas('user', function ($q) {
                        $q->where([
                            ['isFlagged', false],
                            ['isPrivate', false],
                        ]);
                    })
                    ->where('done', true)
                    ->orderBy('done_at', 'desc')
                    ->paginate(10, null, null, $this->page);
            }

            return view('livewire.home.tasks', [
                'tasks' => $tasks,
            ]);
        } else {
            return view('livewire.load-more');
        }
    }
}
