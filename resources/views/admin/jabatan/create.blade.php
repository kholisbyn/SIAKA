@extends('layouts.admin')

@section('title','Tambah Jabatan')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <h2 class="fw-bold">
        <i class="fas fa-plus-circle text-primary"></i>
        Tambah Jabatan
    </h2>

    <a href="{{ route('jabatan.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i>
        Kembali
    </a>

</div>

<div class="card shadow-sm border-0">

    <div class="card-body">

        @if ($errors->any())

            <div class="alert alert-danger">

                <ul class="mb-0">

                    @foreach ($errors->all() as $error)

                        <li>{{ $error }}</li>

                    @endforeach

                </ul>

            </div>

        @endif

        <form action="{{ route('jabatan.store') }}" method="POST">

            @csrf

            <div class="mb-3">

                <label class="form-label fw-semibold">

                    Nama

                </label>

                <input type="text"
                       name="nama"
                       class="form-control"
                       value="{{ old('nama') }}"
                       required>

            </div>

            <div class="mb-3">

                <label class="form-label fw-semibold">

                    Jabatan

                </label>

                <input type="text"
                       name="jabatan"
                       class="form-control"
                       value="{{ old('jabatan') }}"
                       required>

            </div>

            <div class="mb-4">

                <label class="form-label fw-semibold">

                    Nama PT / Proyek

                </label>

                <input type="text"
                       name="nama_pt"
                       class="form-control"
                       value="{{ old('nama_pt') }}"
                       required>

            </div>

            <button type="submit" class="btn btn-primary">

                <i class="fas fa-save"></i>

                Simpan

            </button>

            <a href="{{ route('jabatan.index') }}" class="btn btn-outline-secondary">

                <i class="fas fa-times"></i>

                Batal

            </a>

        </form>

    </div>

</div>

@endsection