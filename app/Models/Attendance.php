<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $fillable = [
        'event_id',
        'cadet_id',
        'status'
    ];

    // Relationship with Cadet
    public function cadet()
    {
        return $this->belongsTo(Cadet::class);
    }

    // Relationship with Event
    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}