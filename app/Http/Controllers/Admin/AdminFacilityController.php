<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Facility;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class AdminFacilityController extends Controller
{
    public function index()
    {
        $facilities = Facility::latest()->paginate(10);

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
            'icon' => 'nullable|string|max:255',
        ]);

        Facility::create([
            'name' => $validated['name'],
            'icon' => $validated['icon'] ?? null,
        ]);

        return redirect()
            ->route('facilities.index')
            ->with('success', 'Fasilitas berhasil ditambahkan.');
    }

    public function edit(Facility $facility)
    {
        return view('admin.facilities.edit', compact('facility'));
    }

    public function update(Request $request, Facility $facility)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:facilities,name,' . $facility->id,
            'icon' => 'nullable|string|max:255',
        ]);

        $facility->update([
            'name' => $validated['name'],
            'icon' => $validated['icon'] ?? $facility->icon,
        ]);

        return redirect()
            ->route('facilities.index')
            ->with('success', 'Data fasilitas berhasil diperbarui.');
    }

    public function destroy(Facility $facility)
    {
        try {
            $facility->delete();

            return redirect()
                ->route('facilities.index')
                ->with('success', 'Fasilitas berhasil dihapus.');

        } catch (QueryException $e) {
            return redirect()
                ->route('facilities.index')
                ->with('error', 'Gagal menghapus! Fasilitas ini mungkin sedang digunakan oleh suatu Venue.');
        }
    }
}
