@extends('layouts.admin')

@section('title', 'Verifikasi KTP')

@section('content')

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        {{ session('success') }}

        <button
            type="button"
            class="btn-close"
            data-bs-dismiss="alert"
        ></button>
    </div>
@endif

<div class="card-body">

    @if($ktps->count() > 0)

        <div class="table-responsive">

            <table class="table table-bordered table-hover align-middle">

                <thead>
                    <tr>
                        <th>No</th>
                        <th>Karyawan</th>
                        <th>NIK</th>
                        <th>Jabatan</th>
                        <th>Nomor KTP</th>
                        <th>Foto KTP</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>

                    @foreach($ktps as $ktp)

                        <tr>

                            <td>
                                {{ $loop->iteration }}
                            </td>

                            <td>
                                {{ $ktp->karyawan->nama ?? '-' }}
                            </td>

                            <td>
                                {{ $ktp->karyawan->biodata?->nik ?? $ktp->karyawan->nik ?? '-' }}
                            </td>

                            <td>
                                {{ $ktp->karyawan->dataJabatan->jabatan ?? '-' }}
                            </td>

                            <td>
                                {{ $ktp->nomor_ktp ?? '-' }}
                            </td>

                            <td>

                                @if($ktp->foto_ktp)

                                    <a
                                        href="{{ asset('storage/' . $ktp->foto_ktp) }}"
                                        target="_blank"
                                    >
                                        <img
                                            src="{{ asset('storage/' . $ktp->foto_ktp) }}"
                                            style="width:120px;height:80px;object-fit:cover;border-radius:8px;"
                                            alt="Foto KTP"
                                        >
                                    </a>

                                @else

                                    <span class="text-muted">
                                        Belum ada
                                    </span>

                                @endif

                            </td>

                            <td>

                                @if($ktp->status === 'Disetujui')

                                    <span class="badge bg-success">
                                        Disetujui
                                    </span>

                                @elseif($ktp->status === 'Ditolak')

                                    <span class="badge bg-danger">
                                        Ditolak
                                    </span>

                                @else

                                    <span class="badge bg-warning text-dark">
                                        Menunggu
                                    </span>

                                @endif

                            </td>

                            <td>

                                <form
                                    action="{{ route('admin.ktp.update', $ktp->id) }}"
                                    method="POST"
                                    class="d-flex gap-2"
                                >

                                    @csrf
                                    @method('PATCH')

                                    <button
                                        type="submit"
                                        name="status"
                                        value="Disetujui"
                                        class="btn btn-success btn-sm"
                                    >
                                        Setujui
                                    </button>

                                    <button
                                        type="submit"
                                        name="status"
                                        value="Ditolak"
                                        class="btn btn-danger btn-sm"
                                    >
                                        Tolak
                                    </button>

                                </form>

                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    @else

        <div class="text-center py-5">

            <i class="fas fa-id-card fa-3x text-muted mb-3"></i>

            <h5>
                Belum ada KTP yang perlu diverifikasi
            </h5>

            <p class="text-muted">
                Data KTP karyawan yang diupload akan muncul di sini.
            </p>

        </div>

    @endif

</div>

@endsection