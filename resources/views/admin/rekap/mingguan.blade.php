@extends('layouts.admin')

@section('title', 'Rekap Absensi Mingguan')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>
        <h2 class="fw-bold mb-1">
            <i class="fas fa-calendar-week text-warning me-2"></i>
            Rekap Absensi Mingguan
        </h2>

        <p class="text-muted mb-0">
            Rekap absensi karyawan berdasarkan minggu dan PT / Proyek
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

    <div class="card-header bg-warning text-dark">

        <h5 class="mb-0">
            <i class="fas fa-filter me-2"></i>
            Filter Rekap
        </h5>

    </div>

    <div class="card-body">

        <form
            action="{{ route('admin.rekap.mingguan') }}"
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
                        Pilih Tanggal
                    </label>

                    <input
                        type="date"
                        name="tanggal"
                        class="form-control"
                        value="{{ $tanggal->format('Y-m-d') }}"
                        required
                    >

                    <small class="text-muted">
                        Sistem otomatis mengambil Senin sampai Minggu.
                    </small>

                </div>


                <div class="col-md-3 d-flex align-items-end">

                    <button
                        type="submit"
                        class="btn btn-warning me-2"
                    >
                        <i class="fas fa-search me-2"></i>
                        Tampilkan
                    </button>

                    <a
                        href="{{ route('admin.rekap.mingguan') }}"
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
                href="{{ route('admin.rekap.export.excel', array_merge(request()->query(), ['jenis' => 'mingguan'])) }}"
                class="btn btn-success"
            >
                <i class="fas fa-file-excel me-2"></i>
                Export Excel
            </a>


            <a
                href="{{ route('admin.rekap.export.pdf', array_merge(request()->query(), ['jenis' => 'mingguan'])) }}"
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

                    <i class="fas fa-calendar-check text-warning me-2"></i>
                    Data Absensi Mingguan

                </h5>

                <small class="text-muted">

                    Periode:

                    <strong>
                        {{ $tanggalMulai->format('d-m-Y') }}
                    </strong>

                    sampai

                    <strong>
                        {{ $tanggalAkhir->format('d-m-Y') }}
                    </strong>

                    @if(request('pt_proyek'))

                        |
                        PT / Proyek:

                        <strong>
                            {{ request('pt_proyek') }}
                        </strong>

                    @endif

                </small>

            </div>


            <span class="badge bg-warning text-dark">
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
                                    Tidak ada absensi pada periode dan PT / Proyek yang dipilih.
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
        'Rekap Absensi Mingguan SIAKA\n' +
        'Periode: {{ $tanggalMulai->format("d-m-Y") }} s/d {{ $tanggalAkhir->format("d-m-Y") }}\n' +
        url;

    if (navigator.share) {

        navigator.share({
            title: 'Rekap Absensi Mingguan',
            text: text,
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