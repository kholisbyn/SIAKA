@extends('layouts.admin')

@section('title', 'Data Absensi')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>
        <h3 class="fw-bold mb-1">
            Data Absensi
        </h3>

        <p class="text-muted mb-0">
            Kelola data absensi seluruh karyawan
        </p>
    </div>

    <a
        href="{{ route('absensi.create') }}"
        class="btn btn-primary"
    >
        <i class="fas fa-plus me-2"></i>
        Tambah Absensi
    </a>

</div>


{{-- SUCCESS --}}
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


{{-- ERROR --}}
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

    {{-- HEADER --}}
    <div class="card-header bg-white py-3">

        <div class="d-flex justify-content-between align-items-center">

            <h5 class="mb-0 fw-bold">

                <i class="fas fa-calendar-check text-primary me-2"></i>

                Riwayat Absensi

            </h5>

            <span class="badge bg-primary">
                {{ $absensis->total() }} Data
            </span>

        </div>

    </div>


    {{-- TABLE --}}
    <div class="card-body p-0">

        <div class="table-responsive">

            <table class="table table-hover align-middle mb-0">

                <thead class="table-light">

                    <tr>

                        <th class="px-3">
                            No
                        </th>

                        <th>
                            Karyawan
                        </th>

                        <th>
                            Tanggal
                        </th>

                        <th>
                            Masuk
                        </th>

                        <th>
                            Pulang
                        </th>

                        <th>
                            Status
                        </th>

                        <th class="text-center">
                            Aksi
                        </th>

                    </tr>

                </thead>


                <tbody>

                    @forelse($absensis as $absensi)

                        <tr>

                            {{-- NO --}}
                            <td class="px-3">

                                {{ $absensis->firstItem() + $loop->index }}

                            </td>


                            {{-- KARYAWAN --}}
                            <td>

                                <div class="fw-semibold">

                                    {{ $absensi->karyawan->nama ?? '-' }}

                                </div>

                                <small class="text-muted">

                                    NIK:
                                    {{ $absensi->karyawan->nik ?? '-' }}

                                </small>

                            </td>


                            {{-- TANGGAL --}}
                            <td>

                                @if($absensi->tanggal)

                                    {{ \Carbon\Carbon::parse($absensi->tanggal)->format('d-m-Y') }}

                                @else

                                    <span class="text-muted">
                                        -
                                    </span>

                                @endif

                            </td>


                            {{-- JAM MASUK --}}
                            <td>

                                @if($absensi->jam_masuk)

                                    <span class="badge bg-success">

                                        <i class="fas fa-right-to-bracket me-1"></i>

                                        {{ $absensi->jam_masuk }}

                                    </span>

                                @else

                                    <span class="text-muted">
                                        -
                                    </span>

                                @endif

                            </td>


                            {{-- JAM PULANG --}}
                            <td>

                                @if($absensi->jam_pulang)

                                    <span class="badge bg-danger">

                                        <i class="fas fa-right-from-bracket me-1"></i>

                                        {{ $absensi->jam_pulang }}

                                    </span>

                                @else

                                    <span class="badge bg-warning text-dark">
                                        Belum Pulang
                                    </span>

                                @endif

                            </td>


                            {{-- STATUS --}}
                            <td>

                                @if($absensi->jam_masuk && $absensi->jam_pulang)

                                    <span class="badge bg-success">
                                        Selesai
                                    </span>

                                @elseif($absensi->jam_masuk)

                                    <span class="badge bg-warning text-dark">
                                        Sedang Bekerja
                                    </span>

                                @else

                                    <span class="badge bg-secondary">
                                        Belum Absen
                                    </span>

                                @endif

                            </td>


                            {{-- AKSI --}}
                            <td>

                                <div class="d-flex justify-content-center gap-1">

                                    {{-- DETAIL --}}
                                    <a
                                        href="{{ route('absensi.show', $absensi) }}"
                                        class="btn btn-info btn-sm text-white"
                                        title="Detail"
                                    >
                                        <i class="fas fa-eye"></i>
                                    </a>


                                    {{-- EDIT --}}
                                    <a
                                        href="{{ route('absensi.edit', $absensi) }}"
                                        class="btn btn-warning btn-sm"
                                        title="Edit"
                                    >
                                        <i class="fas fa-pen"></i>
                                    </a>


                                    {{-- HAPUS --}}
                                    <form
                                        action="{{ route('absensi.destroy', $absensi) }}"
                                        method="POST"
                                        onsubmit="return confirm('Hapus data absensi ini?')"
                                    >

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="btn btn-danger btn-sm"
                                            title="Hapus"
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
                                colspan="7"
                                class="text-center py-5"
                            >

                                <div class="text-muted">

                                    <i class="fas fa-calendar-xmark fs-1 mb-3"></i>

                                    <h5>
                                        Belum Ada Data Absensi
                                    </h5>

                                    <p class="mb-0">
                                        Data absensi karyawan akan muncul di sini.
                                    </p>

                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>


    {{-- PAGINATION --}}
    @if($absensis->hasPages())

        <div class="card-footer bg-white">

            {{ $absensis->links() }}

        </div>

    @endif

</div>

@endsection