<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $time = '09:00';
        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('wa_settings')) {
                $dbTime = \App\Models\WaSetting::value('scheduled_time');
                if ($dbTime) {
                    $time = substr($dbTime, 0, 5); // Format: 'HH:MM'
                }
            }
        } catch (\Exception $e) {
            // Database not ready fallback
        }

        $schedule->command('wa:generate-notifications')->dailyAt($time);
        $schedule->command('wa:process-outbox')->everyMinute();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
