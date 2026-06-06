<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SportsCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminSportsCategoryController extends Controller
{
    public function index()
    {
        $categories = SportsCategory::latest()->paginate(10);

        return view('admin.sports-categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.sports-categories.create');
    }

    public function store(Request $request)
    {
        // PERBAIKAN: Tambahkan validasi untuk icon
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:sports_categories,name',
            'icon' => 'nullable|string|max:255',
        ]);

        SportsCategory::create([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'icon' => $validated['icon'] ?? null, // Sekarang icon bisa disave
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()
            ->route('sports-categories.index')
            ->with('success', 'Kategori olahraga berhasil ditambahkan.');
    }

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
        // PERBAIKAN: Memungkinkan admin mengupdate icon
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:sports_categories,name,' . $sports_category->id,
            'icon' => 'nullable|string|max:255',
        ]);

        $sports_category->update([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'icon' => $validated['icon'] ?? $sports_category->icon, // Simpan icon baru atau pertahankan lama
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()
            ->route('sports-categories.index')
            ->with('success', 'Kategori olahraga berhasil diperbarui.');
    }

    public function destroy(SportsCategory $sports_category)
    {
        if ($sports_category->fields()->exists()) {
            return redirect()
                ->route('sports-categories.index')
                ->with('error', 'Kategori tidak dapat dihapus karena masih digunakan oleh lapangan aktif.');
        }

        $sports_category->delete();

        return redirect()
            ->route('sports-categories.index')
            ->with('success', 'Kategori olahraga berhasil dihapus.');
    }
}
