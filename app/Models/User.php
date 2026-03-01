<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

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

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // =========================
    // Relationships
    // =========================

    public function admin()
    {
        return $this->hasOne(Admin::class);
    }

    public function cadet()
    {
        return $this->hasOne(Cadet::class);
    }

    public function initials()
{
    return collect(explode(' ', $this->name))
        ->map(fn ($word) => strtoupper(substr($word, 0, 1)))
        ->join('');
}
}