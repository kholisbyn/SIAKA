@extends('layouts.admin')

@section('title', 'Detail Absensi')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-1">Detail Absensi</h2>
        <p class="text-muted mb-0">Informasi lengkap absensi karyawan</p>
    </div>

    <a href="{{ route('absensi.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-2"></i>
        Kembali
    </a>
</div>

<div class="row g-4">

    <div class="col-lg-6">
        <div class="card shadow border-0 h-100">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">
                    <i class="fas fa-user me-2"></i>
                    Data Karyawan
                </h5>
            </div>

            <div class="card-body">

                <div class="mb-3">
                    <small class="text-muted">Nama</small>
                    <h5>{{ $absensi->karyawan->nama ?? '-' }}</h5>
                </div>

                <div class="mb-3">
                    <small class="text-muted">NIK</small>
                    <h5>{{ $absensi->karyawan->nik ?? '-' }}</h5>
                </div>

                <div class="mb-3">
                    <small class="text-muted">Jabatan</small>
                    <h5>{{ $absensi->karyawan->jabatan->nama ?? '-' }}</h5>
                </div>

                <div>
                    <small class="text-muted">Tanggal</small>
                    <h5>
                        {{ $absensi->tanggal ? \Carbon\Carbon::parse($absensi->tanggal)->translatedFormat('d F Y') : '-' }}
                    </h5>
                </div>

            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card shadow border-0 h-100">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">
                    <i class="fas fa-clock me-2"></i>
                    Waktu Absensi
                </h5>
            </div>

            <div class="card-body">

                <div class="mb-4">
                    <small class="text-muted">Jam Masuk</small>
                    <h3 class="text-success">
                        {{ $absensi->jam_masuk ?? '-' }}
                    </h3>
                </div>

                <div>
                    <small class="text-muted">Jam Pulang</small>
                    <h3 class="text-danger">
                        {{ $absensi->jam_pulang ?? '-' }}
                    </h3>
                </div>

            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card shadow border-0">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0">
                    <i class="fas fa-camera me-2"></i>
                    Foto Absen Masuk
                </h5>
            </div>

            <div class="card-body text-center">

                @if($absensi->foto_masuk)
                    <img
                        src="{{ asset('storage/' . $absensi->foto_masuk) }}"
                        class="img-fluid rounded"
                        style="max-height:400px"
                        alt="Foto Absen Masuk"
                    >
                @else
                    <p class="text-muted mb-0">
                        Foto masuk belum tersedia.
                    </p>
                @endif

            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card shadow border-0">
            <div class="card-header bg-danger text-white">
                <h5 class="mb-0">
                    <i class="fas fa-camera me-2"></i>
                    Foto Absen Pulang
                </h5>
            </div>

            <div class="card-body text-center">

                @if($absensi->foto_pulang)
                    <img
                        src="{{ asset('storage/' . $absensi->foto_pulang) }}"
                        class="img-fluid rounded"
                        style="max-height:400px"
                        alt="Foto Absen Pulang"
                    >
                @else
                    <p class="text-muted mb-0">
                        Foto pulang belum tersedia.
                    </p>
                @endif

            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="card shadow border-0">
            <div class="card-header bg-white">
                <h5 class="mb-0">
                    <i class="fas fa-location-dot me-2"></i>
                    Lokasi Absensi
                </h5>
            </div>

            <div class="card-body">

                <div class="row">

                    <div class="col-md-6">
                        <h6>Lokasi Masuk</h6>

                        <p class="text-muted">
                            {{ $absensi->lokasi_masuk ?? '-' }}
                        </p>

                        <p class="mb-0">
                            Latitude:
                            {{ $absensi->latitude_masuk ?? '-' }}
                        </p>

                        <p>
                            Longitude:
                            {{ $absensi->longitude_masuk ?? '-' }}
                        </p>
                    </div>

                    <div class="col-md-6">
                        <h6>Lokasi Pulang</h6>

                        <p class="text-muted">
                            {{ $absensi->lokasi_pulang ?? '-' }}
                        </p>

                        <p class="mb-0">
                            Latitude:
                            {{ $absensi->latitude_pulang ?? '-' }}
                        </p>

                        <p>
                            Longitude:
                            {{ $absensi->longitude_pulang ?? '-' }}
                        </p>
                    </div>

                </div>

            </div>
        </div>
    </div>

</div>

@endsection