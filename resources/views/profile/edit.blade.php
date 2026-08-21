@extends('layouts.karyawan')

@section('title', 'Profil Saya')

@section('content')

<div class="container-fluid">

    @if(session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
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

    <form action="{{ route('profile.update') }}"
          method="POST"
          enctype="multipart/form-data">

        @csrf
        @method('PATCH')

        <div class="row">

            <div class="col-md-4 mb-4">

                <div class="card shadow border-0">
                    <div class="card-body text-center">

                        @if($karyawan && $karyawan->foto)

                            <img src="{{ asset('uploads/karyawan/'.$karyawan->foto) }}"
                                 class="rounded-circle mb-3"
                                 style="width:140px;height:140px;object-fit:cover;">

                        @else

                            <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=2563EB&color=fff"
                                 class="rounded-circle mb-3"
                                 style="width:140px;height:140px;">

                        @endif

                        <h5>{{ $user->name }}</h5>

                        <p class="text-muted mb-1">
                            {{ $karyawan?->dataJabatan?->jabatan ?? 'Belum ditentukan' }}
                        </p>

                        <span class="badge bg-success">
                            {{ $karyawan?->status ?? 'Aktif' }}
                        </span>

                        <hr>

                        <div class="text-start">

                            <label class="form-label">
                                Foto Profil
                            </label>

                            <input type="file"
                                   name="foto"
                                   class="form-control"
                                   accept="image/jpeg,image/png">

                        </div>

                    </div>
                </div>

            </div>

            <div class="col-md-8">

                <div class="card shadow border-0 mb-4">

                    <div class="card-header bg-white">
                        <h5 class="mb-0">
                            Data Pribadi
                        </h5>
                    </div>

                    <div class="card-body">

                        <div class="row">

                            <div class="col-md-6 mb-3">

                                <label class="form-label">
                                    Nama
                                </label>

                                <input type="text"
                                       name="name"
                                       class="form-control"
                                       value="{{ old('name', $karyawan?->nama ?? $user->name) }}"
                                       required>

                            </div>

                            <div class="col-md-6 mb-3">

                                <label class="form-label">
                                    Email
                                </label>

                                <input type="email"
                                       name="email"
                                       class="form-control"
                                       value="{{ old('email', $user->email) }}"
                                       required>

                            </div>

                            <div class="col-md-6 mb-3">

                                <label class="form-label">
                                    NIK
                                </label>

                                <input type="text"
                                       name="nik"
                                       class="form-control"
                                       value="{{ old('nik', $karyawan?->nik) }}">

                            </div>

                            <div class="col-md-6 mb-3">

                                <label class="form-label">
                                    Tempat Lahir
                                </label>

                                <input type="text"
                                       name="tempat_lahir"
                                       class="form-control"
                                       value="{{ old('tempat_lahir', $karyawan?->tempat_lahir) }}">

                            </div>

                            <div class="col-md-6 mb-3">

                                <label class="form-label">
                                    Tanggal Lahir
                                </label>

                                <input type="date"
                                       name="tanggal_lahir"
                                       class="form-control"
                                       value="{{ old('tanggal_lahir', $karyawan?->tanggal_lahir) }}">

                            </div>

                            <div class="col-md-6 mb-3">

                                <label class="form-label">
                                    Jenis Kelamin
                                </label>

                                <select name="jenis_kelamin"
                                        class="form-select">

                                    <option value="">
                                        Pilih Jenis Kelamin
                                    </option>

                                    <option value="Laki-laki"
                                        {{ old('jenis_kelamin', $karyawan?->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>
                                        Laki-laki
                                    </option>

                                    <option value="Perempuan"
                                        {{ old('jenis_kelamin', $karyawan?->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>
                                        Perempuan
                                    </option>

                                </select>

                            </div>

                            <div class="col-md-6 mb-3">

                                <label class="form-label">
                                    No. HP
                                </label>

                                <input type="text"
                                       name="no_hp"
                                       class="form-control"
                                       value="{{ old('no_hp', $karyawan?->no_hp) }}">

                            </div>

                            <div class="col-md-6 mb-3">

                                <label class="form-label">
                                    Jabatan
                                </label>

                                <input type="text"
                                       class="form-control"
                                       value="{{ $karyawan?->dataJabatan?->jabatan ?? 'Belum ditentukan' }}"
                                       readonly>

                            </div>

                            <div class="col-md-12 mb-3">

                                <label class="form-label">
                                    Alamat
                                </label>

                                <textarea name="alamat"
                                          class="form-control"
                                          rows="3">{{ old('alamat', $karyawan?->alamat) }}</textarea>

                            </div>

                        </div>

                    </div>

                </div>

                <div class="card shadow border-0 mb-4">

                    <div class="card-header bg-white">
                        <h5 class="mb-0">
                            Verifikasi KTP
                        </h5>
                    </div>

                    <div class="card-body">

                        <div class="mb-3">

                            <label class="form-label">
                                Nomor KTP
                            </label>

                            <input type="text"
                                   name="nomor_ktp"
                                   class="form-control"
                                   value="{{ old('nomor_ktp', $ktp?->nomor_ktp) }}">

                        </div>

                        <div class="mb-3">

                            <label class="form-label">
                                Foto KTP
                            </label>

                            <input type="file"
                                   name="foto_ktp"
                                   class="form-control"
                                   accept="image/jpeg,image/png">

                        </div>

                        @if($ktp && $ktp->foto_ktp)

                            <div class="mb-3">

                                <label class="form-label">
                                    KTP Saat Ini
                                </label>

                                <br>

                                <img src="{{ asset('uploads/ktp/'.$ktp->foto_ktp) }}"
                                     class="img-fluid rounded border"
                                     style="max-width:400px;">

                            </div>

                        @endif

                        <div>

                            <label class="form-label">
                                Status Verifikasi
                            </label>

                            @if(!$ktp)

                                <span class="badge bg-secondary">
                                    Belum Upload
                                </span>

                            @elseif($ktp->status === 'Disetujui')

                                <span class="badge bg-success">
                                    Disetujui
                                </span>

                            @elseif($ktp->status === 'Ditolak')

                                <span class="badge bg-danger">
                                    Ditolak
                                </span>

                            @else

                                <span class="badge bg-warning text-dark">
                                    Menunggu Verifikasi
                                </span>

                            @endif

                        </div>

                    </div>

                </div>

                <div class="text-end mb-4">

                    <button type="submit"
                            class="btn btn-primary">

                        <i class="fas fa-save"></i>
                        Simpan Profil

                    </button>

                </div>

            </div>

        </div>

    </form>

</div>

@endsection