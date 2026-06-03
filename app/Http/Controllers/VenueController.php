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
                'facilities',
                'fields.pricing'
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
            'fields.pricing',
            'sportsCategories',
            'facilities',
            'reviews.user',
        ]);

        $venue->fields->each(function ($field) {
            $primary = $field->images->first();
            $field->primary_image_url = $primary ? ($primary->url ?? null) : null;

            $weekdayPricing = $field->pricing->firstWhere('day_type', 'weekday');
            $weekdayPrice = $weekdayPricing ? (float) $weekdayPricing->price_per_slot : null;
            $field->weekday_price = $weekdayPrice;

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

        $venues = Venue::where('id', '!=', $venue->id)
            ->with(['sportsCategories', 'fields.pricing'])
            ->orderByDesc('rating_avg')
            ->limit(6)
            ->get();

        return view(
            'venues.show',
            compact('venue', 'venues')
        );
    }
}
