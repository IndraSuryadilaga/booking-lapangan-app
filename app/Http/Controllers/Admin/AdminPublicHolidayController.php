<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PublicHoliday;
use Illuminate\Http\Request;

class AdminPublicHolidayController extends Controller
{
    public function index()
    {
        $holidays = PublicHoliday::latest()->paginate(15);

        return view('admin.holidays.index', compact('holidays'));
    }

    public function create()
    {
        return view('admin.holidays.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'holiday_date' => 'required|date|unique:public_holidays,holiday_date',
        ]);

        PublicHoliday::create($validated);

        return redirect()
            ->route('holidays.index')
            ->with('success', 'Hari libur berhasil ditambahkan.');
    }

    public function edit(PublicHoliday $holiday)
    {
        return view('admin.holidays.edit', compact('holiday'));
    }

    public function update(Request $request, PublicHoliday $holiday)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'holiday_date' => [
                'required',
                'date',
                \Illuminate\Validation\Rule::unique('public_holidays', 'holiday_date')->ignore($holiday->id),
            ],
        ]);

        $holiday->update($validated);

        return redirect()
            ->route('holidays.index')
            ->with('success', 'Hari libur berhasil diperbarui.');
    }

    public function destroy(PublicHoliday $holiday)
    {
        $holiday->delete();

        return redirect()
            ->route('holidays.index')
            ->with('success', 'Hari libur berhasil dihapus.');
    }
}
