<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeaveRequest extends Model
{
    protected $fillable = [
        'cadet_id',
        'reason',
        'from_date',
        'to_date',
        'status',
        'admin_note',
    ];

    protected $casts = [
        'from_date' => 'date',
        'to_date'   => 'date',
    ];

    public function cadet()
    {
        return $this->belongsTo(Cadet::class);
    }
}
