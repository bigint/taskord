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
    public $readyToLoad = false;

    public function loadTodayTasks()
    {
        $this->readyToLoad = true;
    }

    public function render()
    {
        $tasks = Task::cacheFor(60 * 60)
            ->select('id', 'task', 'done', 'images', 'user_id', 'created_at', 'due_at', 'type', 'product_id')
            ->where('user_id', Auth::id())
            ->whereDate('created_at', carbon('today'))
            ->where('done', false)
            ->latest('due_at')
            ->get();

        return view('livewire.tasks.today', [
            'tasks' => $this->readyToLoad ? $tasks : [],
        ]);
    }
}
