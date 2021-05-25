<?php

namespace App\Http\Livewire\User\Stats;

use Carbon\CarbonPeriod;
use Livewire\Component;

class Comments extends Component
{
    public $user;
    public $ready_to_load = false;

    public function mount($user)
    {
        $this->user = $user;
    }

    public function loadComments()
    {
        $this->ready_to_load = true;
    }

    public function render()
    {
        $created_at = $this->user->created_at->format('Y-m-d');
        $current_date = carbon()->format('Y-m-d');
        $period = CarbonPeriod::create($created_at, '7 days', $current_date);
        $comments_count = $this->user->comments()
            ->select('id')
            ->count();

        $week_dates = [];
        $comments = [];
        $tasks = [];
        foreach ($period->toArray() as $date) {
            array_push($week_dates, carbon($date)->format('d M Y'));
            $count = $this->user->comments()
                ->select('id')
                ->whereBetween('created_at', [carbon($date), carbon($date)->addDays(7)])
                ->count();
            array_push($comments, $count);
        }

        return view('livewire.user.stats.comments', [
            'week_dates' => $this->ready_to_load ? json_encode($week_dates, JSON_NUMERIC_CHECK) : [],
            'comments' => $this->ready_to_load ? json_encode($comments, JSON_NUMERIC_CHECK) : [],
            'comments_count' => $this->ready_to_load ? $comments_count : '···',
        ]);
    }
}
