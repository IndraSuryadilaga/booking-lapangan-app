<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Facility;
use Illuminate\Http\Request;

class AdminFacilityController extends Controller
{
    public function index()
    {
        $facilities = Facility::latest()->get();

        return view('admin.facilities.index', compact('facilities'));
    }

    public function create()
    {
        return view('admin.facilities.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:facilities,name',
        ]);

        Facility::create([
            'name' => $validated['name'],
            'icon' => null,
        ]);

        return redirect()
            ->route('facilities.index')
            ->with('success', 'Facility created successfully');
    }

    public function edit(Facility $facility)
    {
        return view('admin.facilities.edit', compact('facility'));
    }

    public function update(Request $request, Facility $facility)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:facilities,name,' . $facility->id,
        ]);

        $facility->update([
            'name' => $validated['name'],
        ]);

        return redirect()
            ->route('facilities.index')
            ->with('success', 'Facility updated successfully');
    }

    public function destroy(Facility $facility)
    {
        $facility->delete();

        return redirect()
            ->route('facilities.index')
            ->with('success', 'Facility deleted successfully');
    }
}