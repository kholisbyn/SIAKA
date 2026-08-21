@extends('layouts.karyawan')

@section('title', 'Biodata Karyawan')

@section('content')

@if(session('success'))
    <div class="alert alert-success">
        <i class="fas fa-check-circle me-2"></i>
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger">
        <i class="fas fa-exclamation-circle me-2"></i>
        {{ session('error') }}
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="card border-0 shadow-sm">

    <div class="card-header bg-primary text-white py-3">
        <h5 class="mb-0">
            <i class="fas fa-id-card me-2"></i>
            Biodata Karyawan
        </h5>
    </div>

    <div class="card-body p-4">

        <form
            action="{{ route('karyawan.biodata.update') }}"
            method="POST"
            enctype="multipart/form-data"
        >

            @csrf
            @method('PUT')

            <div class="row">

                {{-- FOTO KARYAWAN --}}
                <div class="col-md-4 mb-4">

                    <div class="text-center">

                        @if($karyawan->biodata?->foto)

                            @php
                                $foto = $karyawan->biodata->foto;

                                if (str_starts_with($foto, 'karyawan/')) {
                                    $fotoUrl = asset('storage/' . $foto);
                                } else {
                                    $fotoUrl = asset('storage/karyawan/' . $foto);
                                }
                            @endphp

                            <img
                                src="{{ $fotoUrl }}"
                                class="rounded-circle mb-3 shadow-sm"
                                width="150"
                                height="150"
                                style="object-fit: cover;"
                                alt="Foto Karyawan"
                            >

                        @else

                            <img
                                src="https://ui-avatars.com/api/?name={{ urlencode($karyawan->nama) }}&background=2563EB&color=fff&size=150"
                                class="rounded-circle mb-3"
                                width="150"
                                height="150"
                                alt="Foto Karyawan"
                            >

                        @endif

                        <h5 class="mb-1">
                            {{ $karyawan->nama }}
                        </h5>

                        <span class="badge bg-success">
                            {{ $karyawan->status }}
                        </span>

                        @if($karyawan->dataJabatan)
                            <p class="text-muted mt-2 mb-0">
                                {{ $karyawan->dataJabatan->jabatan }}
                            </p>
                        @endif

                    </div>

                </div>


                {{-- DATA PRIBADI --}}
                <div class="col-md-8">

                    <div class="row">

                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                NIK
                            </label>

                            <input
                                type="text"
                                name="nik"
                                class="form-control"
                                value="{{ old('nik', $karyawan->biodata->nik ?? '') }}"
                            >

                        </div>


                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Nama Lengkap
                            </label>

                            <input
                                type="text"
                                name="nama"
                                class="form-control"
                                value="{{ old('nama', $karyawan->nama) }}"
                            >

                        </div>


                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Tempat Lahir
                            </label>

                            <input
                                type="text"
                                name="tempat_lahir"
                                class="form-control"
                                value="{{ old('tempat_lahir', $karyawan->biodata->tempat_lahir ?? '') }}"
                            >

                        </div>


                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Tanggal Lahir
                            </label>

                            <input
                                type="date"
                                name="tanggal_lahir"
                                class="form-control"
                                value="{{ old('tanggal_lahir', $karyawan->biodata?->tanggal_lahir?->format('Y-m-d')) }}"
                            >

                        </div>


                        <div class="col-md-6 mb-3">

                            <label class="form-label">
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


                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                No. HP
                            </label>

                            <input
                                type="text"
                                name="no_hp"
                                class="form-control"
                                value="{{ old('no_hp', $karyawan->biodata->no_hp ?? '') }}"
                            >

                        </div>


                        <div class="col-md-12 mb-3">

                            <label class="form-label">
                                Alamat
                            </label>

                            <textarea
                                name="alamat"
                                class="form-control"
                                rows="4"
                            >{{ old('alamat', $karyawan->biodata->alamat ?? '') }}</textarea>

                        </div>


                        {{-- FOTO KARYAWAN --}}
                        <div class="col-md-12 mb-3">

                            <label class="form-label">
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


                {{-- VERIFIKASI KTP --}}
                <div class="col-12 mt-3">

                    <div class="card border">

                        <div class="card-header bg-light">

                            <h5 class="mb-0 fw-bold">
                                <i class="fas fa-address-card me-2 text-primary"></i>
                                Verifikasi KTP
                            </h5>

                        </div>

                        <div class="card-body">

                            <div class="row">

                                <div class="col-md-6 mb-3">

                                    <label class="form-label">
                                        Nomor KTP
                                    </label>

                                    <input
                                        type="text"
                                        name="nomor_ktp"
                                        class="form-control"
                                        value="{{ old('nomor_ktp', $ktp->nomor_ktp ?? '') }}"
                                        placeholder="Masukkan nomor KTP"
                                    >

                                </div>


                                <div class="col-md-6 mb-3">

                                    <label class="form-label">
                                        Foto KTP
                                    </label>

                                    <input
                                        type="file"
                                        name="foto_ktp"
                                        class="form-control"
                                        accept=".jpg,.jpeg,.png"
                                    >

                                    <small class="text-muted">
                                        JPG, JPEG atau PNG maksimal 4 MB.
                                    </small>

                                </div>


                                {{-- FOTO KTP YANG SUDAH ADA --}}
                                @if($ktp && $ktp->foto_ktp)

                                    <div class="col-md-6 mb-3">

                                        <label class="form-label">
                                            Foto KTP Saat Ini
                                        </label>

                                        <div>

                                            <img
                                                src="{{ asset('storage/' . $ktp->foto_ktp) }}"
                                                alt="Foto KTP"
                                                class="img-fluid rounded border shadow-sm"
                                                style="max-width: 400px;"
                                            >

                                        </div>

                                    </div>

                                @endif


                                {{-- STATUS KTP --}}
                                <div class="col-md-6 mb-3">

                                    <label class="form-label">
                                        Status Verifikasi
                                    </label>

                                    <div>

                                        @if(!$ktp)

                                            <span class="badge bg-secondary">
                                                Belum Upload
                                            </span>

                                        @elseif($ktp->status === 'Disetujui')

                                            <span class="badge bg-success">
                                                <i class="fas fa-check me-1"></i>
                                                Disetujui
                                            </span>

                                        @elseif($ktp->status === 'Ditolak')

                                            <span class="badge bg-danger">
                                                <i class="fas fa-times me-1"></i>
                                                Ditolak
                                            </span>

                                        @else

                                            <span class="badge bg-warning text-dark">
                                                <i class="fas fa-clock me-1"></i>
                                                Menunggu Verifikasi
                                            </span>

                                        @endif

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{-- TOMBOL SIMPAN --}}
            <div class="d-flex justify-content-end mt-4">

                <button
                    type="submit"
                    class="btn btn-primary"
                >
                    <i class="fas fa-save me-2"></i>
                    Simpan Biodata
                </button>

            </div>

        </form>

    </div>

</div>

@endsection