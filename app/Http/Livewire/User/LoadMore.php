<?php

namespace App\Http\Livewire\User;

use App\Task;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Livewire\Component;

class LoadMore extends Component
{
    public $listeners = [
        'taskAdded' => 'render',
    ];

    public $user_id;
    public $type;
    public $page;
    public $perPage;
    public $loadMore;

    public function mount($user, $type, $page = 1, $perPage = 1)
    {
        $this->user_id = $user->id;
        $this->type = $type;
        $this->page = $page + 1; //increment the page
        $this->perPage = $perPage;
        $this->loadMore = false; //show the button
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

    public function render()
    {
        if ($this->loadMore) {
            $tasks = Task::cacheFor(60 * 60)
                ->where('user_id', $this->user_id)
                ->where('done', $this->type === 'user.done' ? true : false)
                ->orderBy('done_at', 'desc')
                ->get()
                ->groupBy(function ($date) {
                    return Carbon::parse($date->done_at)->format('d-M-y');
                });

            return view('livewire.user.tasks', [
                'tasks' => $this->paginate($tasks),
            ]);
        } else {
            return view('livewire.load-more');
        }
    }
}
