<?php

namespace App\Http\Controllers;

use App\Models\Field;
use Illuminate\Http\Request;

class FieldController extends Controller
{
    public function show(Field $field)
    {
        $field->load([
            'venue.facilities',
            'venue.sportsCategories',
            'sportsCategory',
            'operatingHours',
            'images',
            'pricings'
        ]);

        return view('venues.field-detail', compact('field'));
    }
}
