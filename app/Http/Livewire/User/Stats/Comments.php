<?php

namespace App\Http\Livewire\User\Stats;

use Carbon\CarbonPeriod;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Comments extends Component
{
    public $user;
    public $readyToLoad = false;

    public function mount($user)
    {
        $this->user = $user;
    }

    public function loadComments()
    {
        $this->readyToLoad = true;
    }

    public function render(): View
    {
        $createdAt = $this->user->created_at->format('Y-m-d');
        $currentDate = carbon()->format('Y-m-d');
        $period = CarbonPeriod::create($createdAt, '7 days', $currentDate);
        $commentsCount = $this->user->comments()
            ->select('id')
            ->count();

        $weekDates = [];
        $comments = [];
        foreach ($period->toArray() as $date) {
            array_push($weekDates, carbon($date)->format('d M Y'));
            $count = $this->user->comments()
                ->select('id')
                ->whereBetween('created_at', [carbon($date), carbon($date)->addDays(7)])
                ->count();
            array_push($comments, $count);
        }

        return view('livewire.user.stats.comments', [
            'week_dates' => $this->readyToLoad ? json_encode($weekDates, JSON_NUMERIC_CHECK) : [],
            'comments' => $this->readyToLoad ? json_encode($comments, JSON_NUMERIC_CHECK) : [],
            'comments_count' => $this->readyToLoad ? $commentsCount : '···',
        ]);
    }
}
