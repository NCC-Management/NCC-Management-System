<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $fillable = [
        'cadet_id',
        'event_id',
        'status'
    ];
}
