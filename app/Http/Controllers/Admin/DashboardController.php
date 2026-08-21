<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Karyawan;

class DashboardController extends Controller
{
    public function index()
    {
        $totalKaryawan = Karyawan::count();

        $karyawanAktif = Karyawan::where('status', 'Aktif')->count();

        $karyawanNonaktif = Karyawan::where('status', 'Nonaktif')->count();

        $totalGaji = Karyawan::sum('basic_gaji');

        return view('dashboard', compact(
            'totalKaryawan',
            'karyawanAktif',
            'karyawanNonaktif',
            'totalGaji'
        ));
    }
}