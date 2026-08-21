<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AbsensiController extends Controller
{
    public function index()
    {
        $absensis = Absensi::with('karyawan')
            ->latest('tanggal')
            ->latest('jam_masuk')
            ->paginate(10);

        return view('admin.absensi.index', compact('absensis'));
    }

    public function create()
    {
        $karyawans = Karyawan::orderBy('nama')->get();

        return view('admin.absensi.create', compact('karyawans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'karyawan_id' => ['required', 'exists:karyawans,id'],
            'tanggal' => ['required', 'date'],
            'jam_masuk' => ['nullable', 'date_format:H:i'],
            'jam_pulang' => ['nullable', 'date_format:H:i'],
            'foto_masuk' => ['nullable', 'image', 'max:5120'],
            'foto_pulang' => ['nullable', 'image', 'max:5120'],
            'lokasi_masuk' => ['nullable', 'string'],
            'lokasi_pulang' => ['nullable', 'string'],
            'latitude_masuk' => ['nullable', 'numeric'],
            'longitude_masuk' => ['nullable', 'numeric'],
            'latitude_pulang' => ['nullable', 'numeric'],
            'longitude_pulang' => ['nullable', 'numeric'],
            'keterangan' => ['nullable', 'string'],
        ]);

        $data = $request->except([
            'foto_masuk',
            'foto_pulang',
        ]);

        if ($request->hasFile('foto_masuk')) {
            $data['foto_masuk'] = $request->file('foto_masuk')
                ->store('absensi/masuk', 'public');
        }

        if ($request->hasFile('foto_pulang')) {
            $data['foto_pulang'] = $request->file('foto_pulang')
                ->store('absensi/pulang', 'public');
        }

        Absensi::create($data);

        return redirect()
            ->route('absensi.index')
            ->with('success', 'Data absensi berhasil ditambahkan.');
    }

    public function show(Absensi $absensi)
    {
        $absensi->load('karyawan');

        return view('admin.absensi.show', compact('absensi'));
    }

    public function edit(Absensi $absensi)
    {
        $karyawans = Karyawan::orderBy('nama')->get();

        return view('admin.absensi.edit', compact('absensi', 'karyawans'));
    }

    public function update(Request $request, Absensi $absensi)
    {
        $request->validate([
            'karyawan_id' => ['required', 'exists:karyawans,id'],
            'tanggal' => ['required', 'date'],
            'jam_masuk' => ['nullable', 'date_format:H:i'],
            'jam_pulang' => ['nullable', 'date_format:H:i'],
            'foto_masuk' => ['nullable', 'image', 'max:5120'],
            'foto_pulang' => ['nullable', 'image', 'max:5120'],
            'lokasi_masuk' => ['nullable', 'string'],
            'lokasi_pulang' => ['nullable', 'string'],
            'latitude_masuk' => ['nullable', 'numeric'],
            'longitude_masuk' => ['nullable', 'numeric'],
            'latitude_pulang' => ['nullable', 'numeric'],
            'longitude_pulang' => ['nullable', 'numeric'],
            'keterangan' => ['nullable', 'string'],
        ]);

        $data = $request->except([
            'foto_masuk',
            'foto_pulang',
        ]);

        if ($request->hasFile('foto_masuk')) {
            if ($absensi->foto_masuk) {
                Storage::disk('public')->delete($absensi->foto_masuk);
            }

            $data['foto_masuk'] = $request->file('foto_masuk')
                ->store('absensi/masuk', 'public');
        }

        if ($request->hasFile('foto_pulang')) {
            if ($absensi->foto_pulang) {
                Storage::disk('public')->delete($absensi->foto_pulang);
            }

            $data['foto_pulang'] = $request->file('foto_pulang')
                ->store('absensi/pulang', 'public');
        }

        $absensi->update($data);

        return redirect()
            ->route('absensi.index')
            ->with('success', 'Data absensi berhasil diperbarui.');
    }

    public function masuk()
    {
        $karyawan = Karyawan::where('user_id', Auth::id())
            ->firstOrFail();

        $absensi = Absensi::where('karyawan_id', $karyawan->id)
            ->whereDate('tanggal', today())
            ->first();

        if ($absensi && $absensi->jam_masuk) {
            return redirect()
                ->route('karyawan.dashboard')
                ->with('error', 'Anda sudah melakukan absen masuk hari ini.');
        }

        return view('karyawan.absensi.masuk', compact('karyawan'));
    }

    public function simpanMasuk(Request $request)
    {
        $request->validate([
            'foto' => ['required', 'string'],
            'latitude' => ['required', 'numeric'],
            'longitude' => ['required', 'numeric'],
        ]);

        $karyawan = Karyawan::where('user_id', Auth::id())
            ->firstOrFail();

        $tanggal = now()->toDateString();

        $absensi = Absensi::firstOrNew([
            'karyawan_id' => $karyawan->id,
            'tanggal' => $tanggal,
        ]);

        if ($absensi->jam_masuk) {
            return redirect()
                ->route('karyawan.dashboard')
                ->with('error', 'Anda sudah melakukan absen masuk hari ini.');
        }

        $fotoData = $request->foto;

        if (!preg_match('/^data:image\/(\w+);base64,/', $fotoData, $matches)) {
            return back()->with('error', 'Format foto tidak valid.');
        }

        $fotoData = substr($fotoData, strpos($fotoData, ',') + 1);
        $fotoData = base64_decode($fotoData);

        if ($fotoData === false) {
            return back()->with('error', 'Foto gagal diproses.');
        }

        $extension = strtolower($matches[1]);

        if ($extension === 'jpeg') {
            $extension = 'jpg';
        }

        $namaFoto = 'absensi/masuk/' .
            $karyawan->id . '_' .
            now()->format('Ymd_His') .
            '.' . $extension;

        Storage::disk('public')->put($namaFoto, $fotoData);

        $absensi->jam_masuk = now()->format('H:i:s');
        $absensi->foto_masuk = $namaFoto;
        $absensi->latitude_masuk = $request->latitude;
        $absensi->longitude_masuk = $request->longitude;
        $absensi->lokasi_masuk = $request->latitude . ', ' . $request->longitude;
        $absensi->save();

        return redirect()
            ->route('karyawan.dashboard')
            ->with('success', 'Absen masuk berhasil.');
    }

    public function pulang()
    {
        $karyawan = Karyawan::where('user_id', Auth::id())
            ->firstOrFail();

        $absensi = Absensi::where('karyawan_id', $karyawan->id)
            ->whereDate('tanggal', today())
            ->first();

        if (!$absensi || !$absensi->jam_masuk) {
            return redirect()
                ->route('karyawan.dashboard')
                ->with('error', 'Anda belum melakukan absen masuk hari ini.');
        }

        if ($absensi->jam_pulang) {
            return redirect()
                ->route('karyawan.dashboard')
                ->with('error', 'Anda sudah melakukan absen pulang hari ini.');
        }

        return view('karyawan.absensi.pulang', compact('karyawan', 'absensi'));
    }

    public function simpanPulang(Request $request)
    {
        $request->validate([
            'foto' => ['required', 'string'],
            'latitude' => ['required', 'numeric'],
            'longitude' => ['required', 'numeric'],
        ]);

        $karyawan = Karyawan::where('user_id', Auth::id())
            ->firstOrFail();

        $absensi = Absensi::where('karyawan_id', $karyawan->id)
            ->whereDate('tanggal', today())
            ->firstOrFail();

        if ($absensi->jam_pulang) {
            return redirect()
                ->route('karyawan.dashboard')
                ->with('error', 'Anda sudah melakukan absen pulang hari ini.');
        }

        $fotoData = $request->foto;

        if (!preg_match('/^data:image\/(\w+);base64,/', $fotoData, $matches)) {
            return back()->with('error', 'Format foto tidak valid.');
        }

        $fotoData = substr($fotoData, strpos($fotoData, ',') + 1);
        $fotoData = base64_decode($fotoData);

        if ($fotoData === false) {
            return back()->with('error', 'Foto gagal diproses.');
        }

        $extension = strtolower($matches[1]);

        if ($extension === 'jpeg') {
            $extension = 'jpg';
        }

        $namaFoto = 'absensi/pulang/' .
            $karyawan->id . '_' .
            now()->format('Ymd_His') .
            '.' . $extension;

        Storage::disk('public')->put($namaFoto, $fotoData);

        $absensi->jam_pulang = now()->format('H:i:s');
        $absensi->foto_pulang = $namaFoto;
        $absensi->latitude_pulang = $request->latitude;
        $absensi->longitude_pulang = $request->longitude;
        $absensi->lokasi_pulang = $request->latitude . ', ' . $request->longitude;
        $absensi->save();

        return redirect()
            ->route('karyawan.dashboard')
            ->with('success', 'Absen pulang berhasil.');
    }

    public function destroy(Absensi $absensi)
    {
        if ($absensi->foto_masuk) {
            Storage::disk('public')->delete($absensi->foto_masuk);
        }

        if ($absensi->foto_pulang) {
            Storage::disk('public')->delete($absensi->foto_pulang);
        }

        $absensi->delete();

        return redirect()
            ->route('absensi.index')
            ->with('success', 'Data absensi berhasil dihapus.');
    }
}