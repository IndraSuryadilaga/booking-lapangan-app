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
     * Return full URL for the image (external URL or public storage).
     */
    public function getUrlAttribute(): ?string
    {
        if (! $this->image_path) {
            return null;
        }

        if (filter_var($this->image_path, FILTER_VALIDATE_URL)) {
            return $this->image_path;
        }

        return Storage::disk('public')->url($this->image_path);
    }

    /**
     * Provide `path` attribute expected in some views as a URL.
     */
    public function getPathAttribute(): ?string
    {
        return $this->url;
    }
}