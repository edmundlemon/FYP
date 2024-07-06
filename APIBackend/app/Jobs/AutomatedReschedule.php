<?php

namespace App\Jobs;

use App\Mail\RescheduleEmail;
use Illuminate\Bus\Queueable;
use App\Models\Consultation_slot;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class AutomatedReschedule implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(private string $requestor,private Consultation_slot $consultation_slot, private array $formFields, private $to)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //
        $formFields = $this->formFields;
        Mail::to($this->to)->send(new RescheduleEmail($this->requestor, $this->consultation_slot, $formFields));
    }
}
