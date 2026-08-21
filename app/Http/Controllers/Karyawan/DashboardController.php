<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Karyawan;
use App\Models\Notifikasi;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | DATA KARYAWAN
        |--------------------------------------------------------------------------
        */

        $karyawan = Karyawan::where(
            'user_id',
            Auth::id()
        )->firstOrFail();


        /*
        |--------------------------------------------------------------------------
        | ABSENSI HARI INI
        |--------------------------------------------------------------------------
        */

        $absensi = Absensi::where(
            'karyawan_id',
            $karyawan->id
        )
        ->whereDate(
            'tanggal',
            today()
        )
        ->first();


        /*
        |--------------------------------------------------------------------------
        | NOTIFIKASI KARYAWAN
        |--------------------------------------------------------------------------
        */

        $notifikasis = Notifikasi::where(
            'user_id',
            Auth::id()
        )
        ->latest()
        ->get();


        /*
        |--------------------------------------------------------------------------
        | JUMLAH NOTIFIKASI BELUM DIBACA
        |--------------------------------------------------------------------------
        */

        $notifikasiBelumDibaca = Notifikasi::where(
            'user_id',
            Auth::id()
        )
        ->where(
            'dibaca',
            false
        )
        ->count();


        /*
        |--------------------------------------------------------------------------
        | TAMPILKAN DASHBOARD
        |--------------------------------------------------------------------------
        */

        return view(
            'karyawan.dashboard',
            compact(
                'karyawan',
                'absensi',
                'notifikasis',
                'notifikasiBelumDibaca'
            )
        );
    }
}