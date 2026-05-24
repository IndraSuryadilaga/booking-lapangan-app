<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SportsCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminSportsCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = SportsCategory::latest()->get();

        return view('admin.sports-categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.sports-categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:sports_categories,name',
        ]);

        SportsCategory::create([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'icon' => null,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()
            ->route('sports-categories.index')
            ->with('success', 'Category created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SportsCategory $sports_category)
    {
        return view('admin.sports-categories.edit', [
            'category' => $sports_category
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SportsCategory $sports_category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:sports_categories,name,' . $sports_category->id,
        ]);

        $sports_category->update([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()
            ->route('sports-categories.index')
            ->with('success', 'Category updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SportsCategory $sports_category)
    {
        $sports_category->delete();

        return redirect()
            ->route('sports-categories.index')
            ->with('success', 'Category deleted successfully');
    }
}