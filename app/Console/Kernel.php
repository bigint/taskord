<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     *
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('app:clean')->everyTenMinutes();
        $schedule->command('backup:clean')->everyThreeHours();
        $schedule->command('backup:run')->everyThreeHours();
        $schedule->command('disposable:update')->daily();
        $schedule->command('user:reset-goal')->dailyAt('00:00');
        $schedule->command('user:streaks')->hourly();
        $schedule->command('auth:clear-resets')->weekly();
        $schedule->command('cloudflare:reload')->daily();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
