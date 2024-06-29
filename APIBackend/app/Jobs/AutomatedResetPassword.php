<?php

namespace App\Jobs;

use Dotenv\Util\Str;
use Illuminate\Bus\Queueable;
use App\Mail\ResetPasswordEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class AutomatedResetPassword implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $to;
    private $otp;
    /**
     * Create a new job instance.
     */
    public function __construct(String $to, String $otp)
    {
        //
        $this->to = $to;
        $this->otp = $otp;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //
        Mail::to($this->to)->send(new ResetPasswordEmail($this->otp));
    }
}
