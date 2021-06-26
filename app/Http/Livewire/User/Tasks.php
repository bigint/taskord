<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Tasks extends Component
{
    public $listeners = [
        'refreshTasks' => 'render',
    ];

    public User $user;
    public $type;
    public $page;
    public $readyToLoad = false;

    public function mount($user, $type, $page)
    {
        $this->user = $user;
        $this->type = $type;
        $this->page = $page ? $page : 1;
    }

    public function loadTasks()
    {
        $this->readyToLoad = true;
    }

    public function getTasks()
    {
        return $this->user->tasks()
            ->with(['user', 'product', 'milestone', 'comments.user', 'oembed'])
            ->whereDone($this->type === 'user.done' ? true : false)
            ->latest('updated_at')
            ->paginate(10, '*', null, $this->page);
    }

    public function render(): View
    {
        return view('livewire.user.tasks', [
            'tasks' => $this->readyToLoad ? $this->getTasks() : [],
            'page' => $this->page,
        ]);
    }
}
