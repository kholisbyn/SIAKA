@extends('layouts.admin')

@section('title', 'Detail Karyawan')

@section('content')

<div class="mb-3">
    <h2 class="fw-bold mb-1">
        <i class="fas fa-id-card text-info me-2"></i>
        Detail Karyawan
    </h2>

    <p class="text-muted mb-0">
        Informasi lengkap data karyawan
    </p>
</div>

<div class="d-flex gap-2 mb-4">

    <a
        href="{{ route('karyawan.index') }}"
        class="btn btn-secondary"
    >
        <i class="fas fa-arrow-left me-1"></i>
        Kembali
    </a>

    <a
        href="{{ route('karyawan.edit', $karyawan) }}"
        class="btn btn-warning"
    >
        <i class="fas fa-pen me-1"></i>
        Edit
    </a>

</div>

<div class="card shadow-sm border-0">

    <div class="card-body">

        <div class="row g-4">

            {{-- FOTO KARYAWAN --}}
            <div class="col-md-4">

                <div class="text-center">

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
                            width="220"
                            height="220"
                            class="rounded-circle shadow border"
                            style="object-fit: cover;"
                        >

                    @else

                        <img
                            src="https://ui-avatars.com/api/?name={{ urlencode($karyawan->nama) }}&background=2563EB&color=fff&size=220"
                            alt="Foto {{ $karyawan->nama }}"
                            width="220"
                            height="220"
                            class="rounded-circle shadow border"
                        >

                    @endif

                    <h4 class="fw-bold mt-3 mb-1">
                        {{ $karyawan->nama }}
                    </h4>

                    <p class="text-muted mb-2">
                        {{ $karyawan->dataJabatan->jabatan ?? '-' }}
                    </p>

                    @if($karyawan->status === 'Aktif')

                        <span class="badge bg-success px-3 py-2">
                            Aktif
                        </span>

                    @else

                        <span class="badge bg-danger px-3 py-2">
                            Nonaktif
                        </span>

                    @endif

                </div>

            </div>

            {{-- DATA KARYAWAN --}}
            <div class="col-md-8">

                <div class="table-responsive">

                    <table class="table table-bordered align-middle mb-0">

                        <tbody>

                            <tr>
                                <th width="30%">Nama Lengkap</th>
                                <td>{{ $karyawan->nama }}</td>
                            </tr>

                            <tr>
                                <th>NIK</th>
                                <td>
                                    {{ $karyawan->biodata->nik ?? $karyawan->nik ?? '-' }}
                                </td>
                            </tr>

                            <tr>
                                <th>Tempat Lahir</th>
                                <td>
                                    {{ $karyawan->biodata->tempat_lahir ?? $karyawan->tempat_lahir ?? '-' }}
                                </td>
                            </tr>

                            <tr>
                                <th>Tanggal Lahir</th>
                                <td>

                                    @if($karyawan->biodata?->tanggal_lahir)

                                        {{ $karyawan->biodata->tanggal_lahir->translatedFormat('d F Y') }}

                                    @elseif($karyawan->tanggal_lahir)

                                        {{ \Carbon\Carbon::parse($karyawan->tanggal_lahir)->translatedFormat('d F Y') }}

                                    @else

                                        -

                                    @endif

                                </td>
                            </tr>

                            <tr>
                                <th>Jenis Kelamin</th>
                                <td>
                                    {{ $karyawan->biodata->jenis_kelamin ?? $karyawan->jenis_kelamin ?? '-' }}
                                </td>
                            </tr>

                            <tr>
                                <th>Jabatan</th>
                                <td>
                                    {{ $karyawan->dataJabatan->jabatan ?? '-' }}
                                </td>
                            </tr>

                            <tr>
                                <th>PT / Proyek</th>
                                <td>
                                    {{ $karyawan->dataJabatan->nama_pt ?? '-' }}
                                </td>
                            </tr>

                            <tr>
                                <th>Basic Gaji</th>
                                <td>
                                    Rp {{ number_format($karyawan->basic_gaji ?? 0, 0, ',', '.') }}
                                </td>
                            </tr>

                            <tr>
                                <th>No HP</th>
                                <td>
                                    {{ $karyawan->biodata->no_hp ?? $karyawan->no_hp ?? '-' }}
                                </td>
                            </tr>

                            <tr>
                                <th>Alamat</th>
                                <td>
                                    {{ $karyawan->biodata->alamat ?? $karyawan->alamat ?? '-' }}
                                </td>
                            </tr>

                            <tr>
                                <th>Tanggal Masuk</th>
                                <td>

                                    @if($karyawan->biodata?->tanggal_masuk)

                                        {{ $karyawan->biodata->tanggal_masuk->translatedFormat('d F Y') }}

                                    @else

                                        -

                                    @endif

                                </td>
                            </tr>

                            <tr>
                                <th>Status</th>
                                <td>

                                    @if($karyawan->status === 'Aktif')

                                        <span class="badge bg-success">
                                            Aktif
                                        </span>

                                    @else

                                        <span class="badge bg-danger">
                                            Nonaktif
                                        </span>

                                    @endif

                                </td>
                            </tr>

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection