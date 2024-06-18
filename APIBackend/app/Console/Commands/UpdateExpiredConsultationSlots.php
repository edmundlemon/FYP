<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Models\Consultation_Slot;

class UpdateExpiredConsultationSlots extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-expired-consultation-slots';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
        $currentDateTime = Carbon::now();

        Consultation_Slot::where('date', '<', $currentDateTime->toDateString())
            ->orWhere(function ($query) use ($currentDateTime) {
                $query->where('date', '=', $currentDateTime->toDateString())
                      ->where('end_time', '<', $currentDateTime->toTimeString());
            })
            ->update(['status' => 'Expired']);
    }
}
