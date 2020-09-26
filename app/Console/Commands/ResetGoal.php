<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class ResetGoal extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:reset-goal';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset all users daily goal';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $users = User::all();
        foreach($users as $user) {
            $user->daily_goal_reached = 0;
            $user->save();
        }
        $this->info("Reset Successful!");
        return 0;
    }
}
