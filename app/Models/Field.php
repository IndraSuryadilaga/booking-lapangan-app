<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Field extends Model
{
    use HasFactory;

    protected $fillable = [
        'venue_id',
        'sports_category_id',
        'name',
        'slug',
        'description',
        'type',
        'surface_material',
        'is_active',
    ];

    /**
     * Relation to table vaenues 1 to 1
     */
    public function venue(): BelongsTo
    {
        return $this->belongsTo(Venue::class);
    }

    /**
     * Relation to table sports_categories 1 to 1
     */
    public function sportsCategory(): BelongsTo
    {
        return $this->belongsTo(SportsCategory::class);
    }

    /**
     * relation to table field_images 1 to many
     */
    public function images(): HasMany
    {
        return $this->hasMany(FieldImage::class);
    }

    /**
     * relation to table field_operating_hours 1 to many
     */
    public function operatingHours(): HasMany
    {
        return $this->hasMany(FieldOperatingHour::class);
    }

    /**
     * relation to table field_pricing 1 to many
     */
    public function pricing(): HasMany
    {
        return $this->hasMany(FieldPricing::class);
    }

}