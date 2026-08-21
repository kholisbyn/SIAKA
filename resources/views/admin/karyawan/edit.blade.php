@extends('layouts.admin')

@section('title','Edit Karyawan')

@section('content')

<a href="{{ route('karyawan.index') }}" class="btn btn-secondary">
    <i class="fas fa-arrow-left me-1"></i>
    Kembali
</a>

@if ($errors->any())
    <div class="alert alert-danger mt-3">
        @foreach ($errors->all() as $error)
            <div>{{ $error }}</div>
        @endforeach
    </div>
@endif

@if(session('success'))
    <div class="alert alert-success mt-3">
        {{ session('success') }}
    </div>
@endif

<div class="card-body">

    <form action="{{ route('karyawan.update', $karyawan->id) }}"
          method="POST">

        @csrf
        @method('PUT')

        <div class="row">

            <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">Nama Lengkap</label>
                <input
                    type="text"
                    name="nama"
                    class="form-control"
                    value="{{ old('nama', $karyawan->nama) }}"
                    required
                >
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">NIK</label>
                <input
                    type="text"
                    name="nik"
                    class="form-control"
                    value="{{ old('nik', $karyawan->nik) }}"
                >
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">Tempat Lahir</label>
                <input
                    type="text"
                    name="tempat_lahir"
                    class="form-control"
                    value="{{ old('tempat_lahir', $karyawan->tempat_lahir) }}"
                >
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">Tanggal Lahir</label>
                <input
                    type="date"
                    name="tanggal_lahir"
                    class="form-control"
                    value="{{ old('tanggal_lahir', $karyawan->tanggal_lahir) }}"
                >
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">Jenis Kelamin</label>

                <select name="jenis_kelamin" class="form-select">
                    <option value="">Pilih Jenis Kelamin</option>

                    <option value="Laki-laki"
                        {{ old('jenis_kelamin', $karyawan->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>
                        Laki-laki
                    </option>

                    <option value="Perempuan"
                        {{ old('jenis_kelamin', $karyawan->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>
                        Perempuan
                    </option>
                </select>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">Jabatan</label>

                <select name="jabatan_id" class="form-select" required>
                    @foreach($jabatans as $jabatan)
                        <option
                            value="{{ $jabatan->id }}"
                            {{ old('jabatan_id', $karyawan->jabatan_id) == $jabatan->id ? 'selected' : '' }}
                        >
                            {{ $jabatan->jabatan }} - {{ $jabatan->nama_pt }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">Basic Gaji</label>

                <input
                    type="number"
                    name="basic_gaji"
                    class="form-control"
                    value="{{ old('basic_gaji', $karyawan->basic_gaji) }}"
                >
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">No HP</label>

                <input
                    type="text"
                    name="no_hp"
                    class="form-control"
                    value="{{ old('no_hp', $karyawan->no_hp) }}"
                >
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">Status</label>

                <select name="status" class="form-select" required>
                    <option value="Aktif"
                        {{ old('status', $karyawan->status) == 'Aktif' ? 'selected' : '' }}>
                        Aktif
                    </option>

                    <option value="Nonaktif"
                        {{ old('status', $karyawan->status) == 'Nonaktif' ? 'selected' : '' }}>
                        Nonaktif
                    </option>
                </select>
            </div>

            <div class="col-md-12 mb-3">
                <label class="form-label fw-semibold">Alamat</label>

                <textarea
                    name="alamat"
                    class="form-control"
                    rows="4"
                >{{ old('alamat', $karyawan->alamat) }}</textarea>
            </div>

        </div>

        <div class="d-flex gap-2 mt-3">

            <button type="submit" class="btn btn-success">
                <i class="fas fa-save me-1"></i>
                Update Data
            </button>

            <a href="{{ route('karyawan.index') }}"
               class="btn btn-outline-secondary">
                <i class="fas fa-times me-1"></i>
                Batal
            </a>

            <a href="{{ route('admin.biodata.edit', $karyawan) }}"
               class="btn btn-primary">
                <i class="fas fa-id-card me-1"></i>
                Edit Biodata & Foto
            </a>

        </div>

    </form>

</div>

@endsection