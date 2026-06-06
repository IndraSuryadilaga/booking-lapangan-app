<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venue;
use App\Models\SportsCategory;
use Illuminate\Support\Facades\DB;

class VenueController extends Controller
{
    public function index(Request $request)
    {
        $query = Venue::query()
            ->with([
                'sportsCategories',
                'facilities',
                'fields.pricings'
            ]);

        if ($request->filled('city')) {
            $query->where('city', $request->input('city'));
        }

        $categories = $request->input('category', []);
        if (!empty($categories)) {
            $query->whereHas('fields', function ($q) use ($categories) {
                $q->whereIn('sports_category_id', $categories);
            });
        }

        $venues = $query->paginate(12)->withQueryString();

        $allCategories = SportsCategory::where('is_active', true)->orderBy('name')->get();
        $cities = Venue::distinct()->pluck('city')->filter()->values();

        return view('venues.index', compact('venues', 'allCategories', 'cities'));
    }

    public function show(Venue $venue)
    {
        $venue->load([
            'fields.sportsCategory',
            'fields.images',
            'fields.pricings',
            'fields.operatingHours',
            'sportsCategories',
            'facilities',
            'reviews.user',
        ]);

        $priceStart = $venue->fields
            ->map(fn($field) => $field->cheapest_price)
            ->filter()
            ->min();

        $venue->price_start = $priceStart;

        $venues = Venue::where('id', '!=', $venue->id)
            ->with(['sportsCategories', 'fields.pricings'])
            ->orderByDesc('rating_avg')
            ->limit(6)
            ->get();

        $fullyBookedDates = $this->getFullyBookedDates($venue->id);

        return view(
            'venues.show',
            compact('venue', 'venues', 'fullyBookedDates')
        );
    }

    private function getFullyBookedDates($venueId)
    {
        $slotsPerDayThreshold = 24;

        $bookedDates = \App\Models\Field::where('venue_id', $venueId)
            ->join('booking_slots', 'fields.id', '=', 'booking_slots.field_id')
            ->select('booking_slots.booking_date', DB::raw('COUNT(booking_slots.id) as booked_count'))
            ->groupBy('booking_slots.booking_date')
            ->having('booked_count', '>=', $slotsPerDayThreshold)
            ->pluck('booking_date');

        return $bookedDates->map(function ($date) {

            return \Carbon\Carbon::parse($date)->format('Y-m-d');
        })->toArray();
    }
}
