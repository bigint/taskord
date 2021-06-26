<?php

namespace App\Http\Livewire\User\Stats;

use Carbon\CarbonPeriod;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class CompletedTasks extends Component
{
    public $user;
    public $readyToLoad = false;

    public function mount($user)
    {
        $this->user = $user;
    }

    public function loadCompletedTasks()
    {
        $this->readyToLoad = true;
    }

    public function render(): View
    {
        $createdAt = $this->user->created_at->format('Y-m-d');
        $currentDate = carbon()->format('Y-m-d');
        $period = CarbonPeriod::create($createdAt, '7 days', $currentDate);
        $completedTasksCount = $this->user->tasks()
            ->select('id')
            ->whereDone(true)
            ->count();

        $weekDates = [];
        $completedTasks = [];
        foreach ($period->toArray() as $date) {
            array_push($weekDates, carbon($date)->format('d M Y'));
            $count = $this->user->tasks()
                ->select('id')
                ->whereDone(true)
                ->whereBetween('done_at', [carbon($date), carbon($date)->addDays(7)])
                ->count();
            array_push($completedTasks, $count);
        }

        return view('livewire.user.stats.completed-tasks', [
            'week_dates' => $this->readyToLoad ? json_encode($weekDates, JSON_NUMERIC_CHECK) : [],
            'completed_tasks' => $this->readyToLoad ? json_encode($completedTasks, JSON_NUMERIC_CHECK) : [],
            'completed_tasks_count' => $this->readyToLoad ? $completedTasksCount : '···',
        ]);
    }
}
