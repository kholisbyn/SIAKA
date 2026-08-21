@extends('layouts.admin')

@section('title', 'Rekap')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>

        <h2 class="fw-bold mb-1">
            <i class="fas fa-chart-column text-primary me-2"></i>
            Rekap
        </h2>

        <p class="text-muted mb-0">
            Rekap laporan dan absensi karyawan
        </p>

    </div>

</div>


{{-- FILTER PT / PROYEK --}}
<div class="card border-0 shadow-sm mb-4">

    <div class="card-body">

        <form
            action="{{ route('admin.rekap.index') }}"
            method="GET"
        >

            <div class="row g-3 align-items-end">

                <div class="col-md-9">

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


                <div class="col-md-3 d-flex gap-2">

                    <button
                        type="submit"
                        class="btn btn-primary flex-fill"
                    >

                        <i class="fas fa-search me-2"></i>

                        Tampilkan

                    </button>


                    <a
                        href="{{ route('admin.rekap.index') }}"
                        class="btn btn-secondary"
                        title="Reset"
                    >

                        <i class="fas fa-rotate-left"></i>

                    </a>

                </div>

            </div>

        </form>

    </div>

</div>


{{-- INFORMASI FILTER --}}
@if(request('pt_proyek'))

    <div class="alert alert-info border-0 shadow-sm">

        <i class="fas fa-filter me-2"></i>

        Menampilkan rekap untuk:

        <strong>
            {{ request('pt_proyek') }}
        </strong>

    </div>

@endif


<div class="row g-4">


    {{-- LAPORAN PEKERJAAN --}}
    <div class="col-md-6">

        <div class="card border-0 shadow-sm h-100">

            <div class="card-body p-4">

                <div class="d-flex align-items-center mb-4">

                    <div
                        class="bg-primary text-white rounded-3 d-flex align-items-center justify-content-center"
                        style="width:60px;height:60px;"
                    >

                        <i class="fas fa-briefcase fa-2x"></i>

                    </div>


                    <div class="ms-3">

                        <h4 class="fw-bold mb-1">
                            Laporan Pekerjaan
                        </h4>

                        <p class="text-muted mb-0">
                            Rekap pekerjaan karyawan
                        </p>

                    </div>

                </div>


                <p class="text-muted">
                    Lihat laporan pekerjaan berdasarkan PT atau proyek.
                </p>


                <a
                    href="{{ route('admin.rekap.pekerjaan', ['pt_proyek' => request('pt_proyek')]) }}"
                    class="btn btn-primary"
                >

                    <i class="fas fa-eye me-2"></i>

                    Lihat Laporan

                </a>

            </div>

        </div>

    </div>



    {{-- LAPORAN KEUANGAN --}}
    <div class="col-md-6">

        <div class="card border-0 shadow-sm h-100">

            <div class="card-body p-4">

                <div class="d-flex align-items-center mb-4">

                    <div
                        class="bg-success text-white rounded-3 d-flex align-items-center justify-content-center"
                        style="width:60px;height:60px;"
                    >

                        <i class="fas fa-money-bill-wave fa-2x"></i>

                    </div>


                    <div class="ms-3">

                        <h4 class="fw-bold mb-1">
                            Laporan Keuangan
                        </h4>

                        <p class="text-muted mb-0">
                            Rekap pengeluaran
                        </p>

                    </div>

                </div>


                <p class="text-muted">
                    Lihat laporan keuangan berdasarkan PT atau proyek.
                </p>


                <a
                    href="{{ route('admin.rekap.keuangan', ['pt_proyek' => request('pt_proyek')]) }}"
                    class="btn btn-success"
                >

                    <i class="fas fa-eye me-2"></i>

                    Lihat Laporan

                </a>

            </div>

        </div>

    </div>



    {{-- ABSENSI HARIAN --}}
    <div class="col-md-4">

        <div class="card border-0 shadow-sm h-100">

            <div class="card-body p-4">

                <div
                    class="bg-info text-white rounded-3 d-flex align-items-center justify-content-center mb-3"
                    style="width:60px;height:60px;"
                >

                    <i class="fas fa-calendar-day fa-2x"></i>

                </div>


                <h5 class="fw-bold">
                    Absensi Harian
                </h5>


                <p class="text-muted">
                    Rekap absensi berdasarkan tanggal.
                </p>


                <a
                    href="{{ route('admin.rekap.harian', ['pt_proyek' => request('pt_proyek')]) }}"
                    class="btn btn-info text-white"
                >

                    <i class="fas fa-eye me-2"></i>

                    Lihat Rekap

                </a>

            </div>

        </div>

    </div>



    {{-- ABSENSI MINGGUAN --}}
    <div class="col-md-4">

        <div class="card border-0 shadow-sm h-100">

            <div class="card-body p-4">

                <div
                    class="bg-warning text-dark rounded-3 d-flex align-items-center justify-content-center mb-3"
                    style="width:60px;height:60px;"
                >

                    <i class="fas fa-calendar-week fa-2x"></i>

                </div>


                <h5 class="fw-bold">
                    Absensi Mingguan
                </h5>


                <p class="text-muted">
                    Rekap absensi berdasarkan minggu.
                </p>


                <a
                    href="{{ route('admin.rekap.mingguan', ['pt_proyek' => request('pt_proyek')]) }}"
                    class="btn btn-warning"
                >

                    <i class="fas fa-eye me-2"></i>

                    Lihat Rekap

                </a>

            </div>

        </div>

    </div>



    {{-- ABSENSI BULANAN --}}
    <div class="col-md-4">

        <div class="card border-0 shadow-sm h-100">

            <div class="card-body p-4">

                <div
                    class="bg-danger text-white rounded-3 d-flex align-items-center justify-content-center mb-3"
                    style="width:60px;height:60px;"
                >

                    <i class="fas fa-calendar-days fa-2x"></i>

                </div>


                <h5 class="fw-bold">
                    Absensi Bulanan
                </h5>


                <p class="text-muted">
                    Rekap absensi berdasarkan bulan.
                </p>


                <a
                    href="{{ route('admin.rekap.bulanan', ['pt_proyek' => request('pt_proyek')]) }}"
                    class="btn btn-danger"
                >

                    <i class="fas fa-eye me-2"></i>

                    Lihat Rekap

                </a>

            </div>

        </div>

    </div>

</div>

@endsection