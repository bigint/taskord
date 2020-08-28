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

    public function mount($page = 1)
    {
        $this->page = $page + 1; //increment the page
        $this->loadMore = false; //show the button
    }

    public function loadMore()
    {
        $this->loadMore = true;
    }

    public function render()
    {
        if ($this->loadMore) {
            $user = Auth::user();
            if (Auth::check() && $user->onlyFollowingsTasks) {
                $userIds = $user->followings->pluck('id');
                $userIds->push(Auth::id());
                $tasks = Task::dontCache()
                    ->select('id', 'task', 'done', 'done_at', 'user_id')
                    ->whereIn('user_id', $userIds)
                    ->whereHas('user', function ($q) {
                        $q->where([
                            ['isFlagged', false],
                            ['isPrivate', false],
                        ]);
                    })
                    ->where('done', true)
                    ->orderBy('done_at', 'desc')
                    ->paginate(20, null, null, $this->page);
            } else {
                $tasks = Task::dontCache()
                    ->select('id', 'task', 'done', 'done_at', 'user_id')
                    ->whereHas('user', function ($q) {
                        $q->where([
                            ['isFlagged', false],
                            ['isPrivate', false],
                        ]);
                    })
                    ->where('done', true)
                    ->orderBy('done_at', 'desc')
                    ->paginate(20, null, null, $this->page);
            }

            return view('livewire.home.tasks', [
                'tasks' => $tasks,
            ]);
        } else {
            return view('livewire.load-more');
        }
    }
}
