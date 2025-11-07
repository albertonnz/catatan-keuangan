<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * HomeController constructor.
     * Pastikan halaman hanya bisa diakses setelah login.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Tampilkan halaman utama aplikasi catatan keuangan.
     */
    public function home()
    {
        return view('pages.app.home'); // Pastikan path ini benar
    }
}
