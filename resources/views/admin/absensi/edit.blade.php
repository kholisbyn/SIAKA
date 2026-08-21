@extends('layouts.admin')

@section('title', 'Edit Absensi')

@section('content')

<a href="{{ route('absensi.index') }}" class="btn btn-secondary">
    <i class="fas fa-arrow-left me-2"></i>
    Kembali
</a>

<div class="card-body">

    <form action="{{ route('absensi.update', $absensi->id) }}" method="POST" enctype="multipart/form-data">

        @csrf
        @method('PUT')

        <div class="row g-3">

            {{-- KARYAWAN --}}
            <div class="col-md-6">
                <label class="form-label">Karyawan</label>

                <select name="karyawan_id" class="form-select" required>

                    <option value="">Pilih Karyawan</option>

                    @foreach($karyawans as $karyawan)

                        <option
                            value="{{ $karyawan->id }}"
                            {{ $absensi->karyawan_id == $karyawan->id ? 'selected' : '' }}
                        >
                            {{ $karyawan->nama }}
                        </option>

                    @endforeach

                </select>
            </div>


            {{-- TANGGAL --}}
            <div class="col-md-6">
                <label class="form-label">Tanggal</label>

                <input
                    type="date"
                    name="tanggal"
                    class="form-control"
                    value="{{ $absensi->tanggal ? \Carbon\Carbon::parse($absensi->tanggal)->format('Y-m-d') : '' }}"
                    required
                >
            </div>


            {{-- JAM MASUK --}}
            <div class="col-md-6">
                <label class="form-label">Jam Masuk</label>

                <input
                    type="time"
                    name="jam_masuk"
                    class="form-control"
                    value="{{ $absensi->jam_masuk }}"
                >
            </div>


            {{-- JAM PULANG --}}
            <div class="col-md-6">
                <label class="form-label">Jam Pulang</label>

                <input
                    type="time"
                    name="jam_pulang"
                    class="form-control"
                    value="{{ $absensi->jam_pulang }}"
                >
            </div>


            {{-- FOTO MASUK --}}
            <div class="col-md-6">
                <label class="form-label">Foto Masuk</label>

                <input
                    type="file"
                    name="foto_masuk"
                    class="form-control"
                    accept="image/*"
                >

                @if($absensi->foto_masuk)

                    <img
                        src="{{ asset('storage/' . $absensi->foto_masuk) }}"
                        class="img-thumbnail mt-2"
                        style="max-height:150px"
                    >

                @endif
            </div>


            {{-- FOTO PULANG --}}
            <div class="col-md-6">
                <label class="form-label">Foto Pulang</label>

                <input
                    type="file"
                    name="foto_pulang"
                    class="form-control"
                    accept="image/*"
                >

                @if($absensi->foto_pulang)

                    <img
                        src="{{ asset('storage/' . $absensi->foto_pulang) }}"
                        class="img-thumbnail mt-2"
                        style="max-height:150px"
                    >

                @endif
            </div>


            {{-- LOKASI MASUK --}}
            <div class="col-md-6">
                <label class="form-label">Lokasi Masuk</label>

                <textarea
                    name="lokasi_masuk"
                    class="form-control"
                    rows="3"
                >{{ $absensi->lokasi_masuk }}</textarea>
            </div>


            {{-- LOKASI PULANG --}}
            <div class="col-md-6">
                <label class="form-label">Lokasi Pulang</label>

                <textarea
                    name="lokasi_pulang"
                    class="form-control"
                    rows="3"
                >{{ $absensi->lokasi_pulang }}</textarea>
            </div>


            {{-- LATITUDE MASUK --}}
            <div class="col-md-6">
                <label class="form-label">Latitude Masuk</label>

                <input
                    type="text"
                    name="latitude_masuk"
                    class="form-control"
                    value="{{ $absensi->latitude_masuk }}"
                >
            </div>


            {{-- LONGITUDE MASUK --}}
            <div class="col-md-6">
                <label class="form-label">Longitude Masuk</label>

                <input
                    type="text"
                    name="longitude_masuk"
                    class="form-control"
                    value="{{ $absensi->longitude_masuk }}"
                >
            </div>


            {{-- LATITUDE PULANG --}}
            <div class="col-md-6">
                <label class="form-label">Latitude Pulang</label>

                <input
                    type="text"
                    name="latitude_pulang"
                    class="form-control"
                    value="{{ $absensi->latitude_pulang }}"
                >
            </div>


            {{-- LONGITUDE PULANG --}}
            <div class="col-md-6">
                <label class="form-label">Longitude Pulang</label>

                <input
                    type="text"
                    name="longitude_pulang"
                    class="form-control"
                    value="{{ $absensi->longitude_pulang }}"
                >
            </div>


            {{-- KETERANGAN --}}
            <div class="col-12">
                <label class="form-label">Keterangan</label>

                <textarea
                    name="keterangan"
                    class="form-control"
                    rows="4"
                >{{ $absensi->keterangan }}</textarea>
            </div>


            {{-- TOMBOL --}}
            <div class="col-12 d-flex justify-content-end gap-2 mt-4">

                <a
                    href="{{ route('absensi.index') }}"
                    class="btn btn-secondary"
                >
                    Batal
                </a>

                <button
                    type="submit"
                    class="btn btn-primary"
                >
                    <i class="fas fa-save me-2"></i>
                    Simpan Perubahan
                </button>

            </div>

        </div>

    </form>

</div>

@endsection