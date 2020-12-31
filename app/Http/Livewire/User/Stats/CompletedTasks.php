<?php

namespace App\Http\Livewire\User\Stats;

use Livewire\Component;
use Carbon\CarbonPeriod;
use Carbon\Carbon;
use App\Models\Task;

class CompletedTasks extends Component
{
    public $user;
    public $readyToLoad = false;

    public function mount($user) {
        $this->user = $user;
    }

    public function loadCompletedTasks()
    {
        $this->readyToLoad = true;
    }

    public function render()
    {
        $created_at = Carbon::parse($this->user->created_at)->format('Y-m-d');
        $current_date = Carbon::now()->format('Y-m-d');
        $period = CarbonPeriod::create($created_at, '10 days', $current_date);

        $week_dates = [];
        $completed_tasks = [];
        $tasks = [];
        foreach ($period->toArray() as $date) {
            array_push($week_dates, Carbon::parse($date)->format('Y-m-d'));
            $count = Task::cacheFor(60 * 60)
                ->select('id')
                ->whereBetween('done_at', [Carbon::parse($date), Carbon::parse($date)->addDays(10)])
                ->count();
            array_push($completed_tasks, $count);
        }

        return view('livewire.user.stats.completed-tasks', [
            'week_dates' => json_encode($week_dates, JSON_NUMERIC_CHECK),
            'completed_tasks' => $this->readyToLoad ? json_encode($completed_tasks, JSON_NUMERIC_CHECK) : [],
        ]);
    }
}
