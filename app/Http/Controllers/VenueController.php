<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venue;
use App\Services\VenueFilterService;
use Illuminate\Support\Facades\DB;

class VenueController extends Controller
{
    public function index(Request $request, VenueFilterService $filterService)
    {
        $venues = $filterService->filterVenues($request);
        $allCategories = $filterService->getActiveCategories();
        $cities = $filterService->getCities();
        $categoryOptions = $filterService->getCategoryOptions($allCategories, 'Pilih Kategori');
        $cityOptions = $filterService->getCityOptions($cities, 'Pilih Kota');
        $filters = $filterService->parseFilters($request);
        $selectedCategory = $filterService->getSelectedCategory($filters);

        return view('venues.index', compact(
            'venues',
            'allCategories',
            'cities',
            'categoryOptions',
            'cityOptions',
            'filters',
            'selectedCategory',
        ));
    }

    public function show(Venue $venue)
    {
        $venue->load([
            'fields.sportsCategory',
            'fields.images',
            'fields.pricings',
            'fields.operatingHours',
            'fieldSportCategories',
            'facilities',
            'reviews.user',
        ]);

        $priceStart = $venue->fields
            ->map(fn($field) => $field->cheapest_price)
            ->filter()
            ->min();

        $venue->price_start = $priceStart;

        $venues = Venue::where('id', '!=', $venue->id)
            ->with(['fieldSportCategories', 'fields.pricings'])
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
