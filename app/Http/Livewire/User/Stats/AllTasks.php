<?php

namespace App\Http\Livewire\User\Stats;

use App\Models\Task;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
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

    public function render()
    {
        $created_at = Carbon::parse($this->user->created_at)->format('Y-m-d');
        $current_date = Carbon::now()->format('Y-m-d');
        $period = CarbonPeriod::create($created_at, '10 days', $current_date);

        $week_dates = [];
        $all_tasks = [];
        $tasks = [];
        foreach ($period->toArray() as $date) {
            array_push($week_dates, Carbon::parse($date)->format('d M Y'));
            $count = Task::cacheFor(60 * 60)
                ->select('id')
                ->where([
                    ['user_id', $this->user->id],
                ])
                ->whereBetween('created_at', [Carbon::parse($date), Carbon::parse($date)->addDays(10)])
                ->count();
            array_push($all_tasks, $count);
        }

        return view('livewire.user.stats.all-tasks', [
            'week_dates' => json_encode($week_dates, JSON_NUMERIC_CHECK),
            'all_tasks' => $this->readyToLoad ? json_encode($all_tasks, JSON_NUMERIC_CHECK) : [],
        ]);
    }
}
