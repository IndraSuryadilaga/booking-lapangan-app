<?php

namespace App\Http\Controllers;

use App\Models\Field;
use Illuminate\Http\Request;

class FieldController extends Controller
{
    public function show(Field $field)
    {
        if (!$field->is_active) {
            abort(404, 'Lapangan sedang ditutup sementara (Maintenance Mode).');
        }

        $field->load([
            'venue.facilities',
            'venue.sportsCategories',
            'sportsCategory',
            'operatingHours',
            'images',
            'pricings'
        ]);

        return view('field-detail', compact('field'));
    }
}
