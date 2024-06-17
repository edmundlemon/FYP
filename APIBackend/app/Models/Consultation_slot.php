<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Consultation_slot extends Model
{
    protected $fillable = [
        'student_id',
        'lecturer_id',
        'date',
        'start_time',
        'end_time',
        'topic',
        'status',
    ];

    use HasFactory;

    public function getStartTimeAttribute($value){
        return date('H:i', strtotime($value));
    }

    public function getEndTimeAttribute($value){
        return date('H:i', strtotime($value));
    }

    public function student() {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function lecturer() {
        return $this->belongsTo(Lecturer::class, 'lecturer_id');
    }

    public function upcoming(){
        return $this->where('start_time', '>=', now())
            ->where('start_time', '<=', now()->addMinutes(30))
            ->where('status', 'Request');
    }

    public function pending(){
        return $this->where('start_time', '>=', now())
            ->where('status', 'Requested');
    }

    public function approved(){
        return $this->where('start_time', '>=', now())
            ->where('status', 'Approved');
    }

    public function rejected(){
        return $this->where('start_time', '>=', now())
            ->where('status', 'Rejected');
    }

    public function studentCheckRescheduled(){
        return $this->where('start_time', '>=', now())
            ->where('status', 'Lecturer Rescheduled');
    }

    public function lecturerCheckRescheduled(){
        return $this->where('start_time', '>=', now())
            ->where('status', 'Student Rescheduled');
    }

    public function lecturerReschedule(Lecturer $lecturer){
        return $this->where('lecturer_id', $lecturer->id)
            ->where('start_time', '>=', now())
            ->where('status', 'Lecturer Rescheduled');
    }

    public function studentReschedule(Student $student){
        return $this->where('student_id', $student->id)
            ->where('start_time', '>=', now())
            ->where('status', 'Student Rescheduled');
    }

    public function collision(){
        // return DB::table('consultation_slots')
        //     ->where('lecturer_id', $consultation_slot->lecturer_id)
        //     ->where('date', $consultation_slot->date)
        //     ->where('status', 'Approved')
        //     ->where(function ($query) use ($consultation_slot) {
        //         $query->where(function ($query) use ($consultation_slot) {
        //             $query->where('start_time', '<', $consultation_slot->start_time)
        //                 ->where('end_time', '>', $consultation_slot->start_time);
        //         })->orWhere(function ($query) use ($consultation_slot) {
        //             $query->where('start_time', '<', $consultation_slot->end_time)
        //                 ->where('end_time', '>', $consultation_slot->end_time);
        //         })->orWhere(function ($query) use ($consultation_slot) {
        //             $query->where('start_time', '>', $consultation_slot->start_time)
        //                 ->where('end_time', '<', $consultation_slot->end_time);
        //         });
            // })->exists();

        $collision =   $this->where('lecturer_id', $this->lecturer_id)
        ->where('date', $this->date)
        ->where('start_time', '<', $this->end_time)
        ->where('end_time', '>', $this->start_time)
        ->where('status', 'Approved')
        ->orWhere('lecturer_id', $this->lecturer_id)
        ->where('date', $this->date)
        ->where('start_time', '<', $this->start_time)
        ->where('end_time', '>', $this->end_time)
        ->where('status', 'Approved')
        ->orWhere('lecturer_id', $this->lecturer_id)
        ->where('date', $this->date)
        ->where('start_time', '>=', $this->start_time)
        ->where('end_time', '<', $this->end_time)
        ->where('status', 'Approved')
        ->exists();

        return $collision;
    }
}
