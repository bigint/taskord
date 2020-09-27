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

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //$this->user->givePoint(new GoalReached($this->task));
        $last_reached = \DB::table('reputations')
            ->where('payee_id', $this->user->id)
            ->where('name', 'GoalReached')
            ->latest()
            ->get();
        if ($last_reached->isEmpty()) {
            $this->user->givePoint(new GoalReached($this->task));
            dd('given first time');
            
            return true;
        }
        
        if (! Carbon::parse($last_reached->last()->created_at)->isToday()) {
            $this->user->givePoint(new GoalReached($this->task));
            dd('given');
            
            return true;
        } else {
            dd('not given');
            return false;
        }
    }
}
