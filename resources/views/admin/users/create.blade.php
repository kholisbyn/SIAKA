@extends('layouts.admin')

@section('title','Tambah Akun')

@section('content')

<div class="card-header bg-primary text-white">
    <h5 class="mb-0">Tambah Akun</h5>
</div>

<div class="card-body">

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form
        action="{{ route('admin.users.store') }}"
        method="POST"
        autocomplete="off"
    >

        @csrf

        {{-- NAMA KARYAWAN --}}
        <div class="mb-3">

            <label class="form-label">
                Nama Karyawan
            </label>

            <input
                type="text"
                name="name"
                class="form-control"
                value="{{ old('name') }}"
                autocomplete="off"
                placeholder="Masukkan nama karyawan"
                required
            >

        </div>

        {{-- JABATAN --}}
        <div class="mb-3">

            <label class="form-label">
                Jabatan
            </label>

            <input
                type="text"
                name="jabatan"
                class="form-control"
                value="{{ old('jabatan') }}"
                autocomplete="off"
                placeholder="Contoh: Kepala Tukang"
                required
            >

        </div>

        {{-- STATUS --}}
        <div class="mb-3">

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

                <option value="Aktif">
                    Aktif
                </option>

                <option value="Nonaktif">
                    Nonaktif
                </option>

            </select>

        </div>

        <hr>

        {{-- AKUN LOGIN --}}
        <h5 class="mb-3">
            Akun Login
        </h5>

        {{-- USERNAME --}}
        <div class="mb-3">

            <label class="form-label">
                Username
            </label>

            <input
                type="text"
                name="username"
                class="form-control"
                value=""
                autocomplete="new-username"
                placeholder="Masukkan username"
                required
            >

        </div>

        {{-- PASSWORD --}}
        <div class="mb-3">

            <label class="form-label">
                Password
            </label>

            <div class="input-group">

                <input
                    type="password"
                    name="password"
                    id="password"
                    class="form-control"
                    value=""
                    autocomplete="new-password"
                    placeholder="Masukkan password"
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
        <div class="mb-4">

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

                <option value="admin">
                    Admin
                </option>

                <option value="admin_lapangan">
                    Admin Lapangan (Kepala Tukang)
                </option>

                <option value="karyawan">
                    Karyawan
                </option>

            </select>

        </div>

        {{-- TOMBOL --}}
        <button
            type="submit"
            class="btn btn-primary"
        >

            <i class="fas fa-save"></i>
            Simpan Akun

        </button>

        <a
            href="{{ route('admin.users.index') }}"
            class="btn btn-secondary"
        >

            Kembali

        </a>

    </form>

</div>


{{-- SCRIPT LIHAT / SEMBUNYIKAN PASSWORD --}}
<script>

document.addEventListener('DOMContentLoaded', function () {

    const password = document.getElementById('password');

    const togglePassword =
        document.getElementById('togglePassword');

    const passwordIcon =
        document.getElementById('passwordIcon');


    if (
        password &&
        togglePassword &&
        passwordIcon
    ) {

        togglePassword.addEventListener(
            'click',
            function () {

                if (password.type === 'password') {

                    password.type = 'text';

                    passwordIcon.classList.remove(
                        'fa-eye'
                    );

                    passwordIcon.classList.add(
                        'fa-eye-slash'
                    );

                    togglePassword.title =
                        'Sembunyikan password';

                } else {

                    password.type = 'password';

                    passwordIcon.classList.remove(
                        'fa-eye-slash'
                    );

                    passwordIcon.classList.add(
                        'fa-eye'
                    );

                    togglePassword.title =
                        'Lihat password';

                }

            }
        );

    }

});

</script>

@endsection