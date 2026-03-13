<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CadetNotification extends Model
{
    protected $table = 'cadet_notifications';

    protected $fillable = [
        'cadet_id',
        'title',
        'message',
        'is_read',
        'type',
    ];

    protected $casts = [
        'is_read' => 'boolean',
    ];

    public function cadet()
    {
        return $this->belongsTo(Cadet::class);
    }
}
