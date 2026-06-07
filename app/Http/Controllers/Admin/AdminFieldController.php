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
            $venueIds = Venue::where('admin_id', $user->id)->pluck('id');
            $query->whereIn('venue_id', $venueIds);
        }

        $fields = $query->latest()->paginate(10);

        return view('admin.fields.index', compact('fields'));
    }

    public function create()
    {
        $user = auth()->user();
        $categories = SportsCategory::where('is_active', true)->get();

        $venues = $user->isSuperAdmin()
            ? Venue::all()
            : Venue::where('admin_id', $user->id)->get();

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

            $field->operatingHours()->createMany($request->operating_hours);
            $field->pricings()->createMany($request->pricings);

            $field->venue?->syncSportCategoriesFromFields();
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

        $venues = $user->isSuperAdmin()
            ? Venue::all()
            : Venue::where('admin_id', $user->id)->get();

        $field->load('operatingHours', 'images', 'pricings');
        return view('admin.fields.edit', compact('field', 'categories', 'venues'));
    }

    public function update(UpdateFieldRequest $request, Field $field)
    {
        $this->authorize('update', $field);

        DB::transaction(function () use ($request, $field) {
            $previousVenueId = $field->venue_id;

            $field->update($request->safe()->except(['operating_hours', 'pricings']));

            if ($request->has('operating_hours')) {
                foreach ($request->operating_hours as $hour) {
                    $field->operatingHours()->updateOrCreate(
                        ['day_of_week' => $hour['day_of_week']],
                        $hour // Update datanya
                    );
                }
            }

            if ($request->has('pricings')) {
                foreach ($request->pricings as $pricing) {
                    $field->pricings()->updateOrCreate(
                        ['day_type' => $pricing['day_type']],
                        $pricing
                    );
                }
            }

            $field->venue?->syncSportCategoriesFromFields();

            if ($previousVenueId !== $field->venue_id) {
                Venue::find($previousVenueId)?->syncSportCategoriesFromFields();
            }
        });

        return redirect()->route('admin.fields.index')->with('success', 'Data lapangan berhasil diperbarui!');
    }

    public function destroy(Field $field)
    {
        $this->authorize('delete', $field);

        DB::transaction(function () use ($field) {
            $venue = $field->venue;

            foreach ($field->images as $image) {
                if (!str_starts_with($image->image_path, 'http')) {
                    Storage::disk('public')->delete($image->image_path);
                }
            }

            $field->delete();

            $venue?->syncSportCategoriesFromFields();
        });

        return redirect()->route('admin.fields.index')->with('success', 'Lapangan berhasil dihapus!');
    }

    public function toggleStatus(Field $field)
    {
        $this->authorize('update', $field);
        $field->update(['is_active' => !$field->is_active]);

        return back()->with('success', 'Status operasional lapangan berhasil diperbarui.');
    }
}
