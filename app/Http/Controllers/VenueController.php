<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VenueController extends Controller
{
    public function index()
    {
        $venues = Venue::query()
            ->where('is_active', true)
            ->with([
                'sportsCategories',
                'facilities'
            ])
            ->paginate(12);

        return view(
            'venues.index',
            compact('venues')
        );
    }

    public function show(Venue $venue)
    {
        abort_if(!$venue->is_active, 404);

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
}