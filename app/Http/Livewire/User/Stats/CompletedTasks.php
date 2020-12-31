<?php

namespace App\Http\Livewire\User\Stats;

use Livewire\Component;
use Carbon\CarbonPeriod;
use Carbon\Carbon;

class CompletedTasks extends Component
{
    public $user;

    public function mount($user) {
        $this->user = $user;
    }

    public function render()
    {
        $created_at = Carbon::parse($this->user->created_at)->format('Y-m-d');
        $current_date = Carbon::now()->format('Y-m-d');
        $period = CarbonPeriod::create($created_at, '8 days', $current_date);
        $week_dates = [];
        foreach ($period->toArray() as $date) {
            array_push($week_dates, Carbon::parse($date)->format('Y-m-d'));
        }

        return view('livewire.user.stats.completed-tasks', [
            'week_dates' => json_encode($week_dates, JSON_NUMERIC_CHECK)
        ]);
    }
}
