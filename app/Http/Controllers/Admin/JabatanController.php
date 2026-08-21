<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jabatan;
use Illuminate\Http\Request;

class JabatanController extends Controller
{
    public function index()
    {
        $jabatans = Jabatan::latest()->paginate(10);

        return view('admin.jabatan.index', compact('jabatans'));
    }

    public function create()
    {
        return view('admin.jabatan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|max:100',
            'jabatan' => 'required|max:100',
            'nama_pt' => 'required|max:150',
        ]);

        Jabatan::create([
            'nama' => $request->nama,
            'jabatan' => $request->jabatan,
            'nama_pt' => $request->nama_pt,
        ]);

        return redirect()
            ->route('jabatan.index')
            ->with('success', 'Data berhasil disimpan');
    }

    public function show(string $id)
    {
        $jabatan = Jabatan::findOrFail($id);

        return view('admin.jabatan.show', compact('jabatan'));
    }

    public function edit(string $id)
    {
        $jabatan = Jabatan::findOrFail($id);

        return view('admin.jabatan.edit', compact('jabatan'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama' => 'required|max:100',
            'jabatan' => 'required|max:100',
            'nama_pt' => 'required|max:150',
        ]);

        $jabatan = Jabatan::findOrFail($id);

        $jabatan->update([
            'nama' => $request->nama,
            'jabatan' => $request->jabatan,
            'nama_pt' => $request->nama_pt,
        ]);

        return redirect()
            ->route('jabatan.index')
            ->with('success', 'Data berhasil diupdate');
    }

    public function destroy(string $id)
    {
        $jabatan = Jabatan::findOrFail($id);

        $jabatan->delete();

        return redirect()
            ->route('jabatan.index')
            ->with('success', 'Data berhasil dihapus');
    }
}