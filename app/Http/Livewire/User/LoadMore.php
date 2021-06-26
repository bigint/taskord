<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class LoadMore extends Component
{
    public $listeners = [
        'refreshTasks' => 'render',
    ];

    public User $user;
    public $type;
    public $page;
    public $loadMore;
    public $readyToLoad = true;

    public function mount($user, $type, $page = 1)
    {
        $this->user = $user;
        $this->type = $type;
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
            $tasks = $this->user->tasks()
                ->with(['user', 'product', 'milestone', 'comments.user', 'oembed'])
                ->whereDone($this->type === 'user.done' ? true : false)
                ->orderBy('done_at', 'desc')
                ->paginate(10, '*', null, $this->page);

            return view('livewire.user.tasks', [
                'tasks' => $tasks,
            ]);
        }

        return view('livewire.load-more');
    }
}
