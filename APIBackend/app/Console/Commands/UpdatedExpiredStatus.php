<?php

namespace App\Console\Commands;

use App\Models\Consultation_Slot;
use Carbon\Carbon;
use Illuminate\Console\Command;

class UpdatedExpiredStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:updated-expired-status';

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

        Consultation_Slot::where(function ($query) use ($currentDateTime) {
            $query->where('date', '<', $currentDateTime->toDateString())
                ->orWhere(function ($query) use ($currentDateTime) {
                    $query->where('date', '=', $currentDateTime->toDateString())
                        ->where('end_time', '<', $currentDateTime->toTimeString());
                });
        })
            ->where('status', '!=', 'Expired')
            ->update(['status' => 'Expired']);
    }
}
