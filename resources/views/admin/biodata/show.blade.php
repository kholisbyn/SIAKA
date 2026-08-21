@extends('layouts.admin')

@section('title', 'Detail Biodata')

@section('content')

<div class="d-flex gap-2 mb-4">
    <a href="{{ route('admin.biodata.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-1"></i>
        Kembali
    </a>

    <a href="{{ route('admin.biodata.edit', $karyawan) }}" class="btn btn-warning">
        <i class="fas fa-pen me-1"></i>
        Edit
    </a>
</div>

<div class="row g-4">

    <div class="col-lg-4">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body text-center p-4">

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
                        width="150"
                        height="150"
                        class="rounded-circle shadow-sm mb-3"
                        style="object-fit: cover;"
                    >

                @else

                    <img
                        src="https://ui-avatars.com/api/?name={{ urlencode($karyawan->nama) }}&background=2563EB&color=fff&size=150"
                        alt="Foto {{ $karyawan->nama }}"
                        width="150"
                        height="150"
                        class="rounded-circle shadow-sm mb-3"
                    >

                @endif

                <h4 class="fw-bold mb-1">
                    {{ $karyawan->nama }}
                </h4>

                <p class="text-muted mb-3">
                    {{ $karyawan->dataJabatan->jabatan ?? '-' }}
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

    <div class="col-lg-8">
        <div class="card shadow-sm border-0">

            <div class="card-header py-3">
                <h5 class="mb-0 fw-bold">
                    <i class="fas fa-id-card me-2 text-primary"></i>
                    Informasi Biodata
                </h5>
            </div>

            <div class="card-body">

                <div class="row g-4">

                    <div class="col-md-6">
                        <label class="text-muted small">
                            Nama Lengkap
                        </label>

                        <div class="fw-semibold">
                            {{ $karyawan->nama }}
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="text-muted small">
                            NIK
                        </label>

                        <div class="fw-semibold">
                            {{ $karyawan->biodata->nik ?? '-' }}
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="text-muted small">
                            Jabatan
                        </label>

                        <div class="fw-semibold">
                            {{ $karyawan->dataJabatan->jabatan ?? '-' }}
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="text-muted small">
                            Status Karyawan
                        </label>

                        <div class="fw-semibold">
                            {{ $karyawan->status ?? '-' }}
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="text-muted small">
                            Tempat Lahir
                        </label>

                        <div class="fw-semibold">
                            {{ $karyawan->biodata->tempat_lahir ?? '-' }}
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="text-muted small">
                            Tanggal Lahir
                        </label>

                        <div class="fw-semibold">
                            {{ $karyawan->biodata?->tanggal_lahir?->format('d-m-Y') ?? '-' }}
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="text-muted small">
                            Jenis Kelamin
                        </label>

                        <div class="fw-semibold">
                            {{ $karyawan->biodata->jenis_kelamin ?? '-' }}
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="text-muted small">
                            Nomor HP
                        </label>

                        <div class="fw-semibold">
                            {{ $karyawan->biodata->no_hp ?? '-' }}
                        </div>
                    </div>

                    <div class="col-12">
                        <label class="text-muted small">
                            Alamat
                        </label>

                        <div class="fw-semibold">
                            {{ $karyawan->biodata->alamat ?? '-' }}
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="text-muted small">
                            Tanggal Masuk
                        </label>

                        <div class="fw-semibold">
                            {{ $karyawan->biodata?->tanggal_masuk?->format('d-m-Y') ?? '-' }}
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="text-muted small">
                            Status Biodata
                        </label>

                        <div>
                            @if(
                                $karyawan->biodata &&
                                $karyawan->biodata->nik &&
                                $karyawan->biodata->tempat_lahir &&
                                $karyawan->biodata->tanggal_lahir &&
                                $karyawan->biodata->jenis_kelamin &&
                                $karyawan->biodata->no_hp &&
                                $karyawan->biodata->alamat
                            )
                                <span class="badge bg-success">
                                    <i class="fas fa-check me-1"></i>
                                    Lengkap
                                </span>
                            @else
                                <span class="badge bg-warning text-dark">
                                    <i class="fas fa-clock me-1"></i>
                                    Belum Lengkap
                                </span>
                            @endif
                        </div>
                    </div>

                </div>

            </div>

        </div>
    </div>

</div>

@endsection