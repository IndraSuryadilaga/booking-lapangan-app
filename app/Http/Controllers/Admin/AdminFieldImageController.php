<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Field;
use App\Models\FieldImage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AdminFieldImageController extends Controller
{
    use AuthorizesRequests;

    public function store(Request $request, Field $field)
    {
        $this->authorize('update', $field);

        $request->validate([
            'images'   => 'required|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,webp|max:10000',
        ]);

        DB::transaction(function () use ($request, $field) {
            $currentImageCount = $field->images()->count();

            foreach ($request->file('images') as $index => $image) {
                $imagePath = $image->store('fields', 'public');

                FieldImage::create([
                    'field_id'   => $field->id,
                    'image_path' => $imagePath,
                    'is_primary' => $currentImageCount === 0 && $index === 0,
                    'sort_order' => $currentImageCount + $index,
                ]);
            }
        });

        return back()->with('success', 'Gambar berhasil diunggah.');
    }

    public function setPrimary(Field $field, FieldImage $image)
    {
        $this->authorize('update', $field);

        DB::transaction(function () use ($field, $image) {
            $field->images()->update(['is_primary' => false]);
            $image->update(['is_primary' => true]);
        });

        return back()->with('success', 'Gambar utama berhasil diubah.');
    }

    public function destroy(FieldImage $image)
    {
        $field = Field::findOrFail($image->field_id);
        $this->authorize('update', $field);

        DB::transaction(function () use ($image, $field) {
            $wasPrimary = $image->is_primary;

            if (!str_starts_with($image->image_path, 'http')) {
                Storage::disk('public')->delete($image->image_path);
            }

            $image->delete();

            if ($wasPrimary) {
                $newPrimary = $field->images()->first();
                if ($newPrimary) {
                    $newPrimary->update(['is_primary' => true]);
                }
            }
        });

        return back()->with('success', 'Gambar berhasil dihapus.');
    }
}
