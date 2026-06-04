<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venue;
use App\Models\Field;
use App\Models\Booking;
use App\Models\User;
use App\Models\SportsCategory;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Show the public homepage.
     * View `pages.home`.
     */
    public function index()
    {
        // Popular venues: top 6 by rating, only active venues
        $popularVenues = Venue::query()
            ->with(['sportsCategories', 'fields.pricings', 'facilities'])
            ->orderByDesc('rating_avg')
            ->limit(6)
            ->get();

        // Data for quick-search filters
        $allCategories = SportsCategory::where('is_active', true)->orderBy('name')->get();
        $cities = Venue::distinct()->pluck('city')->filter()->values();

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
            'totalVenues',
            'totalFields',
            'totalUsers',
            'totalCities',
            'totalBookings',
            'fieldsPerCategory'
        ));
    }
}
