<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Venue extends Model
{
    use HasFactory;

    protected $fillable = [
        'admin_id',
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
        'is_active',
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

    public function admin()
{
    return $this->belongsTo(User::class, 'admin_id');
}

    public function fields()
{
    return $this->hasMany(Field::class);
}

    public function reviews()
{
    return $this->hasMany(Review::class);
}

    public function getLogoUrlAttribute()
    {
        if (!$this->logo) {
            return 'https://images.unsplash.com/photo-1527067829737-402993088e6b?w=150&h=150&fit=crop';
        }
        if (filter_var($this->logo, FILTER_VALIDATE_URL)) {
            return $this->logo;
        }
        return Storage::url($this->logo);
    }

    protected $casts = [
    'is_active' => 'boolean',
];
}
