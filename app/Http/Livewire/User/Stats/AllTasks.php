<?php

namespace App\Http\Livewire\User\Stats;

use Carbon\CarbonPeriod;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class AllTasks extends Component
{
    public $user;
    public $readyToLoad = false;

    public function mount($user)
    {
        $this->user = $user;
    }

    public function loadAllTasks()
    {
        $this->readyToLoad = true;
    }

    public function render(): View
    {
        $createdAt = $this->user->created_at->format('Y-m-d');
        $currentDate = carbon()->format('Y-m-d');
        $period = CarbonPeriod::create($createdAt, '5 days', $currentDate);
        $allTasksCount = $this->user->tasks()
            ->select('id')
            ->count();

        $weekDates = [];
        $allTasks = [];
        foreach ($period->toArray() as $date) {
            array_push($weekDates, carbon($date)->format('d M Y'));
            $count = $this->user->tasks()
                ->select('id')
                ->whereBetween('created_at', [carbon($date), carbon($date)->addDays(5)])
                ->count();
            array_push($allTasks, $count);
        }

        return view('livewire.user.stats.all-tasks', [
            'week_dates' => json_encode($weekDates, JSON_NUMERIC_CHECK),
            'all_tasks' => $this->readyToLoad ? json_encode($allTasks, JSON_NUMERIC_CHECK) : [],
            'all_tasks_count' => $this->readyToLoad ? $allTasksCount : '···',
        ]);
    }
}
