@extends('layouts.admin')

@section('title','Data Jabatan')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <h2 class="fw-bold">
        <i class="fas fa-briefcase text-primary"></i>
        Data Jabatan
    </h2>

    <a href="{{ route('jabatan.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i>
        Tambah Jabatan
    </a>

</div>

<div class="card shadow-sm border-0">

    <div class="card-body">

        @if(session('success'))

            <div class="alert alert-success">

                {{ session('success') }}

            </div>

        @endif

        <div class="table-responsive">

            <table class="table table-bordered table-hover align-middle">

                <thead class="table-dark text-center">

                    <tr>

                        <th width="8%">No</th>

                        <th>Nama</th>

                        <th>Jabatan</th>

                        <th>Nama PT / Proyek</th>

                        <th width="18%">Aksi</th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($jabatans as $jabatan)

                    <tr>

                        <td class="text-center">

                            {{ $loop->iteration }}

                        </td>

                        <td>

                            {{ $jabatan->nama }}

                        </td>

                        <td>

                            {{ $jabatan->jabatan }}

                        </td>

                        <td>

                            {{ $jabatan->nama_pt }}

                        </td>

                        <td class="text-center">

                            <a href="{{ route('jabatan.show',$jabatan->id) }}" class="btn btn-info btn-sm">

                                <i class="fas fa-eye"></i>

                            </a>

                            <a href="{{ route('jabatan.edit',$jabatan->id) }}" class="btn btn-warning btn-sm">

                                <i class="fas fa-edit"></i>

                            </a>

                            <form action="{{ route('jabatan.destroy',$jabatan->id) }}"
                                  method="POST"
                                  style="display:inline-block;">

                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                        class="btn btn-danger btn-sm"
                                        onclick="return confirm('Yakin ingin menghapus data ini?')">

                                    <i class="fas fa-trash"></i>

                                </button>

                            </form>

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="5" class="text-center">

                            Belum ada data jabatan.

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        <div class="mt-3">

            {{ $jabatans->links() }}

        </div>

    </div>

</div>

@endsection