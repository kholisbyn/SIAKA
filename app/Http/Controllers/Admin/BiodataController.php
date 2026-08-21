<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Karyawan;
use Illuminate\Http\Request;

class BiodataController extends Controller
{
    public function index()
    {
        $karyawans = Karyawan::with('dataJabatan')
            ->latest()
            ->paginate(10);

        return view('admin.biodata.index', compact('karyawans'));
    }

    public function show(Karyawan $karyawan)
    {
        $karyawan->load('dataJabatan');

        return view('admin.biodata.show', compact('karyawan'));
    }

    public function edit(Karyawan $karyawan)
    {
        $karyawan->load('dataJabatan');

        return view('admin.biodata.edit', compact('karyawan'));
    }

    public function update(Request $request, Karyawan $karyawan)
    {
        $validated = $request->validate([
            'nik' => ['nullable', 'string', 'max:50'],
            'nama' => ['required', 'string', 'max:255'],
            'tempat_lahir' => ['nullable', 'string', 'max:100'],
            'tanggal_lahir' => ['nullable', 'date'],
            'jenis_kelamin' => ['nullable', 'in:Laki-laki,Perempuan'],
            'no_hp' => ['nullable', 'string', 'max:20'],
            'alamat' => ['nullable', 'string'],
            'basic_gaji' => ['nullable', 'numeric'],
            'status' => ['required', 'in:Aktif,Nonaktif'],
        ]);

        $karyawan->update($validated);

        return redirect()
            ->route('admin.biodata.index')
            ->with('success', 'Biodata karyawan berhasil diperbarui.');
    }

    public function destroy(Karyawan $karyawan)
    {
        $karyawan->delete();

        return redirect()
            ->route('admin.biodata.index')
            ->with('success', 'Data karyawan berhasil dihapus.');
    }
}