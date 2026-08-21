@extends('layouts.karyawan')

@section('title', 'Profil Saya')

@section('content')

<div class="col-md-4 mb-4">

    <div class="card shadow border-0">
        <div class="card-body text-center">

            @if($karyawan->biodata?->foto)

                @php
                    $foto = $karyawan->biodata->foto;

                    if (str_starts_with($foto, 'karyawan/')) {
                        $fotoUrl = asset('storage/' . $foto);
                    } else {
                        $fotoUrl = asset('storage/karyawan/' . $foto);
                    }
                @endphp

                <img
                    src="{{ $fotoUrl }}"
                    alt="Foto {{ $karyawan->nama }}"
                    class="rounded-circle mb-3 shadow"
                    width="150"
                    height="150"
                    style="object-fit: cover;"
                >

            @else

                <img
                    src="https://ui-avatars.com/api/?name={{ urlencode($karyawan->nama) }}&background=2563EB&color=fff&size=150"
                    alt="Foto {{ $karyawan->nama }}"
                    class="rounded-circle mb-3"
                    width="150"
                    height="150"
                >

            @endif

            <h4 class="fw-bold mb-1">
                {{ $karyawan->nama }}
            </h4>

            <p class="text-muted mb-1">
                {{ $karyawan->dataJabatan->jabatan ?? 'Karyawan' }}
            </p>

            <p class="text-muted mb-3">
                {{ $karyawan->dataJabatan->nama_pt ?? '-' }}
            </p>

            @if($karyawan->status === 'Aktif')

                <span class="badge bg-success px-3 py-2">
                    Aktif
                </span>

            @else

                <span class="badge bg-secondary px-3 py-2">
                    Nonaktif
                </span>

            @endif

        </div>
    </div>

</div>


<div class="col-md-8 mb-4">

    <div class="card shadow border-0">

        <div class="card-header bg-white py-3">

            <h5 class="mb-0 fw-bold">
                <i class="fas fa-user me-2 text-primary"></i>
                Data Pribadi
            </h5>

        </div>

        <div class="card-body">

            @if($karyawan->biodata)

                <div class="row">

                    <div class="col-md-6 mb-3">

                        <label class="text-muted small">
                            Nama Lengkap
                        </label>

                        <div class="fw-semibold fs-6">
                            {{ $karyawan->nama }}
                        </div>

                    </div>


                    <div class="col-md-6 mb-3">

                        <label class="text-muted small">
                            NIK
                        </label>

                        <div class="fw-semibold fs-6">
                            {{ $karyawan->biodata->nik ?? '-' }}
                        </div>

                    </div>


                    <div class="col-md-6 mb-3">

                        <label class="text-muted small">
                            Tempat Lahir
                        </label>

                        <div class="fw-semibold fs-6">
                            {{ $karyawan->biodata->tempat_lahir ?? '-' }}
                        </div>

                    </div>


                    <div class="col-md-6 mb-3">

                        <label class="text-muted small">
                            Tanggal Lahir
                        </label>

                        <div class="fw-semibold fs-6">
                            {{ $karyawan->biodata?->tanggal_lahir?->format('d-m-Y') ?? '-' }}
                        </div>

                    </div>


                    <div class="col-md-6 mb-3">

                        <label class="text-muted small">
                            Jenis Kelamin
                        </label>

                        <div class="fw-semibold fs-6">
                            {{ $karyawan->biodata->jenis_kelamin ?? '-' }}
                        </div>

                    </div>


                    <div class="col-md-6 mb-3">

                        <label class="text-muted small">
                            No. HP
                        </label>

                        <div class="fw-semibold fs-6">
                            {{ $karyawan->biodata->no_hp ?? '-' }}
                        </div>

                    </div>


                    <div class="col-md-6 mb-3">

                        <label class="text-muted small">
                            Tanggal Masuk
                        </label>

                        <div class="fw-semibold fs-6">
                            {{ $karyawan->biodata?->tanggal_masuk?->format('d-m-Y') ?? '-' }}
                        </div>

                    </div>


                    <div class="col-md-6 mb-3">

                        <label class="text-muted small">
                            Jabatan
                        </label>

                        <div class="fw-semibold fs-6">
                            {{ $karyawan->dataJabatan->jabatan ?? '-' }}
                        </div>

                    </div>


                    <div class="col-md-6 mb-3">

                        <label class="text-muted small">
                            PT / Proyek
                        </label>

                        <div class="fw-semibold fs-6">
                            {{ $karyawan->dataJabatan->nama_pt ?? '-' }}
                        </div>

                    </div>


                    <div class="col-12 mb-3">

                        <label class="text-muted small">
                            Alamat
                        </label>

                        <div class="fw-semibold fs-6">
                            {{ $karyawan->biodata->alamat ?? '-' }}
                        </div>

                    </div>

                </div>

            @else

                <div class="alert alert-warning mb-0">

                    <i class="fas fa-info-circle me-2"></i>

                    Data biodata belum tersedia.

                </div>

            @endif

        </div>

    </div>

</div>


<div class="col-12 mb-4">

    <div class="card shadow border-0">

        <div class="card-header bg-white py-3">

            <h5 class="mb-0 fw-bold">
                <i class="fas fa-id-card me-2 text-primary"></i>
                Foto KTP
            </h5>

        </div>

        <div class="card-body text-center">

            @if($ktp && $ktp->foto_ktp)

                <img
                    src="{{ asset('storage/' . $ktp->foto_ktp) }}"
                    alt="Foto KTP"
                    class="img-fluid rounded border shadow-sm"
                    style="max-width: 600px;"
                >

            @else

                <div class="py-4 text-muted">

                    <i class="fas fa-id-card fa-3x mb-3"></i>

                    <p class="mb-0">
                        Foto KTP belum tersedia.
                    </p>

                </div>

            @endif

        </div>

    </div>

</div>

@endsection