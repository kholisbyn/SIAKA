@extends('layouts.karyawan')

@section('title', 'Absen Masuk')

@section('content')

<div class="row justify-content-center">

    <div class="col-lg-7 col-md-9">

        <div class="card border-0 shadow-sm">

            <div class="card-header bg-primary text-white p-4">
                <h4 class="mb-0">
                    <i class="fas fa-camera me-2"></i>
                    Absen Masuk
                </h4>
            </div>

            <div class="card-body p-4">

                <div class="text-center mb-4">

                    <h5 class="fw-bold">
                        {{ $karyawan->nama }}
                    </h5>

                    <p class="text-muted mb-1">
                        {{ now()->translatedFormat('d F Y') }}
                    </p>

                    <h3 id="jamSekarang" class="text-primary fw-bold">
                        {{ now()->format('H:i:s') }}
                    </h3>

                </div>

                <form
                    action="{{ route('karyawan.absensi.simpan-masuk') }}"
                    method="POST"
                    enctype="multipart/form-data"
                    id="formAbsensi"
                >

                    @csrf

                    <div class="mb-4">

                        <label class="form-label fw-bold">
                            Foto Absensi
                        </label>

                        <div class="text-center">

                            <video
                                id="camera"
                                autoplay
                                playsinline
                                class="w-100 rounded border"
                                style="max-height: 400px; object-fit: cover;"
                            ></video>

                            <canvas
                                id="canvas"
                                class="d-none"
                            ></canvas>

                            <img
                                id="preview"
                                class="img-fluid rounded border d-none mt-3"
                                style="max-height: 400px;"
                            >

                        </div>

                        <div class="d-flex justify-content-center gap-2 mt-3">

                            <button
                                type="button"
                                class="btn btn-primary"
                                id="ambilFoto"
                            >
                                <i class="fas fa-camera me-2"></i>
                                Ambil Foto
                            </button>

                            <button
                                type="button"
                                class="btn btn-secondary d-none"
                                id="ulangFoto"
                            >
                                <i class="fas fa-rotate-left me-2"></i>
                                Ambil Ulang
                            </button>

                        </div>

                        <input
                            type="hidden"
                            name="foto"
                            id="foto"
                        >

                    </div>

                    <div class="mb-4">

                        <label class="form-label fw-bold">
                            Lokasi
                        </label>

                        <div
                            id="statusLokasi"
                            class="alert alert-warning"
                        >
                            <i class="fas fa-location-dot me-2"></i>
                            Mengambil lokasi...
                        </div>

                        <input
                            type="hidden"
                            name="latitude"
                            id="latitude"
                        >

                        <input
                            type="hidden"
                            name="longitude"
                            id="longitude"
                        >

                    </div>

                    <div class="d-flex justify-content-between">

                        <a
                            href="{{ route('karyawan.dashboard') }}"
                            class="btn btn-secondary"
                        >
                            <i class="fas fa-arrow-left me-2"></i>
                            Kembali
                        </a>

                        <button
                            type="submit"
                            class="btn btn-success"
                            id="btnSimpan"
                            disabled
                        >
                            <i class="fas fa-check me-2"></i>
                            Simpan Absen
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</div>

@endsection

@push('scripts')

<script>

document.addEventListener('DOMContentLoaded', function () {

    const video = document.getElementById('camera');
    const canvas = document.getElementById('canvas');
    const preview = document.getElementById('preview');

    const ambilFoto = document.getElementById('ambilFoto');
    const ulangFoto = document.getElementById('ulangFoto');

    const foto = document.getElementById('foto');
    const btnSimpan = document.getElementById('btnSimpan');

    const latitude = document.getElementById('latitude');
    const longitude = document.getElementById('longitude');

    const statusLokasi = document.getElementById('statusLokasi');

    let stream = null;
    let fotoSudahDiambil = false;
    let lokasiSudahDidapat = false;

    function cekSiapSimpan() {

        if (fotoSudahDiambil && lokasiSudahDidapat) {
            btnSimpan.disabled = false;
        } else {
            btnSimpan.disabled = true;
        }

    }

    navigator.mediaDevices.getUserMedia({
        video: {
            facingMode: 'user'
        },
        audio: false
    })
    .then(function (cameraStream) {

        stream = cameraStream;

        video.srcObject = stream;

    })
    .catch(function () {

        alert('Kamera tidak dapat digunakan. Silakan izinkan akses kamera.');

    });

    ambilFoto.addEventListener('click', function () {

        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;

        const context = canvas.getContext('2d');

        context.drawImage(
            video,
            0,
            0,
            canvas.width,
            canvas.height
        );

        const fotoData = canvas.toDataURL('image/jpeg', 0.8);

        foto.value = fotoData;

        preview.src = fotoData;

        video.classList.add('d-none');

        preview.classList.remove('d-none');

        ambilFoto.classList.add('d-none');

        ulangFoto.classList.remove('d-none');

        fotoSudahDiambil = true;

        cekSiapSimpan();

    });

    ulangFoto.addEventListener('click', function () {

        video.classList.remove('d-none');

        preview.classList.add('d-none');

        ambilFoto.classList.remove('d-none');

        ulangFoto.classList.add('d-none');

        foto.value = '';

        fotoSudahDiambil = false;

        cekSiapSimpan();

    });

    if (navigator.geolocation) {

        navigator.geolocation.getCurrentPosition(

            function (position) {

                latitude.value = position.coords.latitude;
                longitude.value = position.coords.longitude;

                statusLokasi.className = 'alert alert-success';

                statusLokasi.innerHTML =
                    '<i class="fas fa-location-dot me-2"></i>' +
                    'Lokasi berhasil ditemukan';

                lokasiSudahDidapat = true;

                cekSiapSimpan();

            },

            function () {

                statusLokasi.className = 'alert alert-danger';

                statusLokasi.innerHTML =
                    '<i class="fas fa-location-dot me-2"></i>' +
                    'Lokasi tidak dapat ditemukan. Izinkan akses lokasi.';

            }

        );

    } else {

        statusLokasi.className = 'alert alert-danger';

        statusLokasi.innerHTML =
            'Browser tidak mendukung lokasi.';

    }

    function updateJam() {

        const sekarang = new Date();

        const jam = String(sekarang.getHours()).padStart(2, '0');
        const menit = String(sekarang.getMinutes()).padStart(2, '0');
        const detik = String(sekarang.getSeconds()).padStart(2, '0');

        document.getElementById('jamSekarang').textContent =
            jam + ':' + menit + ':' + detik;

    }

    setInterval(updateJam, 1000);

});

</script>

@endpush