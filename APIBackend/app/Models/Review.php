<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    public function lecturer() {
        return $this->belongsTo(Lecturer::class, 'lecturer_id');
    }

    public function student() {
        return $this->belongsTo(Student::class, 'student_id');
    }
}
