<?php

namespace App\Http\Livewire\Home;

use App\Models\Task;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class LoadMore extends Component
{
    public $listeners = [
        'refreshTasks' => 'render',
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

    public function render(): View
    {
        if ($this->loadMore) {
            if (auth()->check() && auth()->user()->only_followings_tasks) {
                $userIds = auth()->user()->followings->pluck('id');
                $userIds->push(auth()->user()->id);
                $tasks = Task::with(['user', 'product', 'milestone', 'comments.user', 'oembed'])
                    ->whereIn('user_id', $userIds)
                    ->whereHas('user', function ($q) {
                        $q->where([
                            ['spammy', false],
                            ['is_private', false],
                        ]);
                    })
                    ->whereDone(true)
                    ->orderBy('done_at', 'desc')
                    ->paginate(10, '*', null, $this->page);
            } else {
                $tasks = Task::with(['user', 'product', 'milestone', 'comments.user', 'oembed'])
                    ->whereHas('user', function ($q) {
                        $q->where([
                            ['spammy', false],
                            ['is_private', false],
                        ]);
                    })
                    ->whereDone(true)
                    ->orderBy('done_at', 'desc')
                    ->paginate(10, '*', null, $this->page);
            }

            return view('livewire.home.tasks', [
                'tasks' => $tasks,
            ]);
        }

        return view('livewire.load-more');
    }
}
