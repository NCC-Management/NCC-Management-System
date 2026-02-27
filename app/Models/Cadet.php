<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cadet extends Model
{
    protected $fillable = [
        'user_id',
        'enrollment_no'
    ];
}