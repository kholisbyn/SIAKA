@extends('layouts.karyawan')

@section('title', 'Absen Masuk')

@section('content')

<div class="row justify-content-center">
    <div class="col-lg-8 col-xl-7">

        <div class="card border-0 shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">
                    <i class="fas fa-camera me-2"></i>
                    Absen Masuk
                </h5>
            </div>

            <div class="card-body">

                <div class="text-center mb-4">
                    <h5>{{ $karyawan->nama }}</h5>

                    @if($karyawan->dataJabatan)
                        <p class="text-muted mb-0">
                            {{ $karyawan->dataJabatan->jabatan }}
                        </p>
                    @endif
                </div>

                <div class="camera-wrapper mb-3">
                    <video
                        id="camera"
                        autoplay
                        playsinline
                        muted
                    ></video>

                    <canvas id="canvas"></canvas>
                </div>

                <div id="cameraMessage" class="alert alert-info text-center">
                    Izinkan kamera dan lokasi untuk melakukan absensi.
                </div>

                <div class="row g-3 mb-4">

                    <div class="col-md-4">
                        <div class="border rounded p-3 text-center">
                            <i class="fas fa-calendar-day text-primary fs-4"></i>
                            <div class="small text-muted mt-2">Tanggal</div>
                            <strong id="tanggal">-</strong>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="border rounded p-3 text-center">
                            <i class="fas fa-clock text-primary fs-4"></i>
                            <div class="small text-muted mt-2">Jam</div>
                            <strong id="jam">-</strong>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="border rounded p-3 text-center">
                            <i class="fas fa-location-dot text-primary fs-4"></i>
                            <div class="small text-muted mt-2">Lokasi</div>
                            <strong id="lokasi">Mencari...</strong>
                        </div>
                    </div>

                </div>

                <form
                    action="{{ route('karyawan.absensi.simpan-masuk') }}"
                    method="POST"
                    enctype="multipart/form-data"
                    id="absensiForm"
                >
                    @csrf

                    <input
                        type="hidden"
                        name="latitude_masuk"
                        id="latitude"
                    >

                    <input
                        type="hidden"
                        name="longitude_masuk"
                        id="longitude"
                    >

                    <input
                        type="hidden"
                        name="lokasi_masuk"
                        id="lokasiInput"
                    >

                    <input
                        type="file"
                        name="foto_masuk"
                        id="fotoInput"
                        accept="image/*"
                        capture="user"
                        hidden
                    >

                    <div class="d-grid">
                        <button
                            type="button"
                            class="btn btn-primary btn-lg"
                            id="ambilFoto"
                        >
                            <i class="fas fa-camera me-2"></i>
                            Ambil Foto & Absen
                        </button>
                    </div>

                </form>

            </div>
        </div>

    </div>
</div>

@endsection

@push('scripts')

<style>
    .camera-wrapper {
        width: 100%;
        background: #111827;
        border-radius: 15px;
        overflow: hidden;
        position: relative;
        min-height: 300px;
    }

    #camera {
        width: 100%;
        display: block;
        max-height: 500px;
        object-fit: cover;
    }

    #canvas {
        display: none;
    }

    #ambilFoto {
        min-height: 55px;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const camera = document.getElementById('camera');
    const canvas = document.getElementById('canvas');
    const form = document.getElementById('absensiForm');
    const fotoInput = document.getElementById('fotoInput');
    const ambilFoto = document.getElementById('ambilFoto');
    const cameraMessage = document.getElementById('cameraMessage');

    const latitude = document.getElementById('latitude');
    const longitude = document.getElementById('longitude');
    const lokasi = document.getElementById('lokasi');
    const lokasiInput = document.getElementById('lokasiInput');

    let stream = null;
    let lokasiSiap = false;

    function tampilkanWaktu() {
        const sekarang = new Date();

        const tanggal = sekarang.toLocaleDateString('id-ID', {
            day: '2-digit',
            month: '2-digit',
            year: 'numeric'
        });

        const jam = sekarang.toLocaleTimeString('id-ID', {
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit'
        });

        document.getElementById('tanggal').textContent = tanggal;
        document.getElementById('jam').textContent = jam;
    }

    tampilkanWaktu();

    setInterval(tampilkanWaktu, 1000);

    async function bukaKamera() {
        try {
            stream = await navigator.mediaDevices.getUserMedia({
                video: {
                    facingMode: 'user',
                    width: {
                        ideal: 1280
                    },
                    height: {
                        ideal: 720
                    }
                },
                audio: false
            });

            camera.srcObject = stream;

            cameraMessage.className = 'alert alert-success text-center';
            cameraMessage.textContent = 'Kamera aktif. Pastikan wajah terlihat jelas.';

        } catch (error) {
            cameraMessage.className = 'alert alert-danger text-center';
            cameraMessage.textContent = 'Kamera tidak dapat digunakan. Izinkan akses kamera pada browser.';
        }
    }

    function ambilLokasi() {
        if (!navigator.geolocation) {
            cameraMessage.className = 'alert alert-danger text-center';
            cameraMessage.textContent = 'Browser tidak mendukung GPS.';
            return;
        }

        navigator.geolocation.getCurrentPosition(
            function (position) {

                const lat = position.coords.latitude;
                const lng = position.coords.longitude;

                latitude.value = lat;
                longitude.value = lng;

                lokasi.textContent =
                    lat.toFixed(6) + ', ' + lng.toFixed(6);

                lokasiInput.value =
                    'Latitude: ' + lat +
                    ', Longitude: ' + lng;

                lokasiSiap = true;

            },
            function () {

                lokasi.textContent = 'GPS tidak tersedia';

                cameraMessage.className = 'alert alert-danger text-center';
                cameraMessage.textContent =
                    'Lokasi wajib diaktifkan untuk melakukan absensi.';

            },
            {
                enableHighAccuracy: true,
                timeout: 10000,
                maximumAge: 0
            }
        );
    }

    ambilFoto.addEventListener('click', function () {

        if (!lokasiSiap) {
            alert('Tunggu sampai lokasi GPS berhasil ditemukan.');
            return;
        }

        if (!stream) {
            alert('Kamera belum aktif.');
            return;
        }

        canvas.width = camera.videoWidth;
        canvas.height = camera.videoHeight;

        const context = canvas.getContext('2d');

        context.drawImage(
            camera,
            0,
            0,
            canvas.width,
            canvas.height
        );

        canvas.toBlob(function (blob) {

            const file = new File(
                [blob],
                'absen-masuk-' + Date.now() + '.jpg',
                {
                    type: 'image/jpeg'
                }
            );

            const dataTransfer = new DataTransfer();

            dataTransfer.items.add(file);

            fotoInput.files = dataTransfer.files;

            ambilFoto.disabled = true;
            ambilFoto.innerHTML =
                '<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan Absensi...';

            if (stream) {
                stream.getTracks().forEach(function (track) {
                    track.stop();
                });
            }

            form.submit();

        }, 'image/jpeg', 0.85);
    });

    bukaKamera();
    ambilLokasi();

});
</script>

@endpush