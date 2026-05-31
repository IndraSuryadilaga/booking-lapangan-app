<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SportsCategory extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'icon',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function venues()
    {
        return $this->belongsToMany(
            Venue::class,
            'venue_sport_categories'
        );
    }

    public function fields()
    {
        return $this->hasMany(Field::class);
    }
}