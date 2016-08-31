<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

use App\Http\Controllers\mcScheduleController;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        // Commands\Inspire::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
      $schedule->call( 'App\Http\Controllers\mcScheduleController@do_5min_schedule_job' )->name( '5-min-job' )->everyFiveMinutes();
      $schedule->call( 'App\Http\Controllers\mcScheduleController@do_15min_schedule_job' )->name( '15-min-job' )->cron('*/15 * * * * *');
      $schedule->call( 'App\Http\Controllers\mcScheduleController@do_hour_schedule_job' )->name( 'hour-job' )->hourly();
      $schedule->call( 'App\Http\Controllers\mcScheduleController@do_daily_schedule_job' )->name( 'daily-job' )->daily();
        // $schedule->command('inspire')
        //          ->hourly();
    }
}
