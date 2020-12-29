<?php

namespace App\Http\Livewire\User;

use App\Models\Task;
use App\Models\User;
use Livewire\Component;

class LoadMore extends Component
{
    public $listeners = [
        'taskAdded' => 'render',
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

    public function render()
    {
        if ($this->loadMore) {
            $tasks = Task::cacheFor(60 * 60)
                ->select('id', 'task', 'done', 'type', 'created_at', 'done_at', 'user_id', 'product_id', 'source', 'images', 'hidden')
                ->where([
                    ['user_id', $this->user->id],
                    ['done', $this->type === 'user.done' ? true : false],
                ])
                ->orderBy('done_at', 'desc')
                ->paginate(10, null, null, $this->page);

            return view('livewire.user.tasks', [
                'tasks' => $tasks,
            ]);
        } else {
            return view('livewire.load-more');
        }
    }
}
