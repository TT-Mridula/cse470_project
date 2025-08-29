<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public function profile()  { return $this->hasOne(\App\Models\UserProfile::class); }
    public function projects() { return $this->hasMany(\App\Models\UserProject::class); }
    public function skills()   { return $this->hasMany(\App\Models\UserSkill::class); }
    public function resume()   { return $this->hasOne(\App\Models\Resume::class); } 


  
    protected $fillable = [
    'name', 'email', 'password', 'is_admin', 'phone', 'otp_code', 'otp_expires_at', 'otp_attempts',
    ];

    /**
     * Hidden attributes for serialization.
     */
    protected $hidden = [
        'password',
        'remember_token',
        'login_otp', // never expose the code
    ];

 
    protected $casts = [
    'email_verified_at' => 'datetime',
    'password' => 'hashed',
    'is_admin' => 'boolean',
    'otp_expires_at' => 'datetime',
    'otp_attempts' => 'integer',
];
}
