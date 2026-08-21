<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use App\Models\Karyawan;
use App\Models\Ktp;
use App\Models\Notifikasi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BiodataController extends Controller
{
    public function edit()
    {
        $karyawan = Karyawan::with([
            'biodata',
            'dataJabatan'
        ])
        ->where('user_id', auth()->id())
        ->firstOrFail();

        $ktp = Ktp::where(
            'karyawan_id',
            $karyawan->id
        )->first();

        return view(
            'karyawan.biodata.edit',
            compact(
                'karyawan',
                'ktp'
            )
        );
    }

    public function update(Request $request)
    {
        $karyawan = Karyawan::with('biodata')
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $validated = $request->validate([
            'nik' => [
                'nullable',
                'string',
                'max:50'
            ],

            'nama' => [
                'required',
                'string',
                'max:255'
            ],

            'tempat_lahir' => [
                'nullable',
                'string',
                'max:100'
            ],

            'tanggal_lahir' => [
                'nullable',
                'date'
            ],

            'jenis_kelamin' => [
                'nullable',
                'in:Laki-laki,Perempuan'
            ],

            'no_hp' => [
                'nullable',
                'string',
                'max:20'
            ],

            'alamat' => [
                'nullable',
                'string'
            ],

            'foto' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png',
                'max:2048'
            ],

            'nomor_ktp' => [
                'nullable',
                'string',
                'max:30'
            ],

            'foto_ktp' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png',
                'max:4096'
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | BIODATA
        |--------------------------------------------------------------------------
        */

        $biodata = $karyawan->biodata;

        if (!$biodata) {

            $biodata = $karyawan->biodata()->create([
                'nik' => $validated['nik'] ?? null,
                'tempat_lahir' => $validated['tempat_lahir'] ?? null,
                'tanggal_lahir' => $validated['tanggal_lahir'] ?? null,
                'jenis_kelamin' => $validated['jenis_kelamin'] ?? null,
                'no_hp' => $validated['no_hp'] ?? null,
                'alamat' => $validated['alamat'] ?? null,
            ]);

        } else {

            $biodata->update([
                'nik' => $validated['nik'] ?? null,
                'tempat_lahir' => $validated['tempat_lahir'] ?? null,
                'tanggal_lahir' => $validated['tanggal_lahir'] ?? null,
                'jenis_kelamin' => $validated['jenis_kelamin'] ?? null,
                'no_hp' => $validated['no_hp'] ?? null,
                'alamat' => $validated['alamat'] ?? null,
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | NAMA KARYAWAN
        |--------------------------------------------------------------------------
        */

        $karyawan->nama = $validated['nama'];

        /*
        |--------------------------------------------------------------------------
        | FOTO KARYAWAN
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('foto')) {

            if (
                $biodata->foto &&
                Storage::disk('public')->exists($biodata->foto)
            ) {
                Storage::disk('public')->delete(
                    $biodata->foto
                );
            }

            $biodata->foto = $request
                ->file('foto')
                ->store('karyawan', 'public');

            $biodata->save();
        }

        $karyawan->save();

        /*
        |--------------------------------------------------------------------------
        | KTP
        |--------------------------------------------------------------------------
        */

        if (
            $request->filled('nomor_ktp') ||
            $request->hasFile('foto_ktp')
        ) {

            /*
            |------------------------------------------------------------------
            | CARI KTP MILIK KARYAWAN
            |------------------------------------------------------------------
            */

            $ktp = Ktp::where(
                'karyawan_id',
                $karyawan->id
            )->first();

            /*
            |------------------------------------------------------------------
            | CEK NOMOR KTP DUPLIKAT
            |------------------------------------------------------------------
            */

            if ($request->filled('nomor_ktp')) {

                $nomorSudahDipakai = Ktp::where(
                    'nomor_ktp',
                    $request->nomor_ktp
                )
                ->where(
                    'karyawan_id',
                    '!=',
                    $karyawan->id
                )
                ->exists();

                if ($nomorSudahDipakai) {

                    return back()
                        ->withInput()
                        ->withErrors([
                            'nomor_ktp' =>
                                'Nomor KTP tersebut sudah digunakan oleh karyawan lain.'
                        ]);
                }
            }

            /*
            |------------------------------------------------------------------
            | CEK APAKAH KTP BARU
            |------------------------------------------------------------------
            */

            $ktpBaru = false;

            if (!$ktp) {

                /*
                |--------------------------------------------------------------
                | KTP BARU WAJIB ADA FOTO
                |--------------------------------------------------------------
                */

                if (!$request->hasFile('foto_ktp')) {

                    return back()
                        ->withInput()
                        ->withErrors([
                            'foto_ktp' =>
                                'Foto KTP wajib diupload.'
                        ]);
                }

                $ktp = new Ktp();

                $ktp->karyawan_id = $karyawan->id;

                $ktp->status = 'Menunggu';

                $ktpBaru = true;
            }

            /*
            |------------------------------------------------------------------
            | NOMOR KTP
            |------------------------------------------------------------------
            */

            if ($request->filled('nomor_ktp')) {

                $ktp->nomor_ktp =
                    $request->nomor_ktp;
            }

            /*
            |------------------------------------------------------------------
            | FOTO KTP
            |------------------------------------------------------------------
            */

            $fotoKtpBaru = false;

            if ($request->hasFile('foto_ktp')) {

                if (
                    $ktp->foto_ktp &&
                    Storage::disk('public')->exists(
                        $ktp->foto_ktp
                    )
                ) {

                    Storage::disk('public')->delete(
                        $ktp->foto_ktp
                    );
                }

                $ktp->foto_ktp = $request
                    ->file('foto_ktp')
                    ->store('ktp', 'public');

                /*
                |--------------------------------------------------------------
                | FOTO KTP BARU = MENUNGGU VERIFIKASI
                |--------------------------------------------------------------
                */

                $ktp->status = 'Menunggu';

                $fotoKtpBaru = true;
            }

            $ktp->save();

            /*
            |--------------------------------------------------------------------------
            | NOTIFIKASI UNTUK ADMIN
            |--------------------------------------------------------------------------
            |
            | Notifikasi dibuat jika:
            | - KTP baru dibuat
            | - Foto KTP diganti / diupload ulang
            |
            */

            if ($ktpBaru || $fotoKtpBaru) {

                $admins = User::where(
                    'role',
                    'admin'
                )->get();

                foreach ($admins as $admin) {

                    Notifikasi::create([
                        'user_id' => $admin->id,

                        'judul' =>
                            'KTP Menunggu Verifikasi',

                        'pesan' =>
                            $karyawan->nama .
                            ' telah mengupload KTP baru. Silakan periksa dan verifikasi data KTP tersebut.',

                        'dibaca' => false,
                    ]);
                }
            }
        }

        /*
        |--------------------------------------------------------------------------
        | SELESAI
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('karyawan.biodata.edit')
            ->with(
                'success',
                'Biodata dan KTP berhasil diperbarui.'
            );
    }
}