@extends('layouts.admin')

@section('title', 'Edit Biodata')

@section('content')

<div class="mb-3">
    <a
        href="{{ route('admin.biodata.show', $karyawan) }}"
        class="btn btn-secondary"
    >
        <i class="fas fa-arrow-left me-1"></i>
        Kembali
    </a>
</div>

@if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="card shadow border-0">

    <div class="card-header py-3">
        <h5 class="mb-0 fw-bold">
            <i class="fas fa-id-card me-2 text-primary"></i>
            Biodata Karyawan
        </h5>
    </div>

    <div class="card-body">

        <form
            action="{{ route('admin.biodata.update', $karyawan) }}"
            method="POST"
            enctype="multipart/form-data"
        >

            @csrf
            @method('PUT')

            <div class="row g-4">

                <div class="col-md-4">

                    <div class="text-center">

                        @if($karyawan->biodata && $karyawan->biodata->foto)

                            <img
                                src="{{ asset('storage/' . $karyawan->biodata->foto) }}"
                                alt="Foto Karyawan"
                                width="180"
                                height="180"
                                class="rounded-circle shadow-sm mb-3"
                                style="object-fit: cover;"
                            >

                        @else

                            <img
                                src="https://ui-avatars.com/api/?name={{ urlencode($karyawan->nama) }}&background=2563EB&color=fff&size=180"
                                alt="Foto Karyawan"
                                width="180"
                                height="180"
                                class="rounded-circle shadow-sm mb-3"
                            >

                        @endif

                        <div class="mb-3">

                            <label class="form-label fw-semibold">
                                Foto Karyawan
                            </label>

                            <input
                                type="file"
                                name="foto"
                                class="form-control"
                                accept=".jpg,.jpeg,.png"
                            >

                            <small class="text-muted">
                                JPG, JPEG atau PNG maksimal 2 MB.
                            </small>

                        </div>

                    </div>

                </div>

                <div class="col-md-8">

                    <div class="row g-3">

                        <div class="col-md-6">

                            <label class="form-label fw-semibold">
                                Nama Lengkap
                            </label>

                            <input
                                type="text"
                                class="form-control"
                                value="{{ $karyawan->nama }}"
                                readonly
                            >

                        </div>

                        <div class="col-md-6">

                            <label class="form-label fw-semibold">
                                Jabatan
                            </label>

                            <input
                                type="text"
                                class="form-control"
                                value="{{ $karyawan->dataJabatan->jabatan ?? '-' }}"
                                readonly
                            >

                        </div>

                        <div class="col-md-6">

                            <label class="form-label fw-semibold">
                                NIK
                            </label>

                            <input
                                type="text"
                                name="nik"
                                class="form-control"
                                value="{{ old('nik', $karyawan->biodata->nik ?? '') }}"
                                placeholder="Masukkan NIK"
                            >

                        </div>

                        <div class="col-md-6">

                            <label class="form-label fw-semibold">
                                Nomor HP
                            </label>

                            <input
                                type="text"
                                name="no_hp"
                                class="form-control"
                                value="{{ old('no_hp', $karyawan->biodata->no_hp ?? '') }}"
                                placeholder="Masukkan nomor HP"
                            >

                        </div>

                        <div class="col-md-6">

                            <label class="form-label fw-semibold">
                                Tempat Lahir
                            </label>

                            <input
                                type="text"
                                name="tempat_lahir"
                                class="form-control"
                                value="{{ old('tempat_lahir', $karyawan->biodata->tempat_lahir ?? '') }}"
                                placeholder="Masukkan tempat lahir"
                            >

                        </div>

                        <div class="col-md-6">

                            <label class="form-label fw-semibold">
                                Tanggal Lahir
                            </label>

                            <input
                                type="date"
                                name="tanggal_lahir"
                                class="form-control"
                                value="{{ old('tanggal_lahir', $karyawan->biodata?->tanggal_lahir?->format('Y-m-d')) }}"
                            >

                        </div>

                        <div class="col-md-6">

                            <label class="form-label fw-semibold">
                                Jenis Kelamin
                            </label>

                            <select
                                name="jenis_kelamin"
                                class="form-select"
                            >

                                <option value="">
                                    Pilih Jenis Kelamin
                                </option>

                                <option
                                    value="Laki-laki"
                                    {{ old('jenis_kelamin', $karyawan->biodata->jenis_kelamin ?? '') === 'Laki-laki' ? 'selected' : '' }}
                                >
                                    Laki-laki
                                </option>

                                <option
                                    value="Perempuan"
                                    {{ old('jenis_kelamin', $karyawan->biodata->jenis_kelamin ?? '') === 'Perempuan' ? 'selected' : '' }}
                                >
                                    Perempuan
                                </option>

                            </select>

                        </div>

                        <div class="col-md-6">

                            <label class="form-label fw-semibold">
                                Tanggal Masuk
                            </label>

                            <input
                                type="date"
                                name="tanggal_masuk"
                                class="form-control"
                                value="{{ old('tanggal_masuk', $karyawan->biodata?->tanggal_masuk?->format('Y-m-d')) }}"
                            >

                        </div>

                        <div class="col-12">

                            <label class="form-label fw-semibold">
                                Alamat
                            </label>

                            <textarea
                                name="alamat"
                                class="form-control"
                                rows="4"
                                placeholder="Masukkan alamat lengkap"
                            >{{ old('alamat', $karyawan->biodata->alamat ?? '') }}</textarea>

                        </div>

                    </div>

                </div>

            </div>

            <div class="d-flex justify-content-end gap-2 mt-4">

                <a
                    href="{{ route('admin.biodata.show', $karyawan) }}"
                    class="btn btn-secondary"
                >
                    Batal
                </a>

                <button
                    type="submit"
                    class="btn btn-primary"
                >
                    <i class="fas fa-save me-1"></i>
                    Simpan Biodata
                </button>

            </div>

        </form>

    </div>

</div>

@endsection