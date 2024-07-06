<?php

namespace App\Jobs;

use Spatie\FlareClient\Api;
use Illuminate\Bus\Queueable;
use App\Mail\CancellationEmail;
use App\Models\Consultation_slot;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class AutomatedCancellation implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(private Consultation_slot $consultation_slot, private $to, private $requestor)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //
        Mail::to($this->to)->send(new CancellationEmail($this->consultation_slot, $this->requestor));
    }
}
