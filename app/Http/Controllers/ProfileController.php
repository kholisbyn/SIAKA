<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function edit(Request $request): View
    {
        $user = $request->user();

        $karyawan = Karyawan::with('dataJabatan')
            ->where('user_id', $user->id)
            ->first();

        $ktp = DB::table('ktps')
            ->where('karyawan_id', $karyawan?->id)
            ->first();

        return view('profile.edit', [
            'user' => $user,
            'karyawan' => $karyawan,
            'ktp' => $ktp,
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'nik' => ['nullable', 'string', 'max:30'],
            'tempat_lahir' => ['nullable', 'string', 'max:100'],
            'tanggal_lahir' => ['nullable', 'date'],
            'jenis_kelamin' => ['nullable', 'in:Laki-laki,Perempuan'],
            'no_hp' => ['nullable', 'string', 'max:20'],
            'alamat' => ['nullable', 'string'],
            'foto' => ['nullable', 'image', 'mimes:jpg,jpeg,png|max:2048'],
            'nomor_ktp' => ['nullable', 'string', 'max:30'],
            'foto_ktp' => ['nullable', 'image', 'mimes:jpg,jpeg,png|max:4096'],
        ]);

        $karyawan = Karyawan::where('user_id', $user->id)->first();

        if (!$karyawan) {
            $karyawan = Karyawan::create([
                'user_id' => $user->id,
                'nama' => $request->name,
                'status' => 'Aktif',
            ]);
        }

        $namaFoto = $karyawan->foto;

        if ($request->hasFile('foto')) {
            if (
                $namaFoto &&
                file_exists(public_path('uploads/karyawan/' . $namaFoto))
            ) {
                unlink(public_path('uploads/karyawan/' . $namaFoto));
            }

            $namaFoto = time() . '_foto.' . $request->foto->extension();

            $request->foto->move(
                public_path('uploads/karyawan'),
                $namaFoto
            );
        }

        $karyawan->update([
            'nama' => $request->name,
            'nik' => $request->nik,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
            'foto' => $namaFoto,
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        $fotoKtp = DB::table('ktps')
            ->where('karyawan_id', $karyawan->id)
            ->value('foto_ktp');

        if ($request->hasFile('foto_ktp')) {
            if (
                $fotoKtp &&
                file_exists(public_path('uploads/ktp/' . $fotoKtp))
            ) {
                unlink(public_path('uploads/ktp/' . $fotoKtp));
            }

            $fotoKtp = time() . '_ktp.' . $request->foto_ktp->extension();

            $request->foto_ktp->move(
                public_path('uploads/ktp'),
                $fotoKtp
            );
        }

        $ktpData = [
            'nomor_ktp' => $request->nomor_ktp,
            'updated_at' => now(),
        ];

        if ($fotoKtp) {
            $ktpData['foto_ktp'] = $fotoKtp;
        }

        $ktpAda = DB::table('ktps')
            ->where('karyawan_id', $karyawan->id)
            ->exists();

        if ($ktpAda) {
            DB::table('ktps')
                ->where('karyawan_id', $karyawan->id)
                ->update($ktpData);
        } else {
            DB::table('ktps')->insert([
                'karyawan_id' => $karyawan->id,
                'nomor_ktp' => $request->nomor_ktp,
                'foto_ktp' => $fotoKtp,
                'status' => 'Menunggu',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return Redirect::route('profile.edit')
            ->with('status', 'Profil berhasil diperbarui.');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}