@extends('layouts.admin')

@section('title', 'Rekap Absensi Harian')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>
        <h2 class="fw-bold mb-1">
            <i class="fas fa-calendar-day text-primary me-2"></i>
            Rekap Absensi Harian
        </h2>

        <p class="text-muted mb-0">
            Rekap absensi karyawan berdasarkan tanggal dan PT / Proyek
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


{{-- FILTER --}}

<div class="card border-0 shadow-sm mb-4">

    <div class="card-header bg-primary text-white">

        <h5 class="mb-0">
            <i class="fas fa-filter me-2"></i>
            Filter Rekap
        </h5>

    </div>

    <div class="card-body">

        <form
            action="{{ route('admin.rekap.harian') }}"
            method="GET"
        >

            <div class="row g-3">

                <div class="col-md-5">

                    <label class="form-label fw-semibold">
                        PT / Proyek
                    </label>

                    <select
                        name="pt_proyek"
                        class="form-select"
                    >

                        <option value="">
                            Semua PT / Proyek
                        </option>

                        @foreach($ptProyeks as $item)

                            <option
                                value="{{ $item }}"
                                {{ request('pt_proyek') == $item ? 'selected' : '' }}
                            >
                                {{ $item }}
                            </option>

                        @endforeach

                    </select>

                </div>


                <div class="col-md-4">

                    <label class="form-label fw-semibold">
                        Tanggal
                    </label>

                    <input
                        type="date"
                        name="tanggal"
                        class="form-control"
                        value="{{ $tanggal }}"
                        required
                    >

                </div>


                <div class="col-md-3 d-flex align-items-end">

                    <button
                        type="submit"
                        class="btn btn-primary me-2"
                    >
                        <i class="fas fa-search me-2"></i>
                        Tampilkan
                    </button>

                    <a
                        href="{{ route('admin.rekap.harian') }}"
                        class="btn btn-secondary"
                    >
                        <i class="fas fa-rotate-left"></i>
                    </a>

                </div>

            </div>

        </form>

    </div>

</div>


{{-- EXPORT --}}

<div class="card border-0 shadow-sm mb-4">

    <div class="card-body">

        <div class="d-flex flex-wrap gap-2">

            <a
                href="{{ route('admin.rekap.export.excel', array_merge(request()->query(), ['jenis' => 'harian'])) }}"
                class="btn btn-success"
            >
                <i class="fas fa-file-excel me-2"></i>
                Export Excel
            </a>


            <a
                href="{{ route('admin.rekap.export.pdf', array_merge(request()->query(), ['jenis' => 'harian'])) }}"
                class="btn btn-danger"
            >
                <i class="fas fa-file-pdf me-2"></i>
                Export PDF
            </a>


            <button
                type="button"
                class="btn btn-info text-white"
                onclick="bagikanRekap()"
            >
                <i class="fas fa-share-nodes me-2"></i>
                Bagikan
            </button>

        </div>

    </div>

</div>


{{-- DATA --}}

<div class="card border-0 shadow-sm">

    <div class="card-header bg-white py-3">

        <div class="d-flex justify-content-between align-items-center">

            <div>

                <h5 class="fw-bold mb-1">

                    <i class="fas fa-calendar-check text-primary me-2"></i>
                    Data Absensi Harian

                </h5>

                <small class="text-muted">

                    Tanggal:
                    <strong>
                        {{ \Carbon\Carbon::parse($tanggal)->format('d-m-Y') }}
                    </strong>

                    @if(request('pt_proyek'))

                        | PT / Proyek:
                        <strong>
                            {{ request('pt_proyek') }}
                        </strong>

                    @endif

                </small>

            </div>


            <span class="badge bg-primary">
                {{ $absensis->count() }} Data
            </span>

        </div>

    </div>


    <div class="card-body p-0">

        <div class="table-responsive">

            <table class="table table-hover align-middle mb-0">

                <thead class="table-light">

                    <tr>

                        <th class="px-3">
                            No
                        </th>

                        <th>
                            Nama Karyawan
                        </th>

                        <th>
                            PT / Proyek
                        </th>

                        <th>
                            Tanggal
                        </th>

                        <th>
                            Jam Masuk
                        </th>

                        <th>
                            Jam Pulang
                        </th>

                        <th>
                            Status
                        </th>

                    </tr>

                </thead>


                <tbody>

                    @forelse($absensis as $absensi)

                        <tr>

                            <td class="px-3">
                                {{ $loop->iteration }}
                            </td>


                            <td>

                                <strong>
                                    {{ $absensi->karyawan->nama ?? '-' }}
                                </strong>

                                @if($absensi->karyawan->nik ?? null)

                                    <br>

                                    <small class="text-muted">
                                        NIK:
                                        {{ $absensi->karyawan->nik }}
                                    </small>

                                @endif

                            </td>


                            <td>

                                {{ $absensi->karyawan->dataJabatan->nama_pt ?? '-' }}

                            </td>


                            <td>

                                {{ \Carbon\Carbon::parse($absensi->tanggal)->format('d-m-Y') }}

                            </td>


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


                            <td>

                                @if(
                                    $absensi->jam_masuk &&
                                    $absensi->jam_pulang
                                )

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

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="7"
                                class="text-center py-5"
                            >

                                <i class="fas fa-calendar-xmark fa-3x text-muted mb-3"></i>

                                <h5 class="text-muted">
                                    Tidak Ada Data Absensi
                                </h5>

                                <p class="text-muted mb-0">
                                    Tidak ada absensi pada tanggal dan PT / Proyek yang dipilih.
                                </p>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>


<script>

function bagikanRekap()
{
    const url = window.location.href;

    const text =
        'Rekap Absensi Harian SIAKA\n' +
        url;

    if (navigator.share) {

        navigator.share({
            title: 'Rekap Absensi Harian',
            text: 'Rekap Absensi Harian SIAKA',
            url: url
        });

    } else {

        const whatsapp =
            'https://wa.me/?text=' +
            encodeURIComponent(text);

        window.open(
            whatsapp,
            '_blank'
        );

    }
}

</script>

@endsection