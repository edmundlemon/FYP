<?php

// use Illuminate\Console\Scheduling\Schedule;

use App\Console\Commands\DropPastFreeSlots;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use App\Console\Commands\SendEmails;
// use App\Jobs\UpdateExpiredConsultationSlots;
use App\Console\Commands\UpdatedExpiredStatus;

// use App\Jobs\UpdateExpiredConsultationSlots;
/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// To call the the command on schedule, with athe duration stated in the command
Schedule::command(SendEmails::class)->everyMinute()->runInBackground();
Schedule::command(DropPastFreeSlots::class)->daily()->runInBackground();
Schedule::command(UpdatedExpiredStatus::class)->everyMinute()->runInBackground();
// Schedule::job(new UpdateExpiredConsultationSlots)->everyMinute()->name('Update Expired Consultation Slots');
// Schedule::job(new UpdateExpiredConsultationSlots)->everyMinute()->name('Update Expired Consultation Slots');
// Schedule::job(new UpdateExpiredConsultationSlots)->name('Update Expired Consultation Slots')->everyMinute();