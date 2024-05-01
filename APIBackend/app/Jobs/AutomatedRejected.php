<?php

namespace App\Jobs;

// use Log;
use Exception;
use App\Mail\RejectedEmail;
use Illuminate\Bus\Queueable;
use App\Models\Consultation_slot;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;

class AutomatedRejected implements ShouldQueue
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
        try {
            // Attempt to send the email
            Mail::to($this->consultation_slot->student->email)->send(new RejectedEmail($this->consultation_slot));
        } catch (\Exception $e) {
            // Log the exception
            Log::channel('failed_jobs')->error('Failed to send email: ' . $e->getMessage());
        }
        
    }

    public function failed(Exception $exception)
    {
        // Log the failed job
        Log::channel('failed_jobs')->error('Failed job: ' . $exception->getMessage());
    }
}
