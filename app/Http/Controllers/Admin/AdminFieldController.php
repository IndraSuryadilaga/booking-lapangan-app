<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFieldRequest;
use App\Http\Requests\UpdateFieldRequest;
use App\Models\Field;
use App\Models\SportsCategory;
use App\Models\Venue;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminFieldController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $query = Field::with(['venue', 'sportsCategory', 'images']);

        if ($user->isAdmin()) {
            $query->whereHas('venue', fn ($q) => $q->where('admin_id', $user->id));
        }

        $fields = $query->latest()->paginate(10);

        return view('admin.fields.index', compact('fields'));
    }

    public function create()
    {
        $user = auth()->user();
        $categories = SportsCategory::where('is_active', true)->get();

        if ($user->isSuperAdmin()) {
            $venues = Venue::all();
        } else {
            $venues = Venue::where('admin_id', $user->id)->get();
        }

        return view('admin.fields.create', compact('categories', 'venues'));
    }

    public function store(StoreFieldRequest $request)
    {
        DB::transaction(function () use ($request) {
            $field = Field::create($request->safe()->except(['operating_hours', 'pricings', 'images']) + [
                'slug' => Str::slug($request->name) . '-' . uniqid(),
                'is_active' => true,
            ]);

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $index => $image) {
                    $imagePath = $image->store('fields', 'public');
                    $field->images()->create([
                        'image_path' => $imagePath,
                        'is_primary' => $index === 0,
                    ]);
                }
            }

            foreach ($request->operating_hours as $hour) {
                $field->operatingHours()->create($hour);
            }

            foreach ($request->pricings as $pricing) {
                $field->pricings()->create($pricing);
            }
        });

        return redirect()->route('admin.fields.index')->with('success', 'Lapangan berhasil ditambahkan!');
    }

    public function show(Field $field)
    {
        $this->authorize('view', $field);
        $field->load(['venue', 'sportsCategory', 'operatingHours', 'images', 'pricings']);
        return view('admin.fields.show', compact('field'));
    }

    public function edit(Field $field)
    {
        $this->authorize('update', $field);
        $user = auth()->user();
        $categories = SportsCategory::where('is_active', true)->get();

        if ($user->isSuperAdmin()) {
            $venues = Venue::all();
        } else {
            $venues = Venue::where('admin_id', $user->id)->get();
        }

        $field->load('operatingHours', 'images', 'pricings');
        return view('admin.fields.edit', compact('field', 'categories', 'venues'));
    }

    public function update(UpdateFieldRequest $request, Field $field)
    {
        $this->authorize('update', $field);

        DB::transaction(function () use ($request, $field) {
            $field->update($request->safe()->except(['operating_hours', 'pricings']));

            $field->operatingHours()->delete();
            foreach ($request->operating_hours as $hour) {
                $field->operatingHours()->create($hour);
            }

            $field->pricings()->delete();
            foreach ($request->pricings as $pricing) {
                $field->pricings()->create($pricing);
            }
        });

        return redirect()->route('admin.fields.index')->with('success', 'Data lapangan berhasil diperbarui!');
    }

    public function destroy(Field $field)
    {
        $this->authorize('delete', $field);

        foreach ($field->images as $image) {
            Storage::disk('public')->delete($image->image_path);
        }

        $field->delete();

        return redirect()->route('admin.fields.index')->with('success', 'Lapangan berhasil dihapus!');
    }

    public function toggleStatus(Field $field)
    {
        $this->authorize('update', $field);
        $field->update(['is_active' => !$field->is_active]);

        return back()->with('success', 'Status operasional lapangan berhasil diperbarui.');
    }
}
