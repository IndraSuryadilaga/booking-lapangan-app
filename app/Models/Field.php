<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Field extends Model
{
    protected $fillable = [
        'sports_category_id', 
        'name', 
        'slug', 
        'description', 
        'price_per_slot', 
        'photo', 
        'is_active'
    ];

    public function operatingHours()
    {
        return $this->hasMany(FieldOperatingHour::class);
    }

    public function sportsCategory()
    {
        return $this->belongsTo(SportsCategory::class);
    }
}