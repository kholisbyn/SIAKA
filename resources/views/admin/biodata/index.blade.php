@extends('layouts.admin')

@section('title', 'Biodata Karyawan')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>
        <h2 class="fw-bold mb-1">
            Biodata Karyawan
        </h2>

        <p class="text-muted mb-0">
            Data biodata lengkap seluruh karyawan
        </p>
    </div>

</div>


{{-- PESAN SUCCESS --}}

@if(session('success'))

    <div class="alert alert-success alert-dismissible fade show">

        <i class="fas fa-check-circle me-2"></i>

        {{ session('success') }}

        <button
            type="button"
            class="btn-close"
            data-bs-dismiss="alert"
        ></button>

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
            data-bs-dismiss="alert"
        ></button>

    </div>

@endif


<div class="card border-0 shadow-sm">

    <div class="card-body">

        <div class="table-responsive">

            <table class="table table-hover align-middle mb-0">

                <thead class="table-light">

                    <tr>

                        <th width="60">No</th>

                        <th>Foto</th>

                        <th>Nama</th>

                        <th>Jabatan</th>

                        <th>NIK</th>

                        <th>No. HP</th>

                        <th>Status</th>

                        <th width="170">Aksi</th>

                    </tr>

                </thead>


                <tbody>

                    @forelse($karyawans as $karyawan)

                        @php
                            $biodata = $karyawan->biodata;
                        @endphp


                        <tr>

                            {{-- NO --}}

                            <td>

                                {{ $karyawans->firstItem() + $loop->index }}

                            </td>


                            {{-- FOTO --}}

                            <td>

                                @if($biodata?->foto)

                                    <img
                                        src="{{ asset('storage/' . $biodata->foto) }}"
                                        alt="Foto {{ $karyawan->nama }}"
                                        width="55"
                                        height="55"
                                        class="rounded-circle border shadow-sm"
                                        style="object-fit: cover;"
                                    >

                                @else

                                    <img
                                        src="https://ui-avatars.com/api/?name={{ urlencode($karyawan->nama) }}&background=2563EB&color=fff&size=55"
                                        alt="Foto {{ $karyawan->nama }}"
                                        width="55"
                                        height="55"
                                        class="rounded-circle border"
                                    >

                                @endif

                            </td>


                            {{-- NAMA --}}

                            <td>

                                <strong>
                                    {{ $karyawan->nama ?? '-' }}
                                </strong>

                            </td>


                            {{-- JABATAN --}}

                            <td>

                                {{ $karyawan->dataJabatan->jabatan ?? '-' }}

                            </td>


                            {{-- NIK --}}

                            <td>

                                {{ $biodata?->nik ?? $karyawan->nik ?? '-' }}

                            </td>


                            {{-- NO HP --}}

                            <td>

                                {{ $biodata?->no_hp ?? $karyawan->no_hp ?? '-' }}

                            </td>


                            {{-- STATUS BIODATA --}}

                            <td>

                                @if(
                                    $biodata &&
                                    $biodata->nik &&
                                    $biodata->tempat_lahir &&
                                    $biodata->tanggal_lahir &&
                                    $biodata->jenis_kelamin &&
                                    $biodata->no_hp &&
                                    $biodata->alamat
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

                            </td>


                            {{-- AKSI --}}

                            <td>

                                <div class="d-flex gap-1">


                                    {{-- LIHAT --}}

                                    <a
                                        href="{{ route('admin.biodata.show', $karyawan) }}"
                                        class="btn btn-sm btn-info text-white"
                                        title="Lihat Biodata"
                                    >

                                        <i class="fas fa-eye"></i>

                                    </a>


                                    {{-- EDIT --}}

                                    <a
                                        href="{{ route('admin.biodata.edit', $karyawan) }}"
                                        class="btn btn-sm btn-warning"
                                        title="Edit Biodata"
                                    >

                                        <i class="fas fa-pen"></i>

                                    </a>


                                    {{-- HAPUS --}}

                                    @if($biodata)

                                        <form
                                            action="{{ route('admin.biodata.destroy', $karyawan) }}"
                                            method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus biodata {{ $karyawan->nama }}?')"
                                        >

                                            @csrf

                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="btn btn-sm btn-danger"
                                                title="Hapus Biodata"
                                            >

                                                <i class="fas fa-trash"></i>

                                            </button>

                                        </form>

                                    @endif


                                </div>

                            </td>

                        </tr>


                    @empty

                        <tr>

                            <td
                                colspan="8"
                                class="text-center py-5"
                            >

                                <div class="text-muted">

                                    <i class="fas fa-users fa-3x mb-3"></i>

                                    <h5>
                                        Belum ada karyawan
                                    </h5>

                                    <p class="mb-0">
                                        Data karyawan akan muncul di sini.
                                    </p>

                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- PAGINATION --}}

        @if($karyawans->hasPages())

            <div class="mt-4">

                {{ $karyawans->links() }}

            </div>

        @endif

    </div>

</div>

@endsection