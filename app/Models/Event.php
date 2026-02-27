<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'unit_id',
        'title',
        'description',
        'event_date'
    ];
}
