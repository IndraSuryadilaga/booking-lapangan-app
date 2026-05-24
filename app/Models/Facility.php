<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Facility extends Model
{
    protected $fillable = [
        'name',
        'icon',
    ];

    public function venues()
{
    return $this->belongsToMany(
        Venue::class,
        'venue_facilities'
    );
}
}
