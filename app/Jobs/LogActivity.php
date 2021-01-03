<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class LogActivity implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $type;
    protected $user;
    protected $message;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($type, $user, $message)
    {
        $this->type = $type;
        $this->user = $user;
        $this->message = $message;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        activity()
            ->causedBy($this->user)
            ->withProperties(['type' => $this->type])
            ->log($this->message);
    }
}
