<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Field;
use App\Models\FieldImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminFieldImageController extends Controller
{
    public function store(Request $request, Field $field)
    {
        $request->validate([
            'images'   => 'required|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,webp|max:10000',
        ]);

        foreach ($request->file('images') as $index => $image) {
            $imagePath = $image->store('fields', 'public');

            FieldImage::create([
                'field_id'   => $field->id,
                'image_path' => $imagePath,
                'is_primary' => $field->images()->count() === 0 && $index === 0,
                'sort_order' => $field->images()->count() + $index,
            ]);
        }

        return back()->with('success', 'Gambar berhasil diunggah.');
    }

    public function setPrimary(Field $field, FieldImage $image)
    {
        $field->images()->update(['is_primary' => false]);
        $image->update(['is_primary' => true]);

        return back()->with('success', 'Gambar utama berhasil diubah.');
    }

    public function destroy(FieldImage $image)
    {
        Storage::disk('public')->delete($image->image_path);

        $fieldId = $image->field_id;
        $wasPrimary = $image->is_primary;

        $image->delete();

        if ($wasPrimary) {
            $newPrimary = FieldImage::where('field_id', $fieldId)->first();
            if ($newPrimary) {
                $newPrimary->update(['is_primary' => true]);
            }
        }

        return back()->with('success', 'Gambar berhasil dihapus.');
    }
}
