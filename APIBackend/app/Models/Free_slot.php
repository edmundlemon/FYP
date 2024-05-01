<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Free_slot extends Model
{

    protected $fillable = [
        'date',
        'start_time', 
        'end_time', 
        'lecturer_id'
    ];

    use HasFactory;

    public function user() {
        return $this->belongsTo(Lecturer::class, 'id');
    }

    public function upcoming($query, Lecturer $lecturer) {
        return $query->where('lecturer_id', $lecturer->id)
            ->where('start_time', '>=', now())
            ->where('start_date', '<=', today()->addDays(7));
    }

    // !The function below is a test, might replace the upcoming() function
    public function scopeUpcoming($query, Lecturer $lecturer) {
        return $query->where('lecturer_id', $lecturer->id)
            ->where('start_time', '>=', now())
            ->where('start_date', '<=', today()->addDays(7));
    }
}
