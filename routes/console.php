<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');
Schedule::command('request:clean-rejected')->everyThreeHours();
Schedule::command('request:update-expired-request')->everyThreeHours();
Schedule::command('request:delete-finished-request')->everyThreeHours();