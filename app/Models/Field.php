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

    public function venue(): BelongsTo
    {
        return $this->belongsTo(Venue::class);
    }

    public function sportsCategory(): BelongsTo
    {
        return $this->belongsTo(SportsCategory::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(FieldImage::class);
    }

    public function operatingHours(): HasMany
    {
        return $this->hasMany(FieldOperatingHour::class);
    }

    public function pricings(): HasMany
    {
        return $this->hasMany(FieldPricing::class);
    }

    public function bookingSlots(): HasMany
    {
        return $this->hasMany(BookingSlot::class);
    }

    public function getPrimaryImageAttribute(): ?FieldImage
    {
        return $this->images()->where('is_primary', true)->first()
            ?? $this->images()->orderBy('sort_order')->first();
    }

    public function getPrimaryImageUrlAttribute(): ?string
    {
        return $this->primary_image?->url;
    }

    public function getCheapestPriceAttribute(): ?float
    {
        return $this->pricings()->min('price_per_slot');
    }

    public function getSchedulesAttribute(): array
    {
        return $this->getSchedulesForDate(request('date', now()->format('Y-m-d')));
    }

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

        $bookedSlots = $this->bookingSlots()
            ->whereDate('booking_date', $carbon->toDateString())
            ->whereHas('booking', function ($query) {
                $query->whereIn('status', ['pending', 'paid', 'confirmed']);
            })
            ->pluck('start_time')
            ->map(function ($time) {
                return Carbon::parse($time)->format('H:i');
            })
            ->toArray();

        $schedules = [];
        $startTime = Carbon::parse($operatingHour->open_time);
        $closeTime = Carbon::parse($operatingHour->close_time);

        while ($startTime < $closeTime) {
            $timeString = $startTime->format('H:i');

            $slotDateTime = $carbon->copy()->setTime($startTime->hour, $startTime->minute);

            if (in_array($timeString, $bookedSlots) || $slotDateTime->isPast()) {
                $status = 'booked';
            } else {
                $status = 'available';
            }

            $schedules[] = [
                'time'   => $timeString,
                'price'  => $pricing->price_per_slot,
                'status' => $status,
            ];

            $startTime->addHour();
        }

        return $schedules;
    }
}