<?php

namespace App\Http\Livewire\User\Stats;

use Carbon\CarbonPeriod;
use Livewire\Component;

class AllTasks extends Component
{
    public $user;
    public $ready_to_load = false;

    public function mount($user)
    {
        $this->user = $user;
    }

    public function loadAllTasks()
    {
        $this->ready_to_load = true;
    }

    public function render()
    {
        $created_at = $this->user->created_at->format('Y-m-d');
        $current_date = carbon()->format('Y-m-d');
        $period = CarbonPeriod::create($created_at, '5 days', $current_date);
        $all_tasks_count = $this->user->tasks()
            ->select('id')
            ->count();

        $week_dates = [];
        $all_tasks = [];
        $tasks = [];
        foreach ($period->toArray() as $date) {
            array_push($week_dates, carbon($date)->format('d M Y'));
            $count = $this->user->tasks()
                ->select('id')
                ->whereBetween('created_at', [carbon($date), carbon($date)->addDays(5)])
                ->count();
            array_push($all_tasks, $count);
        }

        return view('livewire.user.stats.all-tasks', [
            'week_dates' => json_encode($week_dates, JSON_NUMERIC_CHECK),
            'all_tasks' => $this->ready_to_load ? json_encode($all_tasks, JSON_NUMERIC_CHECK) : [],
            'all_tasks_count' => $this->ready_to_load ? $all_tasks_count : '···',
        ]);
    }
}
