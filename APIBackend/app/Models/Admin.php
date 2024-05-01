<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Admin extends Authenticatable
{
    use HasFactory, HasApiTokens;

    protected $fillable = [
        'id',
        'name',
        'email',
        'password',
        'photo'
    ];
    protected $hidden = [
        'password',
    ];
    // The line below is to ensure that the laravel is treating primary key as a string
    protected $keyType = 'string';
    protected $role = 'admin';
    protected $table = 'admins';

    public function role(){
        return $this->role;
    }

    public function hasRole(string $role) {
        return $this->role == $role;
    }
}
