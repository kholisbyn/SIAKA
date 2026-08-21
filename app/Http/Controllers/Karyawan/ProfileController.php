<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use App\Models\Karyawan;
use App\Models\Ktp;

class ProfileController extends Controller
{
    public function edit()
    {
        $karyawan = Karyawan::with('dataJabatan')
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $ktp = Ktp::where('karyawan_id', $karyawan->id)->first();

        return view('karyawan.profile', compact('karyawan', 'ktp'));
    }
}