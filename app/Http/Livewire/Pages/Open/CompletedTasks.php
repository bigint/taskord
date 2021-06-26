<?php

namespace App\Http\Livewire\Pages\Open;

use App\Models\Task;
use Carbon\CarbonPeriod;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class CompletedTasks extends Component
{
    public $readyToLoad = false;

    public function loadCompletedTasks()
    {
        $this->readyToLoad = true;
    }

    public function render(): View
    {
        $createdAt = carbon('Sep 1 2020')->format('Y-m-d');
        $currentDate = carbon()->format('Y-m-d');
        $period = CarbonPeriod::create($createdAt, '7 days', $currentDate);
        $completedTasksCount = Task::select('id')
            ->whereDone(true)
            ->count();

        $weekDates = [];
        $completedTasks = [];
        foreach ($period->toArray() as $date) {
            array_push($weekDates, carbon($date)->format('d M Y'));
            $count = Task::select('id')
                ->whereDone(true)
                ->whereBetween('created_at', [carbon($date), carbon($date)->addDays(7)])
                ->count();
            array_push($completedTasks, $count);
        }

        return view('livewire.pages.open.completed-tasks', [
            'week_dates' => json_encode($weekDates, JSON_NUMERIC_CHECK),
            'completed_tasks' => $this->readyToLoad ? json_encode($completedTasks, JSON_NUMERIC_CHECK) : [],
            'completed_tasks_count' => $this->readyToLoad ? number_format($completedTasksCount) : '···',
        ]);
    }
}
