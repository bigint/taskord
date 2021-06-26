<?php

namespace App\Http\Livewire\Home;

use App\Models\Task;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Tasks extends Component
{
    public $listeners = [
        'refreshTasks' => 'render',
    ];

    public $page;
    public $readyToLoad = false;

    public function mount($page)
    {
        $this->page = $page ? $page : 1;
    }

    public function loadTasks()
    {
        $this->readyToLoad = true;
    }

    public function getTasks()
    {
        if (auth()->check() && auth()->user()->only_followings_tasks) {
            $userIds = auth()->user()->followings->pluck('id');
            $userIds->push(auth()->user()->id);

            return Task::select('id', 'task', 'done', 'type', 'done_at', 'user_id', 'product_id', 'milestone_id', 'source', 'images', 'hidden')
                ->with(['user', 'product', 'milestone', 'comments.user', 'oembed'])
                ->whereIn('user_id', $userIds)
                ->whereHas('user', function ($q) {
                    $q->where([
                        ['spammy', false],
                        ['is_private', false],
                    ]);
                })
                ->whereDone(true)
                ->orderBy('done_at', 'desc')
                ->paginate(10, null, null, $this->page);
        }

        return Task::with(['user', 'comments.user'])
            ->with(['user', 'product', 'milestone', 'comments.user', 'oembed'])
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

    public function render(): View
    {
        return view('livewire.home.tasks', [
            'tasks' => $this->readyToLoad ? $this->getTasks() : [],
            'page' => $this->page,
        ]);
    }
}
