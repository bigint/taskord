<?php

namespace App\Http\Livewire\Pages\Open;

use App\Models\Task;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Reputations extends Component
{
    public $readyToLoad = false;

    public function loadReputations()
    {
        $this->readyToLoad = true;
    }

    public function render()
    {
        $created_at = carbon('Sep 1 2020')->format('Y-m-d');
        $current_date = carbon()->format('Y-m-d');
        $period = CarbonPeriod::create($created_at, $current_date);
        $reputations_count = Task::cacheFor(60 * 60)
            ->select('id')
            ->count();

        $week_dates = [];
        $reputations = [];
        $tasks = [];
        foreach ($period->toArray() as $date) {
            array_push($week_dates, carbon($date)->format('d M Y'));
            $count = DB::table('reputations')
                ->select('id', 'point')
                ->whereDate('created_at', carbon($date))
                ->sum('point');

            array_push($reputations, $count);
        }

        return view('livewire.pages.open.reputations', [
            'week_dates' => json_encode($week_dates, JSON_NUMERIC_CHECK),
            'reputations' => $this->readyToLoad ? json_encode($reputations, JSON_NUMERIC_CHECK) : [],
            'reputations_count' => $this->readyToLoad ? number_format($reputations_count) : '···',
        ]);
    }
}
