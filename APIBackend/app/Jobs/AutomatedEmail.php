<?php

namespace App\Jobs;

use Carbon\Carbon;
use App\Mail\ReminderEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class AutomatedEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //
        $reminders = DB::table('consultation_slots')
        ->join('students', 'students.id', '=', 'consultation_slots.student_id')
        ->join('lecturers', 'lecturers.id', '=', 'consultation_slots.lecturer_id')
        ->select('students.email as student_email', 'students.name as student_name', 'consultation_slots.*',  'lecturers.email as lecturer_email', 'lecturers.name as lecturer_name')
        ->where('start_time', '>=', now())
        ->where('start_time', '<=', now()->addMinutes(30))
        ->where('status', 'accepted')
        ->get();

        foreach($reminders as $reminder){
            // Send email to student
            $to = $reminder->student_email;
            $reminder->start_time = Carbon::parse($reminder->start_time)->format('Y-m-d H:i');
            Mail::to($to)->send(new ReminderEmail($reminder->lecturer_name, $reminder->start_time));

            // Send email to lecturer
            $to = $reminder->lecturer_email;
            Mail::to($to)->send(new ReminderEmail($reminder->student_name, $reminder->start_time));
        }
    }
}
