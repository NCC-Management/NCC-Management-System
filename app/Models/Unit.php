<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    protected $fillable = [
        'unit_name',
        'battalion',
        'state',
        'officer_name',
        'location',
        'contact',
    ];

    public function cadets()
    {
        return $this->hasMany(Cadet::class);
    }
}
