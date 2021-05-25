<?php

namespace App\Http\Livewire\User\Stats;

use Carbon\CarbonPeriod;
use Livewire\Component;

class CompletedTasks extends Component
{
    public $user;
    public $ready_to_load = false;

    public function mount($user)
    {
        $this->user = $user;
    }

    public function loadCompletedTasks()
    {
        $this->ready_to_load = true;
    }

    public function render()
    {
        $created_at = $this->user->created_at->format('Y-m-d');
        $current_date = carbon()->format('Y-m-d');
        $period = CarbonPeriod::create($created_at, '7 days', $current_date);
        $completed_tasks_count = $this->user->tasks()
            ->select('id')
            ->whereDone(true)
            ->count();

        $week_dates = [];
        $completed_tasks = [];
        $tasks = [];
        foreach ($period->toArray() as $date) {
            array_push($week_dates, carbon($date)->format('d M Y'));
            $count = $this->user->tasks()
                ->select('id')
                ->whereDone(true)
                ->whereBetween('done_at', [carbon($date), carbon($date)->addDays(7)])
                ->count();
            array_push($completed_tasks, $count);
        }

        return view('livewire.user.stats.completed-tasks', [
            'week_dates' => $this->ready_to_load ? json_encode($week_dates, JSON_NUMERIC_CHECK) : [],
            'completed_tasks' => $this->ready_to_load ? json_encode($completed_tasks, JSON_NUMERIC_CHECK) : [],
            'completed_tasks_count' => $this->ready_to_load ? $completed_tasks_count : '···',
        ]);
    }
}
