<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venue;
use App\Models\Field;
use App\Models\Booking;
use App\Models\User;
use App\Models\SportsCategory;
use App\Services\VenueFilterService;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Show the public homepage.
     * View `pages.home`.
     */
    public function index(VenueFilterService $filterService)
    {
        // Popular venues: top 6 by rating, only active venues
        $popularVenues = Venue::query()
            ->with(['fieldSportCategories', 'fields.pricings', 'facilities'])
            ->orderByDesc('rating_avg')
            ->limit(6)
            ->get();

        // Data for quick-search filters — withCount ensures fields_count is available in the view
        $allCategories = SportsCategory::where('is_active', true)->withCount('fields')->orderBy('name')->get();
        $cities = $filterService->getCities();
        $categoryOptions = $filterService->getCategoryOptions($allCategories);
        $cityOptions = $filterService->getCityOptions($cities);

        // Statistics
        $totalVenues = Venue::count();
        $totalFields = Field::count();
        $totalUsers = User::count();
        $totalCities = $cities->count();
        $totalBookings = Booking::count();

        // Fields per category
        $fieldsPerCategory = SportsCategory::where('is_active', true)
            ->withCount('fields')
            ->orderBy('name')
            ->get()
            ->map(function ($c) {
                return ['name' => $c->name, 'count' => $c->fields_count];
            });

        return view('pages.home', compact(
            'popularVenues',
            'allCategories',
            'cities',
            'categoryOptions',
            'cityOptions',
            'totalVenues',
            'totalFields',
            'totalUsers',
            'totalCities',
            'totalBookings',
            'fieldsPerCategory'
        ));
    }
}
