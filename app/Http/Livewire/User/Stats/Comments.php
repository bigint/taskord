<?php

namespace App\Http\Livewire\User\Stats;

use App\Models\Comment;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
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

    public function render()
    {
        $created_at = Carbon::parse($this->user->created_at)->format('Y-m-d');
        $current_date = Carbon::now()->format('Y-m-d');
        $period = CarbonPeriod::create($created_at, '10 days', $current_date);
        $comments_count = Comment::cacheFor(60 * 60)
            ->select('id')
            ->where('user_id', $this->user->id)
            ->count();

        $week_dates = [];
        $comments = [];
        $tasks = [];
        foreach ($period->toArray() as $date) {
            array_push($week_dates, Carbon::parse($date)->format('d M Y'));
            $count = Comment::cacheFor(60 * 60)
                ->select('id')
                ->where('user_id', $this->user->id)
                ->whereBetween('created_at', [Carbon::parse($date), Carbon::parse($date)->addDays(10)])
                ->count();
            array_push($comments, $count);
        }

        return view('livewire.user.stats.comments', [
            'week_dates' => $this->readyToLoad ? json_encode($week_dates, JSON_NUMERIC_CHECK) : [],
            'comments' => $this->readyToLoad ? json_encode($comments, JSON_NUMERIC_CHECK) : [],
            'comments_count' => $this->readyToLoad ? $comments_count : '···'
        ]);
    }
}
