@extends('layouts.karyawan')

@section('title','Laporan Pekerjaan')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4>Laporan Pekerjaan</h4>
        <p class="text-muted mb-0">Daftar laporan pekerjaan yang telah dibuat.</p>
    </div>

    <a href="{{ route('karyawan.laporan-pekerjaan.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Buat Laporan
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if($laporan->count())
    @foreach($laporan as $item)
        <div class="card shadow border-0 mb-3">
            <div class="card-body">
                <div class="d-flex justify-content-between mb-2">
                    <strong>Laporan Pekerjaan</strong>
                    <small class="text-muted">
                        {{ $item->created_at->format('d-m-Y H:i') }}
                    </small>
                </div>

                <p class="mb-0">{{ $item->isi_laporan }}</p>
            </div>
        </div>
    @endforeach
@else
    <div class="card shadow border-0">
        <div class="card-body text-center py-5">
            <i class="fas fa-file-lines fa-3x text-muted mb-3"></i>
            <h5>Belum Ada Laporan</h5>
            <p class="text-muted">Kamu belum membuat laporan pekerjaan.</p>

            <a href="{{ route('karyawan.laporan-pekerjaan.create') }}" class="btn btn-primary">
                Buat Laporan
            </a>
        </div>
    </div>
@endif

@endsection