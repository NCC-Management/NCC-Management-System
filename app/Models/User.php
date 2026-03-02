<?php

namespace App\Models;

<<<<<<< HEAD
use Illuminate\Database\Eloquent\Factories\HasFactory;
=======
>>>>>>> 50b03e8 (Landing Page Updated)
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
<<<<<<< HEAD
    use HasApiTokens, HasFactory, Notifiable;
=======
    use HasApiTokens, Notifiable;
>>>>>>> 50b03e8 (Landing Page Updated)

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
<<<<<<< HEAD
        'phone'
=======
        'phone',
>>>>>>> 50b03e8 (Landing Page Updated)
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

<<<<<<< HEAD
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
=======
    /**
     * Relationships
     */
>>>>>>> 50b03e8 (Landing Page Updated)

    public function cadet()
    {
        return $this->hasOne(Cadet::class);
    }

<<<<<<< HEAD
    public function initials()
{
    return collect(explode(' ', $this->name))
        ->map(fn ($word) => strtoupper(substr($word, 0, 1)))
        ->join('');
}
=======
    public function admin()
    {
        return $this->hasOne(Admin::class);
    }

    /**
     * Role Helpers (clean & scalable)
     */

    public function isCadet()
    {
        return $this->role === 'cadet';
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }
>>>>>>> 50b03e8 (Landing Page Updated)
}