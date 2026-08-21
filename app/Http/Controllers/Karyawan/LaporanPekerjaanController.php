<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use App\Models\LaporanPekerjaan;
use Illuminate\Http\Request;

class LaporanPekerjaanController extends Controller
{
    public function index()
    {
        $laporan = LaporanPekerjaan::where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('karyawan.laporan-pekerjaan.index', compact('laporan'));
    }

    public function create()
    {
        return view('karyawan.laporan-pekerjaan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'isi_laporan' => ['required', 'string'],
        ]);

        LaporanPekerjaan::create([
            'user_id' => auth()->id(),
            'isi_laporan' => $request->isi_laporan,
        ]);

        return redirect()
            ->route('karyawan.laporan-pekerjaan.index')
            ->with('success', 'Laporan pekerjaan berhasil disimpan.');
    }
}