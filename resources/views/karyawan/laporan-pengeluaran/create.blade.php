@extends('layouts.karyawan')

@section('title','Buat Laporan Pengeluaran')

@section('content')

<div class="card shadow border-0">
    <div class="card-header bg-white">
        <h5 class="mb-0">Laporan Pengeluaran</h5>
    </div>

    <div class="card-body">

        <form method="POST" action="{{ route('karyawan.laporan-pengeluaran.store') }}">
            @csrf

            <div id="barang-container">

                <div class="row barang-item mb-3">
                    <div class="col-md-7">
                        <label class="form-label">Nama Barang</label>
                        <input
                            type="text"
                            name="barang[0][nama_barang]"
                            class="form-control"
                            placeholder="Contoh: Semen"
                            required>
                    </div>

                    <div class="col-md-5">
                        <label class="form-label">Nominal</label>
                        <input
                            type="number"
                            name="barang[0][nominal]"
                            class="form-control nominal"
                            placeholder="60000"
                            min="0"
                            required>
                    </div>
                </div>

            </div>

            <button type="button" id="tambah-barang" class="btn btn-outline-primary mb-4">
                <i class="fas fa-plus"></i> Tambah Barang
            </button>

            <div class="mb-3">
                <label for="keterangan" class="form-label">
                    Keterangan
                </label>

                <textarea
                    name="keterangan"
                    id="keterangan"
                    class="form-control"
                    rows="4"
                    placeholder="Contoh: Pembelian material untuk pekerjaan hari ini.">{{ old('keterangan') }}</textarea>
            </div>

            <div class="alert alert-light border">
                <strong>Total Pengeluaran:</strong>
                <span id="total">Rp 0</span>
            </div>

            @error('barang')
                <div class="text-danger mb-3">
                    {{ $message }}
                </div>
            @enderror

            <div class="d-flex gap-2">
                <a href="{{ route('karyawan.laporan-pengeluaran.index') }}" class="btn btn-secondary">
                    Kembali
                </a>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan Laporan
                </button>
            </div>

        </form>

    </div>
</div>

<script>
let index = 1;

document.getElementById('tambah-barang').addEventListener('click', function () {
    const container = document.getElementById('barang-container');

    const row = document.createElement('div');

    row.className = 'row barang-item mb-3';

    row.innerHTML = `
        <div class="col-md-7">
            <label class="form-label">Nama Barang</label>
            <input
                type="text"
                name="barang[${index}][nama_barang]"
                class="form-control"
                placeholder="Contoh: Pasir"
                required>
        </div>

        <div class="col-md-5">
            <label class="form-label">Nominal</label>
            <div class="input-group">
                <input
                    type="number"
                    name="barang[${index}][nominal]"
                    class="form-control nominal"
                    placeholder="150000"
                    min="0"
                    required>

                <button type="button" class="btn btn-danger hapus-barang">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        </div>
    `;

    container.appendChild(row);

    index++;

    hitungTotal();
});

document.addEventListener('input', function (e) {
    if (e.target.classList.contains('nominal')) {
        hitungTotal();
    }
});

document.addEventListener('click', function (e) {
    const button = e.target.closest('.hapus-barang');

    if (button) {
        button.closest('.barang-item').remove();
        hitungTotal();
    }
});

function hitungTotal() {
    let total = 0;

    document.querySelectorAll('.nominal').forEach(function (input) {
        total += Number(input.value) || 0;
    });

    document.getElementById('total').textContent =
        'Rp ' + total.toLocaleString('id-ID');
}
</script>

@endsection