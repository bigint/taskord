<?php

namespace App\Http\Livewire\Tasks;

use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Today extends Component
{
    public $listeners = [
        'taskChecked' => 'render',
        'taskAdded' => 'render',
        'taskDeleted' => 'render',
    ];

    public function render()
    {
        $tasks = Task::cacheFor(60 * 60)
            ->select('id', 'task', 'done', 'image', 'user_id', 'created_at', 'due_at', 'type', 'product_id')
            ->where('user_id', Auth::id())
            ->whereDate('due_at', Carbon::today())
            ->orWhereDate('created_at', Carbon::today())
            ->where('done', false)
            ->latest()
            ->get();

        return view('livewire.tasks.today', [
            'tasks' => $tasks,
        ]);
    }
}
