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
        return $this->pricings()->min('price_per_slot');
    }


    public function getSchedulesAttribute(): array
    {
        // 1. Ambil tanggal dinamis dari URL (jika tidak ada, gunakan hari ini)
        $dateString = request('date', now()->format('Y-m-d'));
        $selectedDate = Carbon::parse($dateString);
        $dayOfWeek = $selectedDate->dayOfWeek;

        // 2. Cek jam operasional
        $operatingHour = $this->operatingHours()->where('day_of_week', $dayOfWeek)->first();

        if (!$operatingHour || !$operatingHour->is_open) {
            return [];
        }

        // 3. Tentukan harga (weekday/weekend)
        $dayType = $selectedDate->isWeekday() ? 'weekday' : 'weekend';
        $pricing = $this->pricings()->where('day_type', $dayType)->first();

        if (!$pricing) {
            return [];
        }

        // 4. AMBIL SEMUA SLOT YANG SUDAH DIPESAN
        $bookedSlots = $this->bookingSlots()
            ->whereDate('booking_date', $selectedDate->format('Y-m-d'))
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

            // 5. PENENTUAN STATUS (Super Aman)
            // Gabungkan tanggal yang dipilih dengan jam slot untuk divalidasi
            $slotDateTime = $selectedDate->copy()->setTime($startTime->hour, $startTime->minute);

            // Cek 2 kondisi: Apakah sudah dipesan orang? ATAU Apakah waktunya sudah lewat (hari ini/kemarin)?
            if (in_array($timeString, $bookedSlots) || $slotDateTime->isPast()) {
                $status = 'booked';
            } else {
                $status = 'available';
            }

            $schedules[] = [
                'time' => $timeString,
                'price' => $pricing->price_per_slot,
                'status' => $status,
            ];

            $startTime->addHour();
        }

        return $schedules;
    }

    /**
     * Relation to table booking_slots 1 to many
     */
    public function bookingSlots(): HasMany
    {
        return $this->hasMany(BookingSlot::class);
    }
}
