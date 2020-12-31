<?php

namespace App\Http\Livewire\User;

use Livewire\Component;
use Carbon\CarbonPeriod;
use Carbon\Carbon;

class Stats extends Component
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
        return view('livewire.user.stats', [
            'week_dates' => $week_dates
        ]);
    }
}
