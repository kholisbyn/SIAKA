@extends('layouts.admin')

@section('title', 'Edit Akun')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-1">Edit Akun</h2>
        <p class="text-muted mb-0">
            Kelola akun pengguna
        </p>
    </div>

    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i>
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

    <div class="card-header bg-white">
        <h5 class="mb-0">
            Data Akun
        </h5>
    </div>

    <div class="card-body">

        <form action="{{ route('admin.users.update', $user) }}" method="POST">

            @csrf
            @method('PUT')

            <div class="row">

                {{-- NAMA --}}
                <div class="col-md-6 mb-3">

                    <label class="form-label">
                        Nama
                    </label>

                    <input
                        type="text"
                        name="name"
                        class="form-control"
                        value="{{ old('name', $user->name) }}"
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
                        value="{{ old('jabatan', $user->karyawan?->dataJabatan?->jabatan) }}"
                        required
                    >

                </div>

                {{-- STATUS --}}
                <div class="col-md-6 mb-3">

                    <label class="form-label">
                        Status
                    </label>

                    <select name="status" class="form-select" required>

                        <option value="Aktif"
                            {{ old('status', $user->karyawan?->status) === 'Aktif' ? 'selected' : '' }}>
                            Aktif
                        </option>

                        <option value="Nonaktif"
                            {{ old('status', $user->karyawan?->status) === 'Nonaktif' ? 'selected' : '' }}>
                            Nonaktif
                        </option>

                    </select>

                </div>

                {{-- USERNAME --}}
                <div class="col-md-6 mb-3">

                    <label class="form-label">
                        Username
                    </label>

                    <input
                        type="text"
                        name="username"
                        class="form-control"
                        value="{{ old('username', $user->username) }}"
                        required
                    >

                </div>

                {{-- PASSWORD --}}
                <div class="col-md-6 mb-3">

                    <label class="form-label">
                        Password Baru
                    </label>

                    <div class="input-group">

                        <input
                            type="password"
                            name="password"
                            id="password"
                            class="form-control"
                            placeholder="Kosongkan jika tidak ingin mengubah"
                        >

                        <button
                            type="button"
                            class="btn btn-outline-secondary"
                            id="togglePassword"
                            title="Lihat password"
                        >
                            <i class="fas fa-eye" id="passwordIcon"></i>
                        </button>

                    </div>

                    <small class="text-muted">
                        Kosongkan jika tidak ingin mengubah password.
                    </small>

                </div>

                {{-- ROLE --}}
                <div class="col-md-6 mb-3">

                    <label class="form-label">
                        Role
                    </label>

                    <select name="role" class="form-select" required>

                        <option value="admin"
                            {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>
                            Admin
                        </option>

                        <option value="admin_lapangan"
                            {{ old('role', $user->role) === 'admin_lapangan' ? 'selected' : '' }}>
                            Admin Lapangan
                        </option>

                        <option value="karyawan"
                            {{ old('role', $user->role) === 'karyawan' ? 'selected' : '' }}>
                            Karyawan
                        </option>

                    </select>

                </div>

            </div>

            {{-- TOMBOL --}}
            <div class="mt-3">

                <button
                    type="submit"
                    class="btn btn-primary"
                >
                    <i class="fas fa-save me-1"></i>
                    Simpan Perubahan
                </button>

                <a
                    href="{{ route('admin.users.index') }}"
                    class="btn btn-secondary"
                >
                    <i class="fas fa-times me-1"></i>
                    Batal
                </a>

            </div>

        </form>

    </div>

</div>

{{-- JAVASCRIPT LIHAT / SEMBUNYIKAN PASSWORD --}}
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