<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ktp;
use App\Models\Notifikasi;
use Illuminate\Http\Request;

class KtpController extends Controller
{
    /**
     * Menampilkan semua data KTP
     */
    public function index()
    {
        $ktps = Ktp::with('karyawan.dataJabatan')
            ->latest()
            ->get();

        // Hitung KTP yang masih menunggu verifikasi
        $ktpPending = Ktp::where('status', 'Menunggu')->count();

        return view('admin.ktp.index', compact(
            'ktps',
            'ktpPending'
        ));
    }

    /**
     * Mengubah status KTP
     */
    public function update(Request $request, Ktp $ktp)
    {
        $request->validate([
            'status' => [
                'required',
                'in:Disetujui,Ditolak'
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | AMBIL DATA KARYAWAN
        |--------------------------------------------------------------------------
        */

        $ktp->load('karyawan.user');

        /*
        |--------------------------------------------------------------------------
        | UPDATE STATUS KTP
        |--------------------------------------------------------------------------
        */

        $ktp->update([
            'status' => $request->status,
        ]);

        /*
        |--------------------------------------------------------------------------
        | BUAT NOTIFIKASI UNTUK KARYAWAN
        |--------------------------------------------------------------------------
        */

        if ($ktp->karyawan && $ktp->karyawan->user) {

            if ($request->status === 'Disetujui') {

                $judul = 'KTP Disetujui';

                $pesan = 'Data KTP Anda telah diperiksa dan disetujui oleh Admin.';

            } else {

                $judul = 'KTP Ditolak';

                $pesan = 'Data KTP Anda ditolak oleh Admin. Silakan periksa kembali data dan foto KTP Anda.';
            }

            Notifikasi::create([
                'user_id' => $ktp->karyawan->user->id,
                'judul' => $judul,
                'pesan' => $pesan,
                'dibaca' => false,
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | PESAN UNTUK ADMIN
        |--------------------------------------------------------------------------
        */

        if ($request->status === 'Disetujui') {

            $message = 'KTP karyawan berhasil disetujui dan notifikasi telah dikirim.';

        } else {

            $message = 'KTP karyawan berhasil ditolak dan notifikasi telah dikirim.';
        }

        return back()->with(
            'success',
            $message
        );
    }
}