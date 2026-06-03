<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

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

    /**
     * Return full URL for the image (Storage::url)
     */
    public function getUrlAttribute()
    {
        if (! $this->image_path) {
            return null;
        }

        return Storage::url($this->image_path);
    }

    /**
     * Provide `path` attribute expected in some views as a URL.
     */
    public function getPathAttribute()
    {
        return $this->getUrlAttribute();
    }
}