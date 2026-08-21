@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')

<div class="dashboard-heading">

    <div class="d-flex align-items-center gap-3">

        <div class="dashboard-icon">
            <i class="fas fa-gauge-high"></i>
        </div>

        <div>
            <h1 class="mb-0">Dashboard Admin</h1>

            <p class="text-muted mb-0">
                Ringkasan informasi administrasi perusahaan
            </p>
        </div>

    </div>

    <span class="dashboard-date">
        {{ now()->translatedFormat('d F Y') }}
    </span>

</div>

<div class="row g-4 mb-4">

    <div class="col-xl-3 col-md-6">

        <div class="card border-0 shadow-sm h-100">

            <div class="card-body">

                <div class="d-flex justify-content-between align-items-center">

                    <div>
                        <p class="text-muted mb-1">
                            Total Karyawan
                        </p>

                        <h2 class="fw-bold mb-1">
                            {{ $totalKaryawan }}
                        </h2>

                        <small class="text-muted">
                            Seluruh data karyawan
                        </small>
                    </div>

                    <div class="text-primary">
                        <i class="fas fa-users fa-3x"></i>
                    </div>

                </div>

            </div>

        </div>

    </div>

    <div class="col-xl-3 col-md-6">

        <div class="card border-0 shadow-sm h-100">

            <div class="card-body">

                <div class="d-flex justify-content-between align-items-center">

                    <div>
                        <p class="text-muted mb-1">
                            Karyawan Aktif
                        </p>

                        <h2 class="fw-bold text-success mb-1">
                            {{ $karyawanAktif }}
                        </h2>

                        <small class="text-muted">
                            Karyawan berstatus aktif
                        </small>
                    </div>

                    <div class="text-success">
                        <i class="fas fa-user-check fa-3x"></i>
                    </div>

                </div>

            </div>

        </div>

    </div>

    <div class="col-xl-3 col-md-6">

        <div class="card border-0 shadow-sm h-100">

            <div class="card-body">

                <div class="d-flex justify-content-between align-items-center">

                    <div>
                        <p class="text-muted mb-1">
                            Karyawan Nonaktif
                        </p>

                        <h2 class="fw-bold text-danger mb-1">
                            {{ $karyawanNonaktif }}
                        </h2>

                        <small class="text-muted">
                            Karyawan berstatus nonaktif
                        </small>
                    </div>

                    <div class="text-danger">
                        <i class="fas fa-user-xmark fa-3x"></i>
                    </div>

                </div>

            </div>

        </div>

    </div>

    <div class="col-xl-3 col-md-6">

        <div class="card border-0 shadow-sm h-100">

            <div class="card-body">

                <div class="d-flex justify-content-between align-items-center">

                    <div>
                        <p class="text-muted mb-1">
                            Total Basic Gaji
                        </p>

                        <h5 class="fw-bold text-warning mb-1">
                            Rp {{ number_format($totalGaji, 0, ',', '.') }}
                        </h5>

                        <small class="text-muted">
                            Total basic gaji karyawan
                        </small>
                    </div>

                    <div class="text-warning">
                        <i class="fas fa-money-bill-wave fa-3x"></i>
                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<div class="row g-4">

    <div class="col-lg-8">

        <div class="card border-0 shadow-sm h-100">

            <div class="card-header bg-primary text-white">

                <h5 class="mb-0">
                    <i class="fas fa-chart-column me-2"></i>
                    Statistik Karyawan
                </h5>

            </div>

            <div class="card-body">

                <canvas
                    id="chartKaryawan"
                    height="120">
                </canvas>

            </div>

        </div>

    </div>

    <div class="col-lg-4">

        <div class="card border-0 shadow-sm h-100">

            <div class="card-header bg-success text-white">

                <h5 class="mb-0">
                    <i class="fas fa-circle-info me-2"></i>
                    Informasi
                </h5>

            </div>

            <div class="card-body">

                <div class="d-flex justify-content-between mb-4">

                    <span>
                        <i class="fas fa-users text-primary me-2"></i>
                        Total Karyawan
                    </span>

                    <strong>
                        {{ $totalKaryawan }}
                    </strong>

                </div>

                <div class="d-flex justify-content-between mb-4">

                    <span>
                        <i class="fas fa-user-check text-success me-2"></i>
                        Aktif
                    </span>

                    <strong class="text-success">
                        {{ $karyawanAktif }}
                    </strong>

                </div>

                <div class="d-flex justify-content-between mb-4">

                    <span>
                        <i class="fas fa-user-xmark text-danger me-2"></i>
                        Nonaktif
                    </span>

                    <strong class="text-danger">
                        {{ $karyawanNonaktif }}
                    </strong>

                </div>

                <hr>

                <p class="mb-0 text-muted">
                    Selamat datang di
                    <strong>
                        Sistem Informasi Absensi Karyawan
                    </strong>
                </p>

            </div>

        </div>

    </div>

</div>

@endsection

@push('scripts')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const canvas = document.getElementById('chartKaryawan');

    if (!canvas) {
        return;
    }

    new Chart(canvas, {
        type: 'bar',

        data: {
            labels: [
                'Total',
                'Aktif',
                'Nonaktif'
            ],

            datasets: [{
                label: 'Jumlah Karyawan',

                data: [
                    {{ $totalKaryawan }},
                    {{ $karyawanAktif }},
                    {{ $karyawanNonaktif }}
                ],

                backgroundColor: [
                    '#2563eb',
                    '#16a34a',
                    '#dc2626'
                ],

                borderRadius: 8
            }]
        },

        options: {
            responsive: true,

            plugins: {
                legend: {
                    display: false
                }
            },

            scales: {
                y: {
                    beginAtZero: true,

                    ticks: {
                        precision: 0
                    }
                }
            }
        }
    });

});
</script>

@endpush