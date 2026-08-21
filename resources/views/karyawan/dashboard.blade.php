@extends('layouts.karyawan')

@section('title')
@if(auth()->user()->role === 'admin_lapangan')
    Dashboard Admin Lapangan
@else
    Dashboard Karyawan
@endif
@endsection

@section('content')

<div class="row">

    {{-- SELAMAT DATANG --}}
    <div class="col-md-6 mb-4">

        <div class="card shadow border-0 h-100">

            <div class="card-body">

                <h5>
                    Selamat Datang
                </h5>

                <h3>
                    {{ auth()->user()->name }}
                </h3>

                <p class="text-muted mb-0">
                    Selamat bekerja. Silakan lakukan absensi sesuai waktu kerja.
                </p>

            </div>

        </div>

    </div>


    {{-- STATUS ABSENSI --}}
    <div class="col-md-6 mb-4">

        <div class="card shadow border-0 h-100">

            <div class="card-body">

                <h6>
                    Status Absensi Hari Ini
                </h6>

                @if(!$absensi)

                    <h3 class="text-danger">
                        Belum Absen
                    </h3>

                    <p class="text-muted mb-0">
                        Silakan lakukan absen masuk.
                    </p>

                @elseif(!$absensi->jam_pulang)

                    <h3 class="text-warning">
                        Sudah Absen Masuk
                    </h3>

                    <p class="mb-0">
                        Jam masuk:
                        <strong>
                            {{ $absensi->jam_masuk }}
                        </strong>
                    </p>

                @else

                    <h3 class="text-success">
                        Absensi Selesai
                    </h3>

                    <p class="mb-1">
                        Jam masuk:
                        <strong>
                            {{ $absensi->jam_masuk }}
                        </strong>
                    </p>

                    <p class="mb-0">
                        Jam pulang:
                        <strong>
                            {{ $absensi->jam_pulang }}
                        </strong>
                    </p>

                @endif

            </div>

        </div>

    </div>


    {{-- NOTIFIKASI --}}
    <div class="col-12 mb-4">

        <div class="card shadow border-0">

            <div class="card-header bg-white d-flex justify-content-between align-items-center">

                <h5 class="mb-0">

                    <i class="fas fa-bell text-warning me-2"></i>

                    Notifikasi

                </h5>


                @if($notifikasiBelumDibaca > 0)

                    <span class="badge bg-danger">

                        {{ $notifikasiBelumDibaca }}

                        belum dibaca

                    </span>

                @endif

            </div>


            <div class="card-body">

                @if($notifikasis->count() > 0)

                    @foreach($notifikasis as $notifikasi)

                        <div
                            class="alert
                            {{ $notifikasi->dibaca ? 'alert-light' : 'alert-primary' }}
                            d-flex align-items-start mb-2"
                        >

                            {{-- ICON --}}
                            <div class="me-3">

                                @if(
                                    str_contains(
                                        strtolower($notifikasi->judul),
                                        'setuju'
                                    )
                                )

                                    <i class="fas fa-check-circle text-success fa-lg"></i>

                                @elseif(
                                    str_contains(
                                        strtolower($notifikasi->judul),
                                        'tolak'
                                    )
                                )

                                    <i class="fas fa-times-circle text-danger fa-lg"></i>

                                @else

                                    <i class="fas fa-bell text-primary fa-lg"></i>

                                @endif

                            </div>


                            {{-- ISI NOTIFIKASI --}}
                            <div class="flex-grow-1">

                                <strong>
                                    {{ $notifikasi->judul }}
                                </strong>

                                <p class="mb-1">

                                    {{ $notifikasi->pesan }}

                                </p>

                                <small class="text-muted">

                                    {{ $notifikasi->created_at->format('d/m/Y H:i') }}

                                </small>

                            </div>


                            {{-- LABEL BARU --}}
                            @if(!$notifikasi->dibaca)

                                <span class="badge bg-primary">

                                    Baru

                                </span>

                            @endif

                        </div>

                    @endforeach

                @else

                    {{-- BELUM ADA NOTIFIKASI --}}
                    <div class="text-center py-3">

                        <i class="fas fa-bell-slash fa-2x text-muted mb-2"></i>

                        <p class="text-muted mb-0">

                            Belum ada notifikasi.

                        </p>

                    </div>

                @endif

            </div>

        </div>

    </div>


    {{-- MENU ABSENSI --}}
    <div class="col-12">

        <div class="card shadow border-0">

            <div class="card-header bg-white">

                <h5 class="mb-0">

                    Menu Absensi

                </h5>

            </div>


            <div class="card-body">

                <div class="d-flex flex-wrap gap-2">

                    @if(!$absensi)

                        <a
                            href="{{ route('karyawan.absensi.masuk') }}"
                            class="btn btn-primary"
                        >

                            <i class="fas fa-camera me-2"></i>

                            Absen Masuk

                        </a>


                    @elseif(!$absensi->jam_pulang)

                        <a
                            href="{{ route('karyawan.absensi.pulang') }}"
                            class="btn btn-danger"
                        >

                            <i class="fas fa-camera me-2"></i>

                            Absen Pulang

                        </a>


                    @else

                        <button
                            class="btn btn-success"
                            disabled
                        >

                            <i class="fas fa-check me-2"></i>

                            Absensi Hari Ini Selesai

                        </button>

                    @endif

                </div>

            </div>

        </div>

    </div>

</div>

@endsection