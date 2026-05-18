<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');
Schedule::command('request:clean-rejected')->everyFiveMinutes();
Schedule::command('request:update-expired-request')->everyFiveMinutes();
Schedule::command('request:delete-finished-request')->everyFiveMinutes();