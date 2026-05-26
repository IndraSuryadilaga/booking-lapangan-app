<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FieldPricing extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'field_id',
        'day_type',
        'price_per_slot',
    ];

    /**
     * Relation to the fields table (Inverse One-to-Many).
     */
    public function field(): BelongsTo
    {
        return $this->belongsTo(Field::class);
    }
}