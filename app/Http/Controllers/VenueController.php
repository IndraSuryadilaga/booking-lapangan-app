<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venue;
use App\Models\SportsCategory;

class VenueController extends Controller
{
    public function index(Request $request)
    {
        $query = Venue::query()
            ->with([
                'sportsCategories',
                'facilities'
            ]);

        // City filter (exact match)
        if ($request->filled('city')) {
            $query->where('city', $request->input('city'));
        }

        // Category filter via fields -> sports_category_id (ensure venue has at least one field of selected categories)
        $categories = $request->input('category', []);
        if (!empty($categories)) {
            $query->whereHas('fields', function ($q) use ($categories) {
                $q->whereIn('sports_category_id', $categories);
            });
        }

        $venues = $query->paginate(12)->withQueryString();

        // Data for filter UI
        $allCategories = SportsCategory::where('is_active', true)->orderBy('name')->get();
        $cities = Venue::distinct()->pluck('city')->filter()->values();

        return view('venues.index', compact('venues', 'allCategories', 'cities'));
    }

    public function show(Venue $venue)
    {
        // Note: `is_active` column not present in venues table in current schema — skip active check

        // Eager-load nested relations to avoid N+1 queries
        $venue->load([
            'fields.sportsCategory',
            'fields.images',
            'fields.pricing',
            'sportsCategories',
            'facilities',
            'reviews.user',
        ]);

        // Compute per-field primary image URL and weekday price, and build schedules for the court card
        $venue->fields->each(function ($field) {
            // Primary image (use accessor added on FieldImage) - guard null
            $primary = $field->images->first();
            $field->primary_image_url = $primary ? ($primary->url ?? null) : null;

            // Weekday price
            $weekdayPricing = $field->pricing->firstWhere('day_type', 'weekday');
            $weekdayPrice = $weekdayPricing ? (float) $weekdayPricing->price_per_slot : null;
            $field->weekday_price = $weekdayPrice;

            // Build a minimal schedules array consumed by the court card component
            if ($weekdayPrice) {
                $field->schedules = [
                    [
                        'time' => '60 Menit',
                        'status' => 'available',
                        'price' => $weekdayPrice,
                    ],
                ];
            } else {
                $field->schedules = [];
            }
        });

        // Recommendations: other active venues sharing at least one sports category
        $categoryIds = $venue->sportsCategories->pluck('id')->toArray();
        $recommendations = Venue::where('id', '!=', $venue->id)
            ->whereHas('sportsCategories', function ($q) use ($categoryIds) {
                $q->whereIn('id', $categoryIds);
            })
            ->with(['sportsCategories'])
            ->orderByDesc('rating_avg')
            ->limit(6)
            ->get();

        return view(
            'venues.show',
            compact('venue', 'recommendations')
        );
    }
}