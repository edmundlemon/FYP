<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Student extends Authenticatable
{

    use HasFactory, HasApiTokens;

    protected $fillable = [
        'id',
        'name',
        'email',
        'password',
        'faculty',
        'program',
        'photo'
    ];
    protected $hidden = [
        'password',
        // 'remember_token',
    ];
    
    protected $role = 'student';
    protected $keyType = 'string';

    // public function following() {
    //     return $this->belongsToMany(User::class, 'user_relationships', 'student_id', 'lecturer_id');
    // }

    public function role(){
        return $this->role;
    }

    public function hasRole(string $role) {
        return $this->role == $role;
    }
    
    public function consultation_slots() {
        return $this->hasMany(Consultation_slot::class, 'student_id');
    }

    public function reviewed() {
        return $this->hasMany(Review::class, 'student_id');
    }

    public function upcomingAppointment(){
        return $this
            ->hasMany(Consultation_slot::class, 'student_id')
            ->where('start_time', '>', now())
            ->where('start_time', '<=', now()->addMinutes(30))
            ->where('status', 'accepted');
    }
}
