<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use Carbon\CarbonPeriod;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Graph extends Component
{
    public $readyToLoad = false;
    public User $user;

    public function mount($user)
    {
        $this->user = $user;
    }

    public function loadGraph()
    {
        $this->readyToLoad = true;
    }

    public function getGraph($type)
    {
        $start_date = carbon('60 days ago')->format('Y-m-d');
        $current_date = carbon()->format('Y-m-d');
        $period = CarbonPeriod::create($start_date, $current_date);

        $week_dates = [];
        $tasks = [];
        foreach ($period->toArray() as $date) {
            array_push($week_dates, carbon($date)->format('d M Y'));
            $count = $this->user->tasks()
                ->select('id', 'created_at')
                ->whereDate('created_at', carbon($date))
                ->count();

            array_push($tasks, $count);
        }

        if ($type === 'tasks') {
            return $tasks;
        }

        return $week_dates;
    }

    public function render(): View
    {
        return view('livewire.user.graph', [
            'week_dates' => $this->readyToLoad ? json_encode($this->getGraph('week_dates'), JSON_NUMERIC_CHECK) : [],
            'tasks' => $this->readyToLoad ? json_encode($this->getGraph('tasks'), JSON_NUMERIC_CHECK) : [],
            'count' => $this->readyToLoad ? array_sum($this->getGraph('tasks')) : 0,
        ]);
    }
}
