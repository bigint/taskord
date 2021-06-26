<?php

namespace App\Http\Livewire\Pages\Open;

use App\Models\Task;
use Carbon\CarbonPeriod;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class AllTasks extends Component
{
    public $readyToLoad = false;

    public function loadAllTasks()
    {
        $this->readyToLoad = true;
    }

    public function render(): View
    {
        $createdAt = carbon('Sep 1 2020')->format('Y-m-d');
        $currentDate = carbon()->format('Y-m-d');
        $period = CarbonPeriod::create($createdAt, '7 days', $currentDate);
        $allTasksCount = Task::select('id')
            ->count();

        $weekDates = [];
        $allTasks = [];
        foreach ($period->toArray() as $date) {
            array_push($weekDates, carbon($date)->format('d M Y'));
            $count = Task::select('id')
                ->whereBetween('created_at', [carbon($date), carbon($date)->addDays(7)])
                ->count();
            array_push($allTasks, $count);
        }

        return view('livewire.pages.open.all-tasks', [
            'week_dates' => json_encode($weekDates, JSON_NUMERIC_CHECK),
            'all_tasks' => $this->readyToLoad ? json_encode($allTasks, JSON_NUMERIC_CHECK) : [],
            'all_tasks_count' => $this->readyToLoad ? number_format($allTasksCount) : '···',
        ]);
    }
}
