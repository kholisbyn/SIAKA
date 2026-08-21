@extends('layouts.admin')

@section('title', 'Tambah User / Karyawan')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>
        <h2 class="mb-1">Tambah User / Karyawan</h2>
        <p class="text-muted mb-0">
            Tambahkan akun dan data karyawan baru
        </p>
    </div>

    <a href="{{ route('karyawan.index') }}" class="btn btn-secondary">
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

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="card shadow border-0">

    {{-- HEADER --}}
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">
            <i class="fas fa-user-plus me-2"></i>
            Data Karyawan
        </h5>
    </div>

    <div class="card-body">

        <form
            action="{{ route('karyawan.store') }}"
            method="POST"
            autocomplete="off"
        >

            @csrf

            {{-- ============================= --}}
            {{-- DATA KARYAWAN --}}
            {{-- ============================= --}}

            <h5 class="mb-3">
                <i class="fas fa-user me-2 text-primary"></i>
                Data Dasar
            </h5>

            <div class="row">

                {{-- NAMA --}}
                <div class="col-md-6 mb-3">

                    <label class="form-label">
                        Nama Lengkap
                    </label>

                    <input
                        type="text"
                        name="nama"
                        class="form-control"
                        value="{{ old('nama') }}"
                        placeholder="Masukkan nama lengkap"
                        autocomplete="off"
                        required
                    >

                </div>

                {{-- JABATAN --}}
                <div class="col-md-6 mb-3">

                    <label class="form-label">
                        Jabatan
                    </label>

                    <input
                        type="text"
                        name="jabatan"
                        class="form-control"
                        value="{{ old('jabatan') }}"
                        placeholder="Contoh: Operator"
                        autocomplete="off"
                        required
                    >

                </div>

                {{-- STATUS --}}
                <div class="col-md-6 mb-3">

                    <label class="form-label">
                        Status
                    </label>

                    <select
                        name="status"
                        class="form-select"
                        required
                    >

                        <option value="">
                            Pilih Status
                        </option>

                        <option
                            value="Aktif"
                            {{ old('status') === 'Aktif' ? 'selected' : '' }}
                        >
                            Aktif
                        </option>

                        <option
                            value="Nonaktif"
                            {{ old('status') === 'Nonaktif' ? 'selected' : '' }}
                        >
                            Nonaktif
                        </option>

                    </select>

                </div>

            </div>

            <hr class="my-4">

            {{-- ============================= --}}
            {{-- AKUN LOGIN --}}
            {{-- ============================= --}}

            <h5 class="mb-3">
                <i class="fas fa-sign-in-alt me-2 text-primary"></i>
                Akun Login
            </h5>

            <div class="row">

                {{-- USERNAME --}}
                <div class="col-md-6 mb-3">

                    <label class="form-label">
                        Username
                    </label>

                    <input
                        type="text"
                        name="username"
                        class="form-control"
                        value="{{ old('username') }}"
                        placeholder="Masukkan username"
                        autocomplete="off"
                        required
                    >

                </div>

                {{-- PASSWORD --}}
                <div class="col-md-6 mb-3">

                    <label class="form-label">
                        Password
                    </label>

                    <div class="input-group">

                        <input
                            type="password"
                            name="password"
                            id="password"
                            class="form-control"
                            placeholder="Masukkan password"
                            autocomplete="new-password"
                            required
                        >

                        <button
                            type="button"
                            class="btn btn-outline-secondary"
                            id="togglePassword"
                            title="Lihat password"
                        >
                            <i
                                class="fas fa-eye"
                                id="passwordIcon"
                            ></i>
                        </button>

                    </div>

                    <small class="text-muted">
                        Minimal 6 karakter.
                    </small>

                </div>

                {{-- ROLE --}}
                <div class="col-md-6 mb-3">

                    <label class="form-label">
                        Role
                    </label>

                    <select
                        name="role"
                        class="form-select"
                        required
                    >

                        <option value="">
                            Pilih Role
                        </option>

                        <option
                            value="admin"
                            {{ old('role') === 'admin' ? 'selected' : '' }}
                        >
                            Admin
                        </option>

                        <option
                            value="admin_lapangan"
                            {{ old('role') === 'admin_lapangan' ? 'selected' : '' }}
                        >
                            Admin Lapangan
                        </option>

                        <option
                            value="karyawan"
                            {{ old('role') === 'karyawan' ? 'selected' : '' }}
                        >
                            Karyawan
                        </option>

                    </select>

                </div>

            </div>

            {{-- ============================= --}}
            {{-- TOMBOL --}}
            {{-- ============================= --}}

            <div class="mt-4">

                <button
                    type="submit"
                    class="btn btn-primary"
                >
                    <i class="fas fa-save me-1"></i>
                    Simpan User
                </button>

                <a
                    href="{{ route('karyawan.index') }}"
                    class="btn btn-secondary"
                >
                    <i class="fas fa-times me-1"></i>
                    Batal
                </a>

            </div>

        </form>

    </div>

</div>

{{-- ============================= --}}
{{-- SCRIPT PASSWORD --}}
{{-- ============================= --}}

<script>
document.addEventListener('DOMContentLoaded', function () {

    const password = document.getElementById('password');
    const togglePassword = document.getElementById('togglePassword');
    const passwordIcon = document.getElementById('passwordIcon');

    if (password && togglePassword && passwordIcon) {

        togglePassword.addEventListener('click', function () {

            if (password.type === 'password') {

                password.type = 'text';

                passwordIcon.classList.remove('fa-eye');
                passwordIcon.classList.add('fa-eye-slash');

                togglePassword.title = 'Sembunyikan password';

            } else {

                password.type = 'password';

                passwordIcon.classList.remove('fa-eye-slash');
                passwordIcon.classList.add('fa-eye');

                togglePassword.title = 'Lihat password';

            }

        });

    }

});
</script>

@endsection