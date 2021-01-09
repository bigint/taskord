<?php

namespace App\Http\Livewire\Explore;

use App\Models\Task;
use Livewire\Component;

class LoadMoreTasks extends Component
{
    public $listeners = [
        'taskDeleted' => 'render',
        'taskChecked' => 'render',
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

            return view('livewire.explore.popular-tasks', [
                'tasks' => $tasks,
            ]);
        } else {
            return view('livewire.load-more');
        }
    }
}
