<?php

namespace App\Jobs;

use App\Gamify\Points\GoalReached;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CheckGoal implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;
    protected $task;

    public function __construct($user, $task)
    {
        $this->user = $user;
        $this->task = $task;
    }

    public function giveReputation()
    {
        $awarded = (int) round(3 * sqrt($this->user->daily_goal));
        $this->user->givePoint(new GoalReached($this->task, $awarded));
    }

    public function handle()
    {
        $lastReached = \DB::table('reputations')
            ->wherePayeeId($this->user->id)
            ->whereName('GoalReached')
            ->latest()
            ->get();
        if ($lastReached->isEmpty()) {
            if ($this->user->daily_goal_reached === $this->user->daily_goal) {
                $this->giveReputation();
            }
        } else {
            if (! carbon($lastReached->last()->created_at)->isToday()) {
                if ($this->user->daily_goal_reached === $this->user->daily_goal) {
                    $this->giveReputation();
                }
            }
        }
    }
}
