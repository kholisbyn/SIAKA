@extends('layouts.admin')

@section('title', 'Laporan Pekerjaan')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>
        <h2 class="fw-bold mb-1">
            <i class="fas fa-briefcase text-primary me-2"></i>
            Laporan Pekerjaan
        </h2>

        <p class="text-muted mb-0">
            Daftar laporan pekerjaan karyawan
        </p>
    </div>

    <a
        href="{{ route('admin.rekap.index') }}"
        class="btn btn-secondary"
    >
        <i class="fas fa-arrow-left me-2"></i>
        Kembali
    </a>

</div>

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

<div class="card border-0 shadow-sm">

    <div class="card-header bg-primary text-white">

        <h5 class="mb-0">
            <i class="fas fa-file-lines me-2"></i>
            Data Laporan Pekerjaan
        </h5>

    </div>

    <div class="card-body p-0">

        <div class="table-responsive">

            <table class="table table-hover align-middle mb-0">

                <thead class="table-light">

                    <tr>
                        <th class="px-3">No</th>
                        <th>Nama Karyawan</th>
                        <th>PT / Proyek</th>
                        <th>Laporan Pekerjaan</th>
                        <th>Tanggal</th>
                        <th class="text-center">Aksi</th>
                    </tr>

                </thead>

                <tbody>

                    @forelse($laporan as $item)

                        <tr>

                            <td class="px-3">
                                {{ $loop->iteration }}
                            </td>

                            <td>

                                <strong>
                                    {{ $item->user->name ?? '-' }}
                                </strong>

                            </td>

                            <td>
                                {{ $item->user->karyawan->dataJabatan->nama_pt ?? '-' }}
                            </td>

                            <td>

                                <div style="max-width:450px;">
                                    {{ $item->isi_laporan }}
                                </div>

                            </td>

                            <td>

                                {{ $item->created_at
                                    ? $item->created_at->format('d-m-Y H:i')
                                    : '-' }}

                            </td>

                            <td class="text-center">

                                <form
                                    action="{{ route('admin.laporan.pekerjaan.delete', $item) }}"
                                    method="POST"
                                    onsubmit="return confirm('Yakin ingin menghapus laporan pekerjaan ini?')"
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

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="6"
                                class="text-center py-5 text-muted"
                            >

                                <i class="fas fa-folder-open fa-3x mb-3"></i>

                                <h5>
                                    Belum Ada Laporan Pekerjaan
                                </h5>

                                <p class="mb-0">
                                    Laporan pekerjaan karyawan akan muncul di sini.
                                </p>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection