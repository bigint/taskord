<?php

namespace App\Http\Livewire\User;

use App\Models\Task;
use Livewire\Component;

class Tasks extends Component
{
    public $listeners = [
        'taskAdded' => 'render',
        'taskDeleted' => 'render',
        'taskChecked' => 'render',
    ];

    public $user;
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
        $tasks = Task::select('id', 'task', 'done', 'type', 'created_at', 'done_at', 'user_id', 'product_id', 'source')
            ->where([
                ['user_id', $this->user->id],
                ['done', $this->type === 'user.done' ? true : false],
            ])
            ->orderBy('done_at', 'desc')
            ->paginate(20, null, null, $this->page);

        return view('livewire.user.tasks', [
            'tasks' => $tasks,
            'page' => $this->page,
        ]);
    }
}
