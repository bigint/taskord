<?php

namespace App\Http\Livewire\Pages\Open;

use App\Models\User;
use Carbon\CarbonPeriod;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Reputations extends Component
{
    public $readyToLoad = false;

    public function loadReputations()
    {
        $this->readyToLoad = true;
    }

    public function render(): View
    {
        $createdAt = carbon('Sep 1 2020')->format('Y-m-d');
        $currentDate = carbon()->format('Y-m-d');
        $period = CarbonPeriod::create($createdAt, $currentDate);
        $reputationsCount = User::sum('reputation');

        $weekDates = [];
        $reputations = [];
        foreach ($period->toArray() as $date) {
            array_push($weekDates, carbon($date)->format('d M Y'));
            $count = DB::table('reputations')
                ->select('id', 'point')
                ->whereDate('created_at', carbon($date))
                ->sum('point');

            array_push($reputations, $count);
        }

        return view('livewire.pages.open.reputations', [
            'week_dates' => json_encode($weekDates, JSON_NUMERIC_CHECK),
            'reputations' => $this->readyToLoad ? json_encode($reputations, JSON_NUMERIC_CHECK) : [],
            'reputations_count' => $this->readyToLoad ? number_format($reputationsCount) : '···',
        ]);
    }
}
