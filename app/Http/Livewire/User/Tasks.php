<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use Livewire\Component;

class Tasks extends Component
{
    public $listeners = [
        'refreshTasks' => 'render',
    ];

    public User $user;
    public $type;
    public $page;
    public $ready_to_load = false;

    public function mount($user, $type, $page)
    {
        $this->user = $user;
        $this->type = $type;
        $this->page = $page ? $page : 1;
    }

    public function loadTasks()
    {
        $this->ready_to_load = true;
    }

    public function getTasks()
    {
        return $this->user->tasks()
            ->whereDone($this->type === 'user.done' ? true : false)
            ->latest('updated_at')
            ->paginate(10, '*', null, $this->page);
    }

    public function render()
    {
        return view('livewire.user.tasks', [
            'tasks' => $this->ready_to_load ? $this->getTasks() : [],
            'page' => $this->page,
        ]);
    }
}
