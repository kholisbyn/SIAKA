@extends('layouts.admin')

@section('title', 'Admin')

@section('content')

<div class="card shadow border-0">

    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Manajemen Akun</h5>

        <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i>
            Tambah Akun
        </a>
    </div>

    <div class="card-body">

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <div class="table-responsive">

            <table class="table table-bordered table-hover">

                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Jabatan</th>
                        <th>Status</th>
                        <th>Username</th>
                        <th>Role</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($users as $user)

                        <tr>
                            <td>{{ $users->firstItem() + $loop->index }}</td>

                            <td>{{ $user->karyawan->nama ?? $user->name }}</td>

                            <td>
                                {{ $user->karyawan->dataJabatan->jabatan ?? '-' }}
                            </td>

                            <td>
                                {{ $user->karyawan->status ?? '-' }}
                            </td>

                            <td>{{ $user->username }}</td>

                            <td>
                                @if($user->role === 'admin')
                                    <span class="badge bg-primary">
                                        Admin
                                    </span>
                                @elseif($user->role === 'admin_lapangan')
                                    <span class="badge bg-warning text-dark">
                                        Admin Lapangan
                                    </span>
                                @else
                                    <span class="badge bg-success">
                                        Karyawan
                                    </span>
                                @endif
                            </td>

                            <td>
                                <a href="{{ route('admin.users.edit', $user->id) }}"
                                   class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>

                                @if($user->id !== auth()->id())

                                    <form action="{{ route('admin.users.destroy', $user->id) }}"
                                          method="POST"
                                          class="d-inline">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="btn btn-danger btn-sm"
                                                onclick="return confirm('Hapus akun ini?')">
                                            <i class="fas fa-trash"></i>
                                        </button>

                                    </form>

                                @endif

                            </td>
                        </tr>

                    @empty

                        <tr>
                            <td colspan="7" class="text-center">
                                Belum ada data akun.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        {{ $users->links() }}

    </div>

</div>

@endsection