<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // Daily restart to pick up deployments/new code
        $schedule->command('queue:restart')
            ->dailyAt('03:00')
            ->withoutOverlapping();

        // Queue health check with sane defaults for monitoring (adjust thresholds via env/cron)
        $schedule->command('queue:health --queue=default --max-size=100 --max-failed=0')
            ->everyFifteenMinutes()
            ->withoutOverlapping()
            ->onOneServer()
            ->appendOutputTo(storage_path('logs/queue-health.log'));
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
