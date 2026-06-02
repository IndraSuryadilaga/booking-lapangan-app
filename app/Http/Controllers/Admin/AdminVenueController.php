<?php

namespace App\Http\Controllers\Admin;

use App\Models\Venue;
use App\Models\User;
use App\Models\Facility;
use App\Models\SportsCategory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreVenueRequest;
use App\Http\Controllers\Controller;

class AdminVenueController extends Controller
{
        public function index()
{
    if (auth()->user()->isAdmin()) {
        return redirect()
            ->route('admin.venues.my-venue');
    }

    $venues = Venue::with([
        'admin',
        'sportsCategories',
        'facilities'
    ])
    ->latest()
    ->paginate(10);

    return view(
        'admin.venues.index',
        compact('venues')
    );
}

    public function create()
{
    $facilities = Facility::all();
    $sportsCategories = SportsCategory::all();

    return view(
        'admin.venues.create',
        compact(
            'facilities',
            'sportsCategories'
        )
    );
}

    public function store(StoreVenueRequest $request)
{
    DB::transaction(function () use ($request) {

        $logoPath = null;

        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')
                ->store('venues', 'public');
        }

        $venue = Venue::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name) . '-' . uniqid(),

            'address' => $request->address,
            'city' => $request->city,
            'province' => $request->province,

            'latitude' => $request->latitude,
            'longitude' => $request->longitude,

            'refund_policy' => $request->refund_policy,
            'reschedule_policy' => $request->reschedule_policy,

            'logo' => $logoPath,
        ]);

        $venue->facilities()->sync(
            $request->facility_ids ?? []
        );

        $venue->sportsCategories()->sync(
            $request->sports_category_ids ?? []
        );
    });

    return redirect()
        ->back()
        ->with('success', 'Venue berhasil dibuat.');
}

    public function show(Venue $venue)
    {
        abort_if(
            !$venue->is_active,
            404
        );

        $venue->load([
            'fields',
            'sportsCategories',
            'facilities',
            'reviews.user'
        ]);

        return view(
            'venues.show',
            compact('venue')
        );
    }

    public function edit(Venue $venue)
{
    $this->authorize('update', $venue);

    $facilities = Facility::all();
    $sportsCategories = SportsCategory::all();

    return view(
        'admin.venues.edit',
        compact(
            'venue',
            'facilities',
            'sportsCategories'
        )
    );
}

    public function update(
    StoreVenueRequest $request,
    Venue $venue
)
{
    $this->authorize('update', $venue);

    DB::transaction(function () use (
        $request,
        $venue
    ) {

        $data = [
            'name' => $request->name,

            'address' => $request->address,
            'city' => $request->city,
            'province' => $request->province,

            'latitude' => $request->latitude,
            'longitude' => $request->longitude,

            'refund_policy' => $request->refund_policy,
            'reschedule_policy' => $request->reschedule_policy,
        ];

        if ($request->hasFile('logo')) {

            if ($venue->logo) {
                Storage::disk('public')
                    ->delete($venue->logo);
            }

            $data['logo'] = $request
                ->file('logo')
                ->store('venues', 'public');
        }

        $venue->update($data);

        $venue->facilities()->sync(
            $request->facility_ids ?? []
        );

        $venue->sportsCategories()->sync(
            $request->sports_category_ids ?? []
        );
    });

    return back()->with(
        'success',
        'Venue berhasil diupdate.'
    );
}

    public function destroy(Venue $venue)
{
    $this->authorize('delete', $venue);

    // Prevent deleting a venue that still has bookings for its fields.
    $fieldIds = $venue->fields()->pluck('id');
    $hasBookings = \App\Models\Booking::whereIn('field_id', $fieldIds)->exists();
    if ($hasBookings) {
        return back()->withErrors([
            'venue' => 'Venue cannot be deleted because there are existing bookings for its fields.'
        ]);
    }

    if ($venue->logo) {
        Storage::disk('public')
            ->delete($venue->logo);
    }

    $venue->delete();

    return back()->with(
        'success',
        'Venue berhasil dihapus.'
    );
}

    public function assignAdmin(Venue $venue)
{
    $this->authorize('assignAdmin', $venue);
    $admins = User::query()
        ->where('role', 'admin')
        ->whereDoesntHave('venue')
        ->get();

    return view(
        'admin.venues.assign-admin',
        compact(
            'venue',
            'admins'
        )
    );
}

    public function storeAssignAdmin(
    Request $request,
    Venue $venue
)
{
    $this->authorize('assignAdmin', $venue);
    $request->validate([
    'admin_id' => [
        'required',
        Rule::exists('users', 'id')
            ->where('role', 'admin')
    ]
    ]);

    $admin = User::findOrFail(
    $request->admin_id
    );

    if ($admin->venue) {
        return back()->withErrors([
        'admin_id' =>
            'Admin sudah memiliki venue.'
    ]);
    }

    $venue->update([
        'admin_id' => $request->admin_id
    ]);

    return redirect()
        ->back()
        ->with(
            'success',
            'Admin berhasil di-assign.'
        );
}

    public function myVenue()
{
    $user = auth()->user();
    $venue = $user ? $user->venue : null;

    if (!$venue) {
        abort(404);
    }

    return view(
        'admin.venues.my-venue',
        compact('venue')
    );
}
}