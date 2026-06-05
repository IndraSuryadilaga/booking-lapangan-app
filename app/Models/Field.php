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

    protected $casts = [
        'is_active' => 'boolean',
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
        return $this->pricings()->min('price_per_slot');
    }

    /**
     * Generate schedules for a given date, respecting operating hours,
     * pricing tiers, and existing paid bookings.
     *
     * @param  string|null  $date  Y-m-d format; defaults to today
     * @return array
     */
    public function getSchedulesForDate(?string $date = null): array
    {
        $carbon = $date ? Carbon::parse($date) : now();
        $dayOfWeek = $carbon->dayOfWeek;

        $operatingHour = $this->operatingHours
            ->firstWhere('day_of_week', $dayOfWeek)
            ?? $this->operatingHours()->where('day_of_week', $dayOfWeek)->first();

        if (!$operatingHour || !$operatingHour->is_open) {
            return [];
        }

        // Determine day type: holiday takes precedence over weekend/weekday.
        $isHoliday = \App\Models\PublicHoliday::where('holiday_date', $carbon->toDateString())->exists();
        if ($isHoliday) {
            $dayType = 'holiday';
        } elseif ($carbon->isWeekend()) {
            $dayType = 'weekend';
        } else {
            $dayType = 'weekday';
        }

        $pricing = $this->pricings
            ->firstWhere('day_type', $dayType)
            ?? $this->pricings()->where('day_type', $dayType)->first();

        if (!$pricing) {
            return [];
        }

        // Fetch already-booked slots for this field on this date (paid bookings).
        $bookedSlots = \App\Models\BookingSlot::where('field_id', $this->id)
            ->where('booking_date', $carbon->toDateString())
            ->whereHas('booking', fn ($q) => $q->where('status', 'paid'))
            ->pluck('start_time')
            ->map(fn ($t) => substr($t, 0, 5)) // normalize to H:i
            ->all();

        $schedules  = [];
        $startTime  = Carbon::parse($operatingHour->open_time);
        $closeTime  = Carbon::parse($operatingHour->close_time);

        while ($startTime < $closeTime) {
            $slotKey = $startTime->format('H:i');
            $schedules[] = [
                'time'   => $slotKey,
                'price'  => $pricing->price_per_slot,
                'status' => in_array($slotKey, $bookedSlots) ? 'booked' : 'available',
            ];
            $startTime->addHour();
        }

        return $schedules;
    }

    /**
     * Accessor — returns schedules for the date currently in the request
     * (query param 'date'), falling back to today.
     *
     * @return array
     */
    public function getSchedulesAttribute(): array
    {
        return $this->getSchedulesForDate(request('date'));
    }

    /**
     * Relation to table booking_slots 1 to many
     */
    public function bookingSlots(): HasMany
    {
        return $this->hasMany(BookingSlot::class);
    }
}
