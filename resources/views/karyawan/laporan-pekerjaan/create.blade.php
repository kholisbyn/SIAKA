@extends('layouts.karyawan')

@section('title','Buat Laporan Pekerjaan')

@section('content')

<div class="card shadow border-0">
    <div class="card-header bg-white">
        <h5 class="mb-0">Laporan Pekerjaan</h5>
    </div>

    <div class="card-body">

        <form method="POST" action="{{ route('karyawan.laporan-pekerjaan.store') }}">
            @csrf

            <div class="mb-3">
                <label for="isi_laporan" class="form-label">
                    Isi Laporan Pekerjaan
                </label>

                <textarea
                    name="isi_laporan"
                    id="isi_laporan"
                    class="form-control"
                    rows="8"
                    placeholder="Tuliskan pekerjaan yang dilakukan hari ini..."
                    required>{{ old('isi_laporan') }}</textarea>

                @error('isi_laporan')
                    <div class="text-danger mt-2">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="d-flex gap-2">
                <a href="{{ route('karyawan.laporan-pekerjaan.index') }}" class="btn btn-secondary">
                    Kembali
                </a>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan Laporan
                </button>
            </div>

        </form>

    </div>
</div>

@endsection