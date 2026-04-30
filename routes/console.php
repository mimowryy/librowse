<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Console\Commands\SendBookReminders;
use Illuminate\Support\Facades\Schedule;

Schedule::command('librowse:send-reminders')->dailyAt('08:00');
Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');
