@extends('layouts.admin')

@section('title','Edit Jabatan')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <h2 class="fw-bold">
        <i class="fas fa-edit text-warning"></i>
        Edit Jabatan
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

        <form action="{{ route('jabatan.update',$jabatan->id) }}"
              method="POST">

            @csrf
            @method('PUT')

            <div class="mb-3">

                <label class="form-label fw-semibold">

                    Nama

                </label>

                <input type="text"
                       name="nama"
                       class="form-control"
                       value="{{ old('nama',$jabatan->nama) }}"
                       required>

            </div>

            <div class="mb-3">

                <label class="form-label fw-semibold">

                    Jabatan

                </label>

                <input type="text"
                       name="jabatan"
                       class="form-control"
                       value="{{ old('jabatan',$jabatan->jabatan) }}"
                       required>

            </div>

            <div class="mb-4">

                <label class="form-label fw-semibold">

                    Nama PT / Proyek

                </label>

                <input type="text"
                       name="nama_pt"
                       class="form-control"
                       value="{{ old('nama_pt',$jabatan->nama_pt) }}"
                       required>

            </div>

            <button type="submit" class="btn btn-success">

                <i class="fas fa-save"></i>

                Update

            </button>

            <a href="{{ route('jabatan.index') }}" class="btn btn-outline-secondary">

                <i class="fas fa-times"></i>

                Batal

            </a>

        </form>

    </div>

</div>

@endsection