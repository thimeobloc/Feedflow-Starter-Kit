<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Console\Scheduling\Schedule;


//Execute the command everyday at 00:01
protected function schedule(Schedule $schedule)
{
    $schedule->command('app:check-for-survey-to-close')
        ->dailyAt('00:01');
}

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

