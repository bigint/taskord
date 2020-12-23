<?php

namespace App\Http\Livewire\User;

use App\Models\Task;
use Livewire\Component;
use App\Models\User;

class Tasks extends Component
{
    public $listeners = [
        'taskAdded' => 'render',
        'taskDeleted' => 'render',
        'taskChecked' => 'render',
    ];

    public User $user;
    public $type;
    public $page;

    public function mount($user, $type, $page)
    {
        $this->user = $user;
        $this->type = $type;
        $this->page = $page ? $page : 1;
    }

    public function render()
    {
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
            'page' => $this->page,
        ]);
    }
}
