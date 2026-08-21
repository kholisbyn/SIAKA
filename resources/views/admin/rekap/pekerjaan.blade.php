@extends('layouts.admin')

@section('title', 'Rekap Laporan Pekerjaan')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>
        <h2 class="fw-bold mb-1">
            <i class="fas fa-briefcase text-primary me-2"></i>
            Rekap Laporan Pekerjaan
        </h2>

        <p class="text-muted mb-0">
            Rekap laporan pekerjaan karyawan berdasarkan PT / Proyek
        </p>
    </div>

    <a href="{{ route('admin.rekap.index') }}" class="btn btn-secondary">
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

        <form action="{{ route('admin.rekap.pekerjaan') }}" method="GET">

            <div class="row g-3">

                <div class="col-md-8">

                    <label class="form-label fw-semibold">
                        PT / Proyek
                    </label>

                    <select name="pt_proyek" class="form-select">

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

                <div class="col-md-4 d-flex align-items-end">

                    <button type="submit" class="btn btn-primary me-2">

                        <i class="fas fa-search me-2"></i>
                        Tampilkan

                    </button>

                    <a
                        href="{{ route('admin.rekap.pekerjaan') }}"
                        class="btn btn-secondary"
                    >
                        <i class="fas fa-rotate-left"></i>
                    </a>

                </div>

            </div>

        </form>

    </div>

</div>


{{-- TOMBOL EXPORT --}}
<div class="card border-0 shadow-sm mb-4">

    <div class="card-body">

        <div class="d-flex flex-wrap gap-2">

            {{-- EXCEL --}}
            <a
                href="{{ route('admin.rekap.export.excel', array_merge(request()->query(), ['jenis' => 'pekerjaan'])) }}"
                class="btn btn-success"
            >

                <i class="fas fa-file-excel me-2"></i>
                Export Excel

            </a>


            {{-- PDF --}}
            <a
                href="{{ route('admin.rekap.export.pdf', array_merge(request()->query(), ['jenis' => 'pekerjaan'])) }}"
                class="btn btn-danger"
            >

                <i class="fas fa-file-pdf me-2"></i>
                Export PDF

            </a>


            {{-- BAGIKAN --}}
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

                    <i class="fas fa-list text-primary me-2"></i>

                    Data Laporan Pekerjaan

                </h5>

                <small class="text-muted">

                    @if(request('pt_proyek'))

                        PT / Proyek:
                        <strong>{{ request('pt_proyek') }}</strong>

                    @else

                        Semua PT / Proyek

                    @endif

                </small>

            </div>

            <span class="badge bg-primary">
                {{ $laporan->count() }} Data
            </span>

        </div>

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
                                    {{ $item->user->karyawan->nama ?? $item->user->name ?? '-' }}
                                </strong>

                            </td>

                            <td>

                                {{ $item->user->karyawan->dataJabatan->nama_pt ?? '-' }}

                            </td>

                            <td>

                                {{ $item->isi_laporan ?? $item->laporan ?? $item->keterangan ?? '-' }}

                            </td>

                            <td>

                                {{ $item->created_at
                                    ? $item->created_at->format('d-m-Y H:i')
                                    : '-' }}

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="5" class="text-center py-5">

                                <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>

                                <h5 class="text-muted">
                                    Belum Ada Laporan
                                </h5>

                                <p class="text-muted mb-0">
                                    Belum ada laporan pekerjaan yang sesuai dengan filter.
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

function bagikanRekap() {

    const url = window.location.href;

    const text = "Rekap Laporan Pekerjaan SIAKA\n" + url;

    if (navigator.share) {

        navigator.share({
            title: 'Rekap Laporan Pekerjaan',
            text: 'Rekap Laporan Pekerjaan SIAKA',
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