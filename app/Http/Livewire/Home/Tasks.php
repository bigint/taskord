<?php

namespace App\Http\Livewire\Home;

use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Tasks extends Component
{
    public $listeners = [
        'taskAdded' => 'render',
        'taskDeleted' => 'render',
        'taskChecked' => 'render',
    ];

    public $page;

    public function mount($page)
    {
        $this->page = $page ? $page : 1;
    }

    public function render()
    {
        $user = Auth::user();
        if (Auth::check() && $user->onlyFollowingsTasks) {
            $userIds = $user->followings->pluck('id');
            $userIds->push(Auth::id());
            $tasks = Task::select('id', 'task', 'done', 'done_at', 'user_id', 'product_id', 'source')
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
            $tasks = Task::select('id', 'task', 'done', 'type', 'done_at', 'user_id', 'product_id', 'source')
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
            'page' => $this->page,
        ]);
    }
}
