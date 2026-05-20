<?php

namespace App\Http\Controllers;

use App\Models\Field;
use App\Models\FieldOperatingHour;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminFieldController extends Controller
{
    /**
     * Menampilkan daftar lapangan di panel admin.
     */
    public function index()
    {
        $fields = Field::latest()->get();
        return view('admin.fields.index', compact('fields'));
    }

    /**
    * Menampilkan form untuk membuat lapangan baru.
    */
    public function create()
    {
        return view('admin.fields.create');
    }

    /**
     * Menyimpan data lapangan baru beserta jam operasionalnya.
     */
    public function store(Request $request)
    {
        // 1. Validasi Input (Memastikan harga tidak bernilai negatif sesuai kriteria Jira)
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string',
            'location' => 'nullable|string',
            'price_per_slot' => 'required|integer|min:0', // Validasi min:0 mencegah harga negatif
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Batas upload foto max 2MB
            'operating_hours' => 'required|array', // Harus mengirimkan data hari
        ]);

        // 2. Menggunakan DB::transaction() agar proses aman secara atomik
        DB::transaction(function () use ($request) {
            
            $imagePath = null;
            if ($request->hasFile('image')) {
                // Foto akan disimpan otomatis ke folder storage/app/public/fields
                $imagePath = $request->file('image')->store('fields', 'public');
            }

            // Simpan data ke tabel fields
            $field = Field::create([
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'category' => $request->category,
                'location' => $request->location,
                'price_per_slot' => $request->price_per_slot,
                'description' => $request->description,
                'image' => $imagePath,
                'is_active' => $request->has('is_active'),
            ]);

            // Simpan data jam operasional dinamis (Senin - Minggu) ke tabel terkait
            foreach ($request->operating_hours as $day => $hours) {
                FieldOperatingHour::create([
                    'field_id' => $field->id,
                    'day_of_week' => $day,
                    'open_time' => isset($hours['is_closed']) ? null : $hours['open_time'],
                    'close_time' => isset($hours['is_closed']) ? null : $hours['close_time'],
                    'is_closed' => isset($hours['is_closed']) ? true : false,
                ]);
            }
        });

        return redirect()->route('admin.fields.index')->with('success', 'Lapangan dan jam operasional berhasil disimpan!');
    }
}