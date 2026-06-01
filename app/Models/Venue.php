<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Venue extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'address',
        'city',
        'province',
        'latitude',
        'longitude',
        'rating_avg',
        'review_count',
        'refund_policy',
        'reschedule_policy',
        'logo',
    ];

   public function facilities()
{
    return $this->belongsToMany(
        Facility::class,
        'venue_facilities'
    );
}

    public function sportsCategories()
{
    return $this->belongsToMany(
        SportsCategory::class,
        'venue_sport_categories'
    );
}

    public function reviews()
{
    return $this->hasMany(Review::class);
}
}
