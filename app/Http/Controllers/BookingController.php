<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class BookingController extends Controller
{
    /**
     * Form pemesanan — hanya untuk pengguna yang sudah login.
     */
    public function create(): View
    {
        return view('booking.create');
    }
}
