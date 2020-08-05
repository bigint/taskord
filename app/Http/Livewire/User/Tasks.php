<?php

namespace App\Http\Livewire\User;

use App\Task;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Livewire\Component;

class Tasks extends Component
{
    public $listeners = [
        'taskAdded' => 'render',
        'taskDeleted' => 'render',
        'taskChecked' => 'render',
    ];

    public $user_id;
    public $type;
    public $page;
    public $perPage;

    public function mount($user, $type, $page, $perPage)
    {
        $this->user_id = $user->id;
        $this->type = $type;
        $this->page = $page ? $page : 1;
        $this->perPage = $perPage ? $perPage : 1;
    }

    public function paginate($items, $options = [])
    {
        $page = $this->page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);

        return new LengthAwarePaginator($items->forPage($page, $this->perPage), $items->count(), $this->perPage, $page, $options);
    }

    public function render()
    {
        if ($this->type === 'user.done') {
            $tasks = Task::cacheFor(60 * 60)
                ->where('user_id', $this->user_id)
                ->where('done', true)
                ->orderBy('done_at', 'desc')
                ->get()
                ->groupBy(function ($date) {
                    return Carbon::parse($date->done_at)->format('d-M-y');
                });
        } else {
            $tasks = Task::cacheFor(60 * 60)
                ->where('user_id', $this->user_id)
                ->where('done', false)
                ->orderBy('created_at', 'desc')
                ->get()
                ->groupBy(function ($date) {
                    return Carbon::parse($date->done_at)->format('d-M-y');
                });
        }

        return view('livewire.user.tasks', [
            'tasks' => $this->paginate($tasks),
            'page' => $this->page,
        ]);
    }
}
