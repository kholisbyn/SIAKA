<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jabatan;
use App\Models\Karyawan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class KaryawanController extends Controller
{
    public function index()
    {
        $karyawans = Karyawan::with('dataJabatan')
            ->latest()
            ->paginate(10);

        return view('admin.karyawan.index', compact('karyawans'));
    }


    public function create()
    {
        $jabatans = Jabatan::orderBy('jabatan')->get();

        return view('admin.karyawan.create', compact('jabatans'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'nama' => ['required', 'string', 'max:255'],

            'jabatan_id' => [
                'required',
                'exists:jabatans,id'
            ],

            'status' => [
                'required',
                'in:Aktif,Nonaktif'
            ],

            'username' => [
                'required',
                'string',
                'max:255',
                'unique:users,username'
            ],

            'password' => [
                'required',
                'string',
                'min:6'
            ],

            'role' => [
                'required',
                'in:admin,admin_lapangan,karyawan'
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | BUAT USER
        |--------------------------------------------------------------------------
        */

        $user = User::create([
            'name' => $request->nama,
            'username' => $request->username,
            'email' => $request->username . '@siaka.local',
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);


        /*
        |--------------------------------------------------------------------------
        | BUAT KARYAWAN
        |--------------------------------------------------------------------------
        */

        Karyawan::create([
            'user_id' => $user->id,
            'jabatan_id' => $request->jabatan_id,
            'nama' => $request->nama,
            'status' => $request->status,
        ]);


        return redirect()
            ->route('karyawan.index')
            ->with('success', 'User berhasil ditambahkan.');
    }


    public function show(string $id)
    {
        $karyawan = Karyawan::with([
            'biodata',
            'dataJabatan'
        ])->findOrFail($id);

        return view(
            'admin.karyawan.show',
            compact('karyawan')
        );
    }


    public function edit(string $id)
    {
        $karyawan = Karyawan::with([
            'biodata',
            'dataJabatan'
        ])->findOrFail($id);

        $jabatans = Jabatan::orderBy('jabatan')->get();

        return view(
            'admin.karyawan.edit',
            compact('karyawan', 'jabatans')
        );
    }


    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama' => [
                'required',
                'string',
                'max:255'
            ],

            'jabatan_id' => [
                'required',
                'exists:jabatans,id'
            ],

            'status' => [
                'required',
                'in:Aktif,Nonaktif'
            ],

            'basic_gaji' => [
                'nullable',
                'numeric'
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
        ]);


        $karyawan = Karyawan::with([
            'biodata',
            'user',
            'dataJabatan'
        ])->findOrFail($id);


        /*
        |--------------------------------------------------------------------------
        | UPDATE DATA KARYAWAN
        |--------------------------------------------------------------------------
        */

        $karyawan->nama = $request->nama;
        $karyawan->jabatan_id = $request->jabatan_id;
        $karyawan->status = $request->status;

        if ($request->has('basic_gaji')) {
            $karyawan->basic_gaji = $request->basic_gaji;
        }

        if ($request->has('no_hp')) {
            $karyawan->no_hp = $request->no_hp;
        }

        if ($request->has('alamat')) {
            $karyawan->alamat = $request->alamat;
        }

        $karyawan->save();


        /*
        |--------------------------------------------------------------------------
        | UPDATE USER
        |--------------------------------------------------------------------------
        */

        if ($karyawan->user) {

            $karyawan->user->name = $request->nama;

            $karyawan->user->save();
        }


        /*
        |--------------------------------------------------------------------------
        | UPDATE BIODATA
        |--------------------------------------------------------------------------
        */

        if ($karyawan->biodata) {

            $karyawan->biodata->update([
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'jenis_kelamin' => $request->jenis_kelamin,
                'no_hp' => $request->no_hp,
                'alamat' => $request->alamat,
            ]);
        }


        return redirect()
            ->route('karyawan.index')
            ->with('success', 'Data karyawan berhasil diupdate.');
    }


    public function destroy(string $id)
    {
        $karyawan = Karyawan::with([
            'user',
            'dataJabatan'
        ])->findOrFail($id);


        if ($karyawan->user) {
            $karyawan->user->delete();
        }


        $karyawan->delete();


        return redirect()
            ->route('karyawan.index')
            ->with('success', 'User berhasil dihapus.');
    }
}