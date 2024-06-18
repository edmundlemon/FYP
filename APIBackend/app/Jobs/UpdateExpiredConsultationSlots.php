<?php

namespace App\Jobs;

use App\Models\Consultation_Slot;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\SerializesModels;

class UpdateExpiredConsultationSlots implements ShouldQueue
{
    use SerializesModels;

    public $queue = 'default';
    public $connection = 'sync';

    public function handle()
    {
        $currentDateTime = Carbon::now();

        Consultation_Slot::where('date', '<', $currentDateTime->toDateString())
            ->orWhere(function ($query) use ($currentDateTime) {
                $query->where('date', '=', $currentDateTime->toDateString())
                      ->where('end_time', '<', $currentDateTime->toTimeString());
            })
            ->update(['status' => 'Expired']);
    }
}