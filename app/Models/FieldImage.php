<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FieldImage extends Model
{
    protected $fillable = [
        'field_id',
        'image_path',
        'is_primary',
        'sort_order',
    ];

    /**
     * Relation to fields
     */
    public function field(): BelongsTo
    {
        return $this->belongsTo(Field::class);
    }
}