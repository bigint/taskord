<?php

namespace App\Http\Livewire\User\Stats;

use Carbon\CarbonPeriod;
use Livewire\Component;

class Answers extends Component
{
    public $user;
    public $ready_to_load = false;

    public function mount($user)
    {
        $this->user = $user;
    }

    public function loadAnswers()
    {
        $this->ready_to_load = true;
    }

    public function render()
    {
        $created_at = $this->user->created_at->format('Y-m-d');
        $current_date = carbon()->format('Y-m-d');
        $period = CarbonPeriod::create($created_at, '7 days', $current_date);
        $answers_count = $this->user->answers()
            ->select('id')
            ->count();

        $week_dates = [];
        $answers = [];
        $tasks = [];
        foreach ($period->toArray() as $date) {
            array_push($week_dates, carbon($date)->format('d M Y'));
            $count = $this->user->answers()
                ->select('id')
                ->whereBetween('created_at', [carbon($date), carbon($date)->addDays(7)])
                ->count();
            array_push($answers, $count);
        }

        return view('livewire.user.stats.answers', [
            'week_dates' => $this->ready_to_load ? json_encode($week_dates, JSON_NUMERIC_CHECK) : [],
            'answers' => $this->ready_to_load ? json_encode($answers, JSON_NUMERIC_CHECK) : [],
            'answers_count' => $this->ready_to_load ? $answers_count : '···',
        ]);
    }
}
