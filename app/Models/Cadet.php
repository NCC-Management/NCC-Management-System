<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cadet extends Model
{
    protected $fillable = [
        'user_id',
        'enrollment_no',
        'student_id',
        'course',
        'phone',
        'dob',
        'gender',
        'address',
        'profile_completed',
    ];
<<<<<<< HEAD
=======

    protected $casts = [
        'dob' => 'date',
        'profile_completed' => 'boolean',
    ];

>>>>>>> 50b03e8 (Landing Page Updated)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}