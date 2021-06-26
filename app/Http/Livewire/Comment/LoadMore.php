<?php

namespace App\Http\Livewire\Comment;

use App\Models\Task;
use Illuminate\Contracts\View\View;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Livewire\Component;

class LoadMore extends Component
{
    public Task $task;
    public $page;
    public $perPage;
    public $loadMore;
    public $readyToLoad = true;

    public function mount($task, $page = 1, $perPage = 1)
    {
        $this->task = $task;
        $this->page = $page + 1;
        $this->perPage = $perPage;
        $this->loadMore = false;
    }

    public function paginate($items, $options = [])
    {
        $page = $this->page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);

        return new LengthAwarePaginator($items->forPage($page, $this->perPage), $items->count(), $this->perPage, $page, $options);
    }

    public function loadMore()
    {
        $this->loadMore = true;
    }

    public function render(): View
    {
        if ($this->loadMore) {
            $comments = $this->task->comments()
                ->whereHas('user', function ($q) {
                    $q->where([
                        ['spammy', false],
                    ]);
                })
                ->orderBy('created_at', 'DESC')
                ->get();

            return view('livewire.comment.comments', [
                'comments' => $this->paginate($comments),
            ]);
        }

        return view('livewire.load-more');
    }
}
