<?php

namespace App\Http\Controllers\Admin;

use App\Models\Field;
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
        $fields = Field::with('sportsCategory')->latest()->get();
        
        return view('admin.fields.index', compact('fields'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = SportsCategory::where('is_active', true)->get();
        
        return view('admin.fields.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'sports_category_id' => 'required|exists:sports_categories,id',
            'name'               => 'required|string|max:255',
            'description'        => 'nullable|string',
            'price_per_slot'     => 'required|numeric|min:0', 
            'photo'              => 'nullable|image|mimes:jpeg,png,jpg|max:10000',
            'operating_hours'    => 'required|array|size:7', 
        ]);

        DB::transaction(function () use ($request) {
            
            $photoPath = null;
            if ($request->hasFile('photo')) {
                $photoPath = $request->file('photo')->store('fields', 'public');
            }

            $field = Field::create([
                'sports_category_id' => $request->sports_category_id,
                'name'               => $request->name,
                'slug'               => Str::slug($request->name) . '-' . uniqid(),
                'description'        => $request->description,
                'price_per_slot'     => $request->price_per_slot,
                'photo'              => $photoPath,
                'is_active'          => true,
            ]);

            foreach ($request->operating_hours as $dayOfWeek => $hours) {
                $field->operatingHours()->create([
                    'day_of_week' => $dayOfWeek,
                    'open_time'   => $hours['open_time'] ?? '08:00',
                    'close_time'  => $hours['close_time'] ?? '22:00',
                    'is_open'     => isset($hours['is_open']),
                ]);
            }
        });

        return redirect()->route('fields.index')
            ->with('success', 'Lapangan dan 7 hari jam operasional berhasil disimpan bersamaan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Field $field)
    {
        $field->load(['sportsCategory', 'operatingHours']);
        
        return view('admin.fields.show', compact('field'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Field $field)
    {
        $categories = SportsCategory::where('is_active', true)->get();
        
        $field->load('operatingHours');

        return view('admin.fields.edit', compact('field', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Field $field)
    {
        $request->validate([
            'sports_category_id' => 'required|exists:sports_categories,id',
            'name'               => 'required|string|max:255',
            'description'        => 'nullable|string',
            'price_per_slot'     => 'required|numeric|min:0', 
            'photo'              => 'nullable|image|mimes:jpeg,png,jpg|max:10000',
            'operating_hours'    => 'required|array|size:7',
        ]);

        DB::transaction(function () use ($request, $field) {
            
            $photoPath = $field->photo;
            
            if ($request->hasFile('photo')) {
                // Hapus foto lama dari storage jika ada
                if ($photoPath && Storage::disk('public')->exists($photoPath)) {
                    Storage::disk('public')->delete($photoPath);
                }
                $photoPath = $request->file('photo')->store('fields', 'public');
            }

            // Update Data Lapangan
            $field->update([
                'sports_category_id' => $request->sports_category_id,
                'name'               => $request->name,
                'slug'               => Str::slug($request->name) . '-' . uniqid(),
                'description'        => $request->description,
                'price_per_slot'     => $request->price_per_slot,
                'photo'              => $photoPath,
            ]);

            foreach ($request->operating_hours as $dayOfWeek => $hours) {
                $field->operatingHours()->updateOrCreate(
                    ['day_of_week' => $dayOfWeek], // Cari berdasarkan hari
                    [
                        'open_time'   => $hours['open_time'] ?? '08:00',
                        'close_time'  => $hours['close_time'] ?? '22:00',
                        'is_open'     => isset($hours['is_open']),
                    ]
                );
            }
        });

        return redirect()->route('fields.index')
            ->with('success', 'Data Lapangan dan jam operasional berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Field $field)
    {
        // Hapus foto fisik dari storage
        if ($field->photo && Storage::disk('public')->exists($field->photo)) {
            Storage::disk('public')->delete($field->photo);
        }
        
        $field->delete();

        return redirect()->route('fields.index')
            ->with('success', 'Lapangan beserta fotonya berhasil dihapus secara permanen!');
    }
}
