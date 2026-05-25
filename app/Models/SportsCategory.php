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

    public function sportsCategories()
{
    return $this->belongsToMany(
        SportsCategory::class,
        'venue_sport_categories'
    );
}

    public function venues()
{
    return $this->belongsToMany(
        Venue::class,
        'venue_sport_categories'
    );
}
}
