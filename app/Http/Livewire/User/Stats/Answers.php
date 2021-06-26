<?php

namespace App\Http\Livewire\User\Stats;

use Carbon\CarbonPeriod;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Answers extends Component
{
    public $user;
    public $readyToLoad = false;

    public function mount($user)
    {
        $this->user = $user;
    }

    public function loadAnswers()
    {
        $this->readyToLoad = true;
    }

    public function render(): View
    {
        $createdAt = $this->user->created_at->format('Y-m-d');
        $currentDate = carbon()->format('Y-m-d');
        $period = CarbonPeriod::create($createdAt, '7 days', $currentDate);
        $answersCount = $this->user->answers()
            ->select('id')
            ->count();

        $weekDates = [];
        $answers = [];
        foreach ($period->toArray() as $date) {
            array_push($weekDates, carbon($date)->format('d M Y'));
            $count = $this->user->answers()
                ->select('id')
                ->whereBetween('created_at', [carbon($date), carbon($date)->addDays(7)])
                ->count();
            array_push($answers, $count);
        }

        return view('livewire.user.stats.answers', [
            'week_dates' => $this->readyToLoad ? json_encode($weekDates, JSON_NUMERIC_CHECK) : [],
            'answers' => $this->readyToLoad ? json_encode($answers, JSON_NUMERIC_CHECK) : [],
            'answers_count' => $this->readyToLoad ? $answersCount : '···',
        ]);
    }
}
