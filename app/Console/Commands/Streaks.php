<?php

namespace App\Console\Commands;

use App\Models\Task;
use App\Models\User;
use Carbon\CarbonPeriod;
use Illuminate\Console\Command;

class Streaks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:streaks {type=timezone}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calculate Streaks of an user';

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
        $timezones = timezone_identifiers_list();
        $tz_list = [];

        foreach ($timezones as $timezone) {
            $time = carbon()->tz($timezone)->format('H');
            if ($time === '23') {
                array_push($tz_list, $timezone);
            }
        }

        $type = $this->arguments()['type'];

        if ($type === 'timezone') {
            $this->info('Calculating timezone based users streaks!');
            $users = User::select('id', 'username', 'timezone', 'streaks', 'created_at')
                ->whereIn('timezone', $tz_list)
                ->get();
        } else {
            $this->info('Calculating all users streaks!');
            $users = User::select('id', 'username', 'timezone', 'streaks', 'created_at')
                ->get();
        }

        foreach ($users as $user) {
            $created_at = $user->created_at->format('Y-m-d');
            $current_date = carbon()->format('Y-m-d');
            $period = CarbonPeriod::create($created_at, $current_date);
            $streaks = 0;
            foreach ($period->toArray() as $date) {
                $count = Task::select('id')
                    ->where('user_id', $user->id)
                    ->whereDate('created_at', carbon($date))
                    ->count();
                if ($count > 0) {
                    $streaks += 1;
                } else {
                    $streaks = 0;
                }
            }

            if ($user->vacation_mode) {
                $this->info('Skipped streaks update for @'.$user->username.'! - '.$streaks.' Total Streaks');
            } else {
                $user->streaks = $streaks;
                $this->info('Calculation Successful for @'.$user->username.'! - '.$streaks.' Total Streaks');
                $user->save();
            }
        }
        $ops = User::where('username', 'ops')->first();
        loggy(request()->ip(), 'Admin', $ops, 'Resetted streaks for '.number_format(count($users)).' users in '.number_format(count($tz_list)).' timezones');
        $this->info('Streaks Calculation Completed!');

        return 0;
    }
}
