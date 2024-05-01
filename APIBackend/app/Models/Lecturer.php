<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Lecturer extends Authenticatable
{

    use HasFactory, HasApiTokens;

    protected $fillable = [
        'id',
        'name',
        'email',
        'password',
        'faculty',
        'office',
        'photo'
    ];
    protected $hidden = [
        'password',
        // 'remember_token',
    ];
    

    protected $role = 'lecturer';
    protected $keyType = 'string';

    public function role(){
        return $this->role;
    }

    public function hasRole(string $role) {
        return $this->role == $role;
    }

    public function free_slots() {
        return $this->hasMany(Consultation_slot::class, 'lecturer_id');
    }

    public function reviews() {
        return $this->hasMany(Review::class, 'lecturer_id');
    }

    public function consultation_slots() {
        return $this->hasMany(Consultation_slot::class, 'lecturer_id');
    }

    public function upcoming() {
        return $this->free_slots()
            ->where('start_time', '>=', now())
            ->where('start_time', '<=', today()->addDays(7));
    }
}
