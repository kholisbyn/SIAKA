@extends('layouts.admin')

@section('title', 'Laporan')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-1">
            <i class="fas fa-file-lines text-primary me-2"></i>
            Laporan
        </h2>

        <p class="text-muted mb-0">
            Kelola dan lihat laporan perusahaan
        </p>
    </div>
</div>

<div class="row g-4">

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
                            Laporan pekerjaan karyawan
                        </p>

                    </div>

                </div>

                <p class="text-muted">
                    Lihat laporan pekerjaan yang telah dibuat
                    oleh karyawan atau admin lapangan.
                </p>

                <a
                    href="{{ route('admin.laporan.pekerjaan') }}"
                    class="btn btn-primary"
                >
                    <i class="fas fa-eye me-2"></i>
                    Lihat Laporan Pekerjaan
                </a>

            </div>

        </div>

    </div>

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
                            Laporan pengeluaran perusahaan
                        </p>

                    </div>

                </div>

                <p class="text-muted">
                    Lihat laporan pengeluaran yang telah
                    dibuat oleh karyawan atau admin lapangan.
                </p>

                <a
                    href="{{ route('admin.laporan.keuangan') }}"
                    class="btn btn-success"
                >
                    <i class="fas fa-eye me-2"></i>
                    Lihat Laporan Keuangan
                </a>

            </div>

        </div>

    </div>

</div>

@endsection