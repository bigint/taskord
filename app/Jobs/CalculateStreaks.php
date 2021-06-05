<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CalculateStreaks implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function handle()
    {
        $createdAt = $this->user->created_at->format('Y-m-d');
        $currentDate = carbon()->format('Y-m-d');
        $period = CarbonPeriod::create($createdAt, $currentDate);
        $streaks = 0;
        foreach ($period->toArray() as $date) {
            $count = $this->user->tasks()
                ->select('id')
                ->whereUserId($this->user->id)
                ->whereDate('created_at', carbon($date))
                ->count();
            if ($count > 0) {
                $streaks += 1;
            } else {
                $streaks = 0;
            }
        }

        if (! $this->user->vacation_mode) {
            $this->user->streaks = $streaks;
            $this->user->save();
        }
    }
}
