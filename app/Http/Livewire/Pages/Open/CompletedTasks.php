<?php

namespace App\Http\Livewire\Pages\Open;

use App\Models\Task;
use Carbon\CarbonPeriod;
use Livewire\Component;

class CompletedTasks extends Component
{
    public $readyToLoad = false;

    public function loadCompletedTasks()
    {
        $this->readyToLoad = true;
    }

    public function render()
    {
        $created_at = carbon('Sep 1 2020')->format('Y-m-d');
        $current_date = carbon()->format('Y-m-d');
        $period = CarbonPeriod::create($created_at, '7 days', $current_date);
        $completed_tasks_count = Task::select('id')
            ->where('done', true)
            ->count();

        $week_dates = [];
        $completed_tasks = [];
        $tasks = [];
        foreach ($period->toArray() as $date) {
            array_push($week_dates, carbon($date)->format('d M Y'));
            $count = Task::select('id')
                ->where('done', true)
                ->whereBetween('created_at', [carbon($date), carbon($date)->addDays(7)])
                ->count();
            array_push($completed_tasks, $count);
        }

        return view('livewire.pages.open.completed-tasks', [
            'week_dates' => json_encode($week_dates, JSON_NUMERIC_CHECK),
            'completed_tasks' => $this->readyToLoad ? json_encode($completed_tasks, JSON_NUMERIC_CHECK) : [],
            'completed_tasks_count' => $this->readyToLoad ? number_format($completed_tasks_count) : '···',
        ]);
    }
}
