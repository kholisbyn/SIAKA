@extends('layouts.karyawan')

@section('title','Laporan Pengeluaran')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4>Laporan Pengeluaran</h4>
        <p class="text-muted mb-0">Daftar pengeluaran yang telah dibuat.</p>
    </div>

    <a href="{{ route('karyawan.laporan-pengeluaran.create') }}" class="btn btn-primary">
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

                <div class="d-flex justify-content-between mb-3">
                    <strong>Laporan Pengeluaran</strong>

                    <small class="text-muted">
                        {{ $item->created_at->format('d-m-Y H:i') }}
                    </small>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered mb-3">
                        <thead>
                            <tr>
                                <th>Barang</th>
                                <th width="200">Nominal</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($item->detail as $detail)
                                <tr>
                                    <td>{{ $detail->nama_barang }}</td>
                                    <td>Rp {{ number_format($detail->nominal, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>

                        <tfoot>
                            <tr>
                                <th>Total</th>
                                <th>
                                    Rp {{ number_format($item->detail->sum('nominal'), 0, ',', '.') }}
                                </th>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                @if($item->keterangan)
                    <div>
                        <strong>Keterangan:</strong>
                        <p class="mb-0">{{ $item->keterangan }}</p>
                    </div>
                @endif

            </div>
        </div>
    @endforeach
@else
    <div class="card shadow border-0">
        <div class="card-body text-center py-5">

            <i class="fas fa-money-bill-wave fa-3x text-muted mb-3"></i>

            <h5>Belum Ada Laporan</h5>

            <p class="text-muted">
                Belum ada laporan pengeluaran yang dibuat.
            </p>

            <a href="{{ route('karyawan.laporan-pengeluaran.create') }}" class="btn btn-primary">
                Buat Laporan
            </a>

        </div>
    </div>
@endif

@endsection