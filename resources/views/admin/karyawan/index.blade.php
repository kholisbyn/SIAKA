@extends('layouts.admin')

@section('title', 'Data Karyawan')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>
        <h2 class="fw-bold mb-1">
            <i class="fas fa-users text-primary me-2"></i>
            Data Karyawan
        </h2>

        <p class="text-muted mb-0">
            Kelola data seluruh karyawan
        </p>
    </div>

    <a href="{{ route('karyawan.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-1"></i>
        Tambah Karyawan
    </a>

</div>


{{-- PESAN BERHASIL --}}

@if(session('success'))

    <div class="alert alert-success alert-dismissible fade show">

        <i class="fas fa-check-circle me-2"></i>

        {{ session('success') }}

        <button
            type="button"
            class="btn-close"
            data-bs-dismiss="alert">
        </button>

    </div>

@endif


{{-- PESAN ERROR --}}

@if(session('error'))

    <div class="alert alert-danger alert-dismissible fade show">

        <i class="fas fa-circle-exclamation me-2"></i>

        {{ session('error') }}

        <button
            type="button"
            class="btn-close"
            data-bs-dismiss="alert">
        </button>

    </div>

@endif


<div class="card border-0 shadow-sm">

    <div class="card-header bg-white py-3">

        <div class="d-flex justify-content-between align-items-center">

            <h5 class="fw-bold mb-0">

                <i class="fas fa-users text-primary me-2"></i>

                Daftar Karyawan

            </h5>

            <span class="badge bg-primary">
                {{ $karyawans->total() }} Data
            </span>

        </div>

    </div>


    <div class="card-body">

        <div class="table-responsive">

            <table class="table table-bordered table-hover align-middle mb-0">

                <thead class="table-dark text-center">

                    <tr>

                        <th>No</th>
                        <th>Foto</th>
                        <th>Nama</th>
                        <th>NIK</th>
                        <th>Tempat Lahir</th>
                        <th>Tanggal Lahir</th>
                        <th>Jabatan</th>
                        <th>PT / Proyek</th>
                        <th>Basic Gaji</th>
                        <th>No HP</th>
                        <th>Status</th>
                        <th>Aksi</th>

                    </tr>

                </thead>


                <tbody>

                    @forelse($karyawans as $karyawan)

                        @php

                            $biodata = $karyawan->biodata;

                        @endphp


                        <tr>

                            {{-- NO --}}

                            <td class="text-center">

                                {{ $karyawans->firstItem() + $loop->index }}

                            </td>


                            {{-- FOTO --}}

                            <td class="text-center">

                                @if($biodata?->foto)

                                    <img
                                        src="{{ asset('storage/' . $biodata->foto) }}"
                                        width="60"
                                        height="60"
                                        class="rounded-circle border shadow-sm"
                                        style="object-fit: cover;"
                                        alt="Foto {{ $karyawan->nama }}"
                                    >

                                @else

                                    <img
                                        src="https://ui-avatars.com/api/?name={{ urlencode($karyawan->nama) }}&background=2563EB&color=fff&size=60"
                                        width="60"
                                        height="60"
                                        class="rounded-circle border"
                                        alt="Foto {{ $karyawan->nama }}"
                                    >

                                @endif

                            </td>


                            {{-- NAMA --}}

                            <td class="fw-semibold">

                                {{ $karyawan->nama ?? '-' }}

                            </td>


                            {{-- NIK --}}

                            <td>

                                {{ $biodata?->nik ?? $karyawan->nik ?? '-' }}

                            </td>


                            {{-- TEMPAT LAHIR --}}

                            <td>

                                {{ $biodata?->tempat_lahir ?? $karyawan->tempat_lahir ?? '-' }}

                            </td>


                            {{-- TANGGAL LAHIR --}}

                            <td>

                                @if($biodata?->tanggal_lahir)

                                    {{ \Carbon\Carbon::parse($biodata->tanggal_lahir)->format('d-m-Y') }}

                                @elseif($karyawan->tanggal_lahir)

                                    {{ \Carbon\Carbon::parse($karyawan->tanggal_lahir)->format('d-m-Y') }}

                                @else

                                    -

                                @endif

                            </td>


                            {{-- JABATAN --}}

                            <td>

                                {{ $karyawan->dataJabatan->jabatan ?? '-' }}

                            </td>


                            {{-- PT / PROYEK --}}

                            <td>

                                {{ $karyawan->dataJabatan->nama_pt ?? '-' }}

                            </td>


                            {{-- BASIC GAJI --}}

                            <td class="text-end fw-bold text-success">

                                Rp {{ number_format($karyawan->basic_gaji ?? 0, 0, ',', '.') }}

                            </td>


                            {{-- NO HP --}}

                            <td>

                                {{ $biodata?->no_hp ?? $karyawan->no_hp ?? '-' }}

                            </td>


                            {{-- STATUS --}}

                            <td class="text-center">

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


                            {{-- AKSI --}}

                            <td class="text-center">

                                <div class="d-flex justify-content-center gap-1">


                                    {{-- LIHAT --}}

                                    <a
                                        href="{{ route('karyawan.show', $karyawan->id) }}"
                                        class="btn btn-info btn-sm text-white"
                                        title="Lihat Detail"
                                    >

                                        <i class="fas fa-eye"></i>

                                    </a>


                                    {{-- EDIT --}}

                                    <a
                                        href="{{ route('karyawan.edit', $karyawan->id) }}"
                                        class="btn btn-warning btn-sm"
                                        title="Edit Karyawan"
                                    >

                                        <i class="fas fa-pen"></i>

                                    </a>


                                    {{-- HAPUS --}}

                                    <form
                                        action="{{ route('karyawan.destroy', $karyawan->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus data karyawan ini?')"
                                    >

                                        @csrf

                                        @method('DELETE')


                                        <button
                                            type="submit"
                                            class="btn btn-danger btn-sm"
                                            title="Hapus Karyawan"
                                        >

                                            <i class="fas fa-trash"></i>

                                        </button>

                                    </form>


                                </div>

                            </td>

                        </tr>


                    @empty

                        <tr>

                            <td
                                colspan="12"
                                class="text-center text-muted py-5"
                            >

                                <i class="fas fa-folder-open fa-2x mb-2"></i>

                                <br>

                                <strong>
                                    Belum ada data karyawan
                                </strong>

                                <br>

                                <small>
                                    Silakan tambahkan karyawan terlebih dahulu.
                                </small>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- PAGINATION --}}

        @if($karyawans->hasPages())

            <div class="mt-3">

                {{ $karyawans->links() }}

            </div>

        @endif

    </div>

</div>

@endsection