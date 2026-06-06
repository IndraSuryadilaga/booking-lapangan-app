<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;
    
    protected static function booted()
    {
        static::creating(function ($booking) {
            $field = \App\Models\Field::find($booking->field_id);
            if ($field && !$field->is_active) {
                throw new \Exception('Lapangan sedang ditutup sementara (Maintenance Mode).');
            }
        });
    }

    protected $fillable = [
        'user_id',
        'field_id',
        'booking_date',
        'total_slots',
        'total_price',
        'status',
        'notes',
        'expires_at',
    ];

    protected $casts = [
        'booking_date' => 'date',
        'expires_at' => 'datetime',
    ];

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeConfirmed($query)
    {
        return $query->where('status', 'paid');
    }

    public function scopeCancelled($query)
    {
        return $query->where('status', 'cancelled');
    }


    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function field(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Field::class);
    }

    public function slots()
    {
        return $this->hasMany(BookingSlot::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function review()
    {
        return $this->hasOne(Review::class);
    }
}
