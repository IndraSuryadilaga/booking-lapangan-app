<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\FieldImage;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;

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
    public function pricings(): HasMany
    {
        return $this->hasMany(FieldPricing::class);
    }

    /**
     * Get the primary image for the field.
     *
     * @return \App\Models\FieldImage|null
     */
    public function getPrimaryImageAttribute(): ?FieldImage
    {
        return $this->images()->where('is_primary', true)->first()
            ?? $this->images()->orderBy('sort_order')->first();
    }

    /**
     * Get the URL of the primary image.
     *
     * @return string|null
     */
    public function getPrimaryImageUrlAttribute(): ?string
    {
        return $this->primary_image?->url;
    }

    /**
     * Get the cheapest price for the field.
     *
     * @return float|null
     */
    public function getCheapestPriceAttribute(): ?float
    {
        // Asumsi tabel field_pricings memiliki kolom 'price_per_slot'
        return $this->pricing()->min('price_per_slot');
    }

    /**
     * Generate schedules based on operating hours and pricing.
     *
     * @return array
     */
    public function getSchedulesAttribute(): array
    {

        $today = now();
        $dayOfWeek = $today->dayOfWeek;

        $operatingHour = $this->operatingHours()->where('day_of_week', $dayOfWeek)->first();

        if (!$operatingHour || !$operatingHour->is_open) {
            return [];
        }

        $dayType = $today->isWeekday() ? 'weekday' : 'weekend';
        $pricing = $this->pricing()->where('day_type', $dayType)->first();

        if (!$pricing) {
            return [];
        }

        $schedules = [];
        $startTime = Carbon::parse($operatingHour->open_time);
        $closeTime = Carbon::parse($operatingHour->close_time);

        while ($startTime < $closeTime) {
            $schedules[] = [
                'time' => $startTime->format('H:i'),
                'price' => $pricing->price_per_slot,
                'status' => 'available',
            ];
            $startTime->addHour();
        }

        return $schedules;
     * relation to table booking_slots 1 to many
     */
    public function bookingSlots(): HasMany
    {
        return $this->hasMany(BookingSlot::class);
    }
}
