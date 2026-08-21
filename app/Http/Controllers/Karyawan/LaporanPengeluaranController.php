<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use App\Models\LaporanPengeluaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanPengeluaranController extends Controller
{
    public function index()
    {
        $laporan = LaporanPengeluaran::with('detail')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('karyawan.laporan-pengeluaran.index', compact('laporan'));
    }

    public function create()
    {
        return view('karyawan.laporan-pengeluaran.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'keterangan' => ['nullable', 'string'],
            'barang' => ['required', 'array', 'min:1'],
            'barang.*.nama_barang' => ['required', 'string'],
            'barang.*.nominal' => ['required', 'numeric', 'min:0'],
        ]);

        DB::transaction(function () use ($request) {
            $laporan = LaporanPengeluaran::create([
                'user_id' => auth()->id(),
                'keterangan' => $request->keterangan,
            ]);

            foreach ($request->barang as $barang) {
                $laporan->detail()->create([
                    'nama_barang' => $barang['nama_barang'],
                    'nominal' => $barang['nominal'],
                ]);
            }
        });

        return redirect()
            ->route('karyawan.laporan-pengeluaran.index')
            ->with('success', 'Laporan pengeluaran berhasil disimpan.');
    }
}