<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Sanctum\HasApiTokens;
class User extends Authenticatable
{
    use HasApiTokens;

    protected $fillable = [
    'name',
    'email',
    'password',
    'role',
    'phone'
];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Relationships
    public function admin()
    {
        return $this->hasOne(Admin::class);
    }

    public function cadet()
    {
        return $this->hasOne(Cadet::class);
    }
}