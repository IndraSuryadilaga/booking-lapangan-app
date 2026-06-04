<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FieldPricing extends Model
{
    protected $fillable = [
        'day_type',
        'price_per_slot',
        'tier',
        'price',
    ];

    public function setTierAttribute($value)
    {
        $this->attributes['day_type'] = $value === 'regular' ? 'weekday' : $value;
    }

    public function setPriceAttribute($value)
    {
        $this->attributes['price_per_slot'] = $value;
    }

    public function getTierAttribute()
    {
        return $this->day_type === 'weekday' ? 'regular' : $this->day_type;
    }

    public function getPriceAttribute()
    {
        return $this->price_per_slot;
    }

    public function field()
    {
        return $this->belongsTo(Field::class);
    }
}
