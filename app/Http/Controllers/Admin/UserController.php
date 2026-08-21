<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jabatan;
use App\Models\Karyawan;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('karyawan.dataJabatan')
            ->latest()
            ->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'jabatan' => ['required', 'string', 'max:255'],
            'status' => ['required', 'in:Aktif,Nonaktif'],
            'username' => ['required', 'string', 'max:255', 'unique:users,username'],
            'password' => ['required', 'string', 'min:6'],
            'role' => ['required', 'in:admin,admin_lapangan,karyawan'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->username . '@siaka.local',
            'password' => $request->password,
            'role' => $request->role,
        ]);

        $jabatan = Jabatan::create([
            'nama' => $request->name,
            'jabatan' => $request->jabatan,
            'nama_pt' => '',
        ]);

        Karyawan::create([
            'user_id' => $user->id,
            'jabatan_id' => $jabatan->id,
            'nama' => $request->name,
            'status' => $request->status,
        ]);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Akun berhasil dibuat.');
    }

    public function edit(User $user)
    {
        $user->load('karyawan.dataJabatan');

        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'jabatan' => ['required', 'string', 'max:255'],
            'status' => ['required', 'in:Aktif,Nonaktif'],
            'username' => [
                'required',
                'string',
                'max:255',
                'unique:users,username,' . $user->id
            ],
            'password' => ['nullable', 'string', 'min:6'],
            'role' => ['required', 'in:admin,admin_lapangan,karyawan'],
        ]);

        $user->name = $request->name;
        $user->username = $request->username;
        $user->role = $request->role;

        if ($request->filled('password')) {
            $user->password = $request->password;
        }

        $user->save();

        $karyawan = $user->karyawan;

        if (!$karyawan) {
            $jabatan = Jabatan::create([
                'nama' => $request->name,
                'jabatan' => $request->jabatan,
                'nama_pt' => '',
            ]);

            Karyawan::create([
                'user_id' => $user->id,
                'jabatan_id' => $jabatan->id,
                'nama' => $request->name,
                'status' => $request->status,
            ]);
        } else {
            $karyawan->nama = $request->name;
            $karyawan->status = $request->status;
            $karyawan->save();

            if ($karyawan->dataJabatan) {
                $karyawan->dataJabatan->update([
                    'nama' => $request->name,
                    'jabatan' => $request->jabatan,
                ]);
            }
        }

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Akun berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with(
                'error',
                'Akun yang sedang digunakan tidak dapat dihapus.'
            );
        }

        if ($user->karyawan) {
            if ($user->karyawan->dataJabatan) {
                $user->karyawan->dataJabatan->delete();
            }

            $user->karyawan->delete();
        }

        $user->delete();

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Akun berhasil dihapus.');
    }
}