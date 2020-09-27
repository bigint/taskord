<?php

namespace App\Jobs;

use App\Gamify\Points\GoalReached;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Carbon\Carbon;

class CheckGoal implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;
    protected $task;

    /**
     * Create a new job instance.
     *
     * @return void
     */
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

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $last_reached = \DB::table('reputations')
            ->where('payee_id', $this->user->id)
            ->where('name', 'GoalReached')
            ->latest()
            ->get();
        if ($last_reached->isEmpty()) {
            if ($this->user->daily_goal_reached === $this->user->daily_goal) {
                $this->giveReputation();
            }
        } else {
            if (! Carbon::parse($last_reached->last()->created_at)->isToday()) {
                if ($this->user->daily_goal_reached === $this->user->daily_goal) {
                    $this->giveReputation();
                }
            }
        }
    }
}
