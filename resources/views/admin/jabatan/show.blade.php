@extends('layouts.admin')

@section('title','Detail Jabatan')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <h2 class="fw-bold">
        <i class="fas fa-briefcase text-info"></i>
        Detail Jabatan
    </h2>

    <a href="{{ route('jabatan.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i>
        Kembali
    </a>

</div>

<div class="card shadow-sm border-0">

    <div class="card-body">

        <table class="table table-bordered">

            <tr>

                <th width="25%">Nama</th>

                <td>{{ $jabatan->nama }}</td>

            </tr>

            <tr>

                <th>Jabatan</th>

                <td>{{ $jabatan->jabatan }}</td>

            </tr>

            <tr>

                <th>Nama PT / Proyek</th>

                <td>{{ $jabatan->nama_pt }}</td>

            </tr>

            <tr>

                <th>Dibuat</th>

                <td>{{ $jabatan->created_at->format('d-m-Y H:i') }}</td>

            </tr>

            <tr>

                <th>Terakhir Diubah</th>

                <td>{{ $jabatan->updated_at->format('d-m-Y H:i') }}</td>

            </tr>

        </table>

        <div class="mt-4">

            <a href="{{ route('jabatan.edit',$jabatan->id) }}" class="btn btn-warning">

                <i class="fas fa-edit"></i>

                Edit

            </a>

            <a href="{{ route('jabatan.index') }}" class="btn btn-secondary">

                <i class="fas fa-arrow-left"></i>

                Kembali

            </a>

        </div>

    </div>

</div>

@endsection