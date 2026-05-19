<?php

use App\Jobs\ProcesarRecordatorios;
use App\Jobs\Recordatorios;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::job(new ProcesarRecordatorios)
    // ->dailyAt('08:00')
    ->everyTenSeconds()
    ->withoutOverlapping();
// Schedule::job(new Recordatorios)
//     ->everyTenSeconds();
