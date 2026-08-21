@extends('layouts.admin')

@section('title', 'Pengaturan')

@section('content')

<div class="mb-4">

    <h2 class="fw-bold mb-1">
        <i class="fas fa-gear text-primary me-2"></i>
        Pengaturan
    </h2>

    <p class="text-muted mb-0">
        Kelola pengaturan dan keamanan sistem SIAKA.
    </p>

</div>


<div class="row g-4">

    <div class="col-lg-8">

        <div class="card border-0 shadow-sm">

            <div class="card-header bg-white py-3">

                <h5 class="fw-bold mb-1">
                    <i class="fas fa-database text-primary me-2"></i>
                    Backup Database
                </h5>

                <small class="text-muted">
                    Simpan salinan database SIAKA untuk menjaga keamanan data.
                </small>

            </div>

            <div class="card-body">

                <div class="d-flex align-items-start gap-3">

                    <div
                        class="d-flex align-items-center justify-content-center bg-primary bg-opacity-10 text-primary rounded-3"
                        style="width:60px;height:60px;min-width:60px;"
                    >
                        <i class="fas fa-database fa-2x"></i>
                    </div>

                    <div>

                        <h5 class="fw-bold mb-2">
                            Backup Database SIAKA
                        </h5>

                        <p class="text-muted mb-3">
                            Buat salinan seluruh data sistem dalam bentuk
                            file SQL untuk keamanan dan pemulihan data.
                        </p>

                        <form method="POST" action="{{ route('admin.backup') }}">
                            @csrf

                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-download me-2"></i>
                                Backup Sekarang
                            </button>
                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>


    <div class="col-lg-4">

        <div class="card border-0 shadow-sm">

            <div class="card-header bg-white py-3">

                <h5 class="fw-bold mb-0">
                    <i class="fas fa-shield-halved text-success me-2"></i>
                    Keamanan Data
                </h5>

            </div>

            <div class="card-body">

                <div class="d-flex align-items-center mb-3">

                    <i class="fas fa-circle-check text-success fa-lg me-3"></i>

                    <div>

                        <strong>Database</strong>

                        <div class="small text-muted">
                            Terhubung
                        </div>

                    </div>

                </div>


                <div class="d-flex align-items-center mb-3">

                    <i class="fas fa-database text-primary fa-lg me-3"></i>

                    <div>

                        <strong>Backup Database</strong>

                        <div class="small text-muted">
                            Tersedia
                        </div>

                    </div>

                </div>


                <div class="d-flex align-items-center">

                    <i class="fas fa-user-shield text-warning fa-lg me-3"></i>

                    <div>

                        <strong>Akses Admin</strong>

                        <div class="small text-muted">
                            Administrator
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>


    <div class="col-12">

        <div class="card border-0 shadow-sm">

            <div class="card-header bg-white py-3">

                <h5 class="fw-bold mb-0">
                    <i class="fas fa-circle-info text-info me-2"></i>
                    Informasi Sistem
                </h5>

            </div>

            <div class="card-body">

                <div class="row">

                    <div class="col-md-4 mb-3 mb-md-0">

                        <small class="text-muted d-block">
                            Nama Sistem
                        </small>

                        <strong>
                            SIAKA
                        </strong>

                    </div>


                    <div class="col-md-4 mb-3 mb-md-0">

                        <small class="text-muted d-block">
                            Perusahaan
                        </small>

                        <strong>
                            CV. Karunia Andalan Sejahtera
                        </strong>

                    </div>


                    <div class="col-md-4">

                        <small class="text-muted d-block">
                            Tahun
                        </small>

                        <strong>
                            {{ date('Y') }}
                        </strong>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection