<?php

namespace App\Http\Livewire\Tasks;

use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AllTime extends Component
{
    public $listeners = [
        'taskChecked' => 'render',
        'taskAdded' => 'render',
        'taskDeleted' => 'render',
    ];

    public function render()
    {
        $tasks = Task::cacheFor(60 * 60)
            ->select('id', 'task', 'done', 'images', 'user_id', 'created_at', 'due_at', 'type', 'product_id')
            ->where('user_id', Auth::id())
            ->where('done', false)
            ->latest('due_at')
            ->get();

        return view('livewire.tasks.all-time', [
            'tasks' => $tasks,
        ]);
    }
}
