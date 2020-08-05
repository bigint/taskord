<?php

namespace App\Http\Livewire\Home;

use App\Task;
use Auth;
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

    public $page;
    public $perPage;
    public $loadMore;

    public function mount($page = 1, $perPage = 1)
    {
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
            $user = Auth::user();
            if (Auth::check() && $user->onlyFollowingsTasks) {
                $userIds = $user->followings->pluck('id');
                $userIds->push(Auth::id());
                $tasks = Task::cacheFor(60 * 60)
                    ->select('id', 'task', 'done', 'done_at', 'user_id')
                    ->whereIn('user_id', $userIds)
                    ->where('done', true)
                    ->orderBy('done_at', 'desc')
                    ->get()
                    ->groupBy(function ($date) {
                        return Carbon::parse($date->done_at)->format('d-M-y');
                    });
            } else {
                $tasks = Task::cacheFor(60 * 60)
                    ->select('id', 'task', 'done', 'done_at', 'user_id')
                    ->where('done', true)
                    ->orderBy('done_at', 'desc')
                    ->get()
                    ->groupBy(function ($date) {
                        return Carbon::parse($date->done_at)->format('d-M-y');
                    });
            }

            return view('livewire.home.tasks', [
                'tasks' => $this->paginate($tasks),
            ]);
        } else {
            return view('livewire.load-more');
        }
    }
}
