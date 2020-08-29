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
        $tasks = Task::select('id', 'task', 'done', 'user_id', 'created_at', 'due_at')
            ->where('user_id', Auth::id())
            ->whereDate('created_at', Carbon::today())
            ->where('done', false)
            ->latest()
            ->get();

        return view('livewire.tasks.today', [
            'tasks' => $tasks,
        ]);
    }
}
