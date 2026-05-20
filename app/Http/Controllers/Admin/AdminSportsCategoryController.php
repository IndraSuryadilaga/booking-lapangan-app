<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SportsCategory;
use Illuminate\Http\Request;

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

  public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
    ]);

    SportsCategory::create([
        'name' => $validated['name'],
        'is_active' => $request->has('is_active'),
    ]);

    return redirect('/admin/sports-categories');
}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    public function edit(SportsCategory $sports_category)
{
    return view('admin.sports-categories.edit', [
        'category' => $sports_category
    ]);
}

public function update(Request $request, SportsCategory $sports_category)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
    ]);

    $sports_category->update([
        'name' => $validated['name'],
        'is_active' => $request->has('is_active'),
    ]);

    return redirect()
        ->route('sports-categories.index')
        ->with('success', 'Category updated successfully');
}

public function destroy(SportsCategory $sports_category)
{
    $sports_category->delete();

    return redirect()
        ->route('sports-categories.index')
        ->with('success', 'Category deleted successfully');
}
}