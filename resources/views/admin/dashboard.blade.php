@extends('layouts.admin')

@section('title','Dashboard')

@section('content')

<div class="row">

    <div class="col-md-3 mb-4">
        <div class="card shadow border-0">
            <div class="card-body">
                <h6>Total Karyawan</h6>
                <h2>120</h2>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-4">
        <div class="card shadow border-0">
            <div class="card-body">
                <h6>Hadir Hari Ini</h6>
                <h2 class="text-success">95</h2>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-4">
        <div class="card shadow border-0">
            <div class="card-body">
                <h6>Belum Absen</h6>
                <h2 class="text-warning">25</h2>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-4">
        <div class="card shadow border-0">
            <div class="card-body">
                <h6>Divisi</h6>
                <h2 class="text-primary">8</h2>
            </div>
        </div>
    </div>

</div>

<div class="card shadow border-0">
    <div class="card-header bg-white">
        <b>Dashboard SIAKA</b>
    </div>

    <div class="card-body">
        <h3>Selamat Datang 👋</h3>
        <p>Sistem Informasi Absensi Karyawan berhasil dijalankan.</p>
    </div>
</div>

@endsection