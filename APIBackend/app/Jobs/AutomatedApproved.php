<?php

namespace App\Jobs;

use App\Mail\ApprovedEmail;
use Illuminate\Bus\Queueable;
use App\Models\Consultation_slot;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class AutomatedApproved implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(private Consultation_slot $consultation_slot)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //
        if (auth('sanctum')->user()->hasRole('lecturer')) {
            Mail::to($this->consultation_slot->student->email)->send(new ApprovedEmail($this->consultation_slot, $this->consultation_slot->lecturer->name));
        }
        else if(auth('sanctum')->user()->hasRole('student')) {
            Mail::to($this->consultation_slot->lecturer->email)->send(new ApprovedEmail($this->consultation_slot, $this->consultation_slot->student->name));
        }
        // Mail::to($this->consultation_slot->student->email)->send(new ApprovedEmail($this->consultation_slot));
    }
}
