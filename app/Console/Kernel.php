<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    // Add this property
    protected $commands = [
        \App\Console\Commands\UpdateProgramProgress::class,
    ];

    protected function schedule(Schedule $schedule)
    {
        $schedule->command('programs:update-progress')->everyMinute();
    }

    protected function commands()
    {
        $this->load(__DIR__.'/Commands');
    }
}

