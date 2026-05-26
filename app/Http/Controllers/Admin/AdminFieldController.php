<?php

namespace App\Http\Controllers\Admin;

use App\Models\Field;
use App\Models\Venue;
use App\Models\FieldImage;
use App\Models\SportsCategory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class AdminFieldController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Tambahkan 'venue' dan ganti ->get() jadi ->paginate(10)
        $fields = Field::with(['venue', 'sportsCategory', 'images'])
            ->latest()
            ->paginate(10);

        return view('admin.fields.index', compact('fields'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
{
    $categories = SportsCategory::where('is_active', true)->get();

    $venues = Venue::all();

    return view('admin.fields.create', compact('categories', 'venues'));
}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'venue_id'           => 'required|exists:venues,id',
            'sports_category_id' => 'required|exists:sports_categories,id',
            'name'               => 'required|string|max:255',
            'description'        => 'nullable|string',            
            'images'             => 'required|array',
            'images.*'           => 'image|mimes:jpeg,png,jpg,webp|max:10000',
        ]);

        DB::transaction(function () use ($request) {
            
            $field = Field::create([
                'venue_id'           => $request->venue_id,
                'sports_category_id' => $request->sports_category_id,
                'name'               => $request->name,
                'slug'               => Str::slug($request->name) . '-' . uniqid(),
                'description'        => $request->description,
                'is_active'          => true,
            ]);

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $index => $image) {
                    $imagePath = $image->store('fields', 'public');
                    
                    FieldImage::create([
                        'field_id'   => $field->id,
                        'image_path' => $imagePath,
                        'is_primary' => $index === 0,
                        'sort_order' => $index,
                    ]);
                }
            }
            
        });

        return redirect()->route('fields.index')->with('success', 'Lapangan berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Field $field)
    {
        $field->load([
        'sportsCategory',
        'operatingHours',
        'images'
    ]);
        
        return view('admin.fields.show', compact('field'));
    }

    public function edit(Field $field)
    {
        $categories = SportsCategory::where('is_active', true)->get();
        $venues = Venue::all();
        $field->load('operatingHours', 'images');
        return view('admin.fields.edit', compact('field', 'categories', 'venues'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Field $field)
    {
        $request->validate([
            'venue_id'           => 'required|exists:venues,id',
            'sports_category_id' => 'required|exists:sports_categories,id',
            'name'               => 'required|string|max:255',
            'description'        => 'nullable|string',
            'images'             => 'nullable|array',
            'images.*'           => 'image|mimes:jpeg,png,jpg,webp|max:10000',
        ]);

        DB::transaction(function () use ($request, $field) {            
            $field->update([
                'venue_id' => $request->venue_id,
                'sports_category_id' => $request->sports_category_id,
                'name' => $request->name,
                'description' => $request->description,
            ]);

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $index => $image) {
                    $imagePath = $image->store('fields', 'public');
                    
                    FieldImage::create([
                        'field_id'   => $field->id,
                        'image_path' => $imagePath,
                        'is_primary' => false,
                        'sort_order' => $field->images()->count() + $index,
                    ]);
                }
            }
        });

        return redirect()->route('fields.index')
            ->with('success', 'Data lapangan dan galeri berhasil diperbarui!');
    }

    /**
     * Display the settings form for Operating Hours & Pricing.
     */
    public function settings(Field $field)
    {
        $field->Load(['operatingHours', 'pricing']);
        return view('admin.fields.settings', compact('field'));
    }

    public function destroy(Field $field)
    {
        $field->load('images');
        foreach ($field->images as $image) {
            if (Storage::disk('public')->exists($image->image_path)) {
                Storage::disk('public')->delete($image->image_path);
            }
        }
        $field->delete();
        return redirect()->route('fields.index')
            ->with('success', 'Lapangan beserta semua fotonya berhasil dihapus!');
    }

    public function setPrimaryImage(FieldImage $image)
    {
        FieldImage::where('field_id', $image->field_id)
            ->update([
                'is_primary' => false
            ]);
        $image->update([
            'is_primary' => true
        ]);
        return back()->with(
            'success',
            'Foto primary berhasil diubah!'
        );
    }

    public function deleteImage(FieldImage $image)
    {
        if (Storage::disk('public')->exists($image->image_path)) {
            Storage::disk('public')->delete($image->image_path);
        }

        $fieldId = $image->field_id;
        $wasPrimary = $image->is_primary;
        $image->delete();

        if ($wasPrimary) {
            $newPrimary = FieldImage::where('field_id', $fieldId)->first();
            if ($newPrimary) {
                $newPrimary->update([
                    'is_primary' => true
                ]);
            }
        }
        return back()->with('success', 'Foto berhasil dihapus!');
    }

    /**
     * Update all field settings: Main Info, Operating Hours, Pricing, and Gallery.
     */
    public function updateSettings(Request $request, Field $field)
    {
        // 1. Validation for all sections
        $request->validate([
            // Section 1: Main Info
            'name'             => 'required|string|max:255',
            'type'             => 'required|in:Indoor,Outdoor,Semi-Indoor',
            'surface_material' => 'required|string|max:255',
            'description'      => 'nullable|string',
            'is_active'        => 'nullable|boolean',

            // Section 2: Operating Hours
            'operating_hours'              => 'required|array|size:7',
            'operating_hours.*.open_time'  => 'required|date_format:H:i',
            'operating_hours.*.close_time' => 'required|date_format:H:i|after:operating_hours.*.open_time',
            
            // Section 3: Pricing
            'pricings'          => 'required|array',
            'pricings.weekday'  => 'required|numeric|min:0',
            'pricings.weekend'  => 'required|numeric|min:0',
            'pricings.holiday'  => 'required|numeric|min:0',

            // Section 4: Images
            'images'   => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,webp|max:5000',
        ]);

        DB::transaction(function () use ($request, $field) {
            
            // Update Section 1: Main Info
            $field->update([
                'name'             => $request->name,
                'slug'             => Str::slug($request->name) . '-' . $field->id, // Simple reactive slug logic
                'type'             => $request->type,
                'surface_material' => $request->surface_material,
                'description'      => $request->description,
                'is_active'        => $request->has('is_active'),
            ]);

            // Update Section 2: Operating Hours
            foreach ($request->operating_hours as $dayOfWeek => $hours) {
                $field->operatingHours()->updateOrCreate(
                    ['day_of_week' => $dayOfWeek],
                    [
                        'open_time'  => $hours['open_time'],
                        'close_time' => $hours['close_time'],
                        'is_open'    => isset($hours['is_open']), 
                    ]
                );
            }

            // Update Section 3: Pricing Scheme
            foreach ($request->pricings as $type => $price) {
                $field->pricing()->updateOrCreate(
                    ['day_type' => $type],
                    ['price_per_slot' => $price]
                );
            }

            // Update Section 4: New Images Upload
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $path = $image->store('fields', 'public');
                    $field->images()->create([
                        'image_path' => $path,
                        'is_primary' => false,
                        'sort_order' => $field->images()->count(),
                    ]);
                }
            }
        });

        return redirect()->route('fields.settings', $field->id)
            ->with('success', 'All field configurations updated successfully!');
    }
}
