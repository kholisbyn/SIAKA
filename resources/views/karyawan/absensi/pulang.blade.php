@extends('layouts.karyawan')

@section('title', 'Absen Pulang')

@section('content')

<div class="row justify-content-center">

    <div class="col-lg-8">

        <div class="card shadow border-0">

            <div class="card-header bg-danger text-white">
                <h5 class="mb-0">
                    <i class="fas fa-camera me-2"></i>
                    Absen Pulang
                </h5>
            </div>

            <div class="card-body">

                <div class="text-center mb-4">

                    <h4>{{ $karyawan->nama }}</h4>

                    <p class="text-muted mb-1">
                        {{ now()->translatedFormat('d F Y') }}
                    </p>

                    <h3 id="jamSekarang" class="text-danger"></h3>

                </div>

                <form
                    action="{{ route('karyawan.absensi.simpan-pulang') }}"
                    method="POST"
                    id="formAbsensi"
                >

                    @csrf

                    <input type="hidden" name="foto" id="foto">
                    <input type="hidden" name="latitude" id="latitude">
                    <input type="hidden" name="longitude" id="longitude">

                    <div class="text-center">

                        <video
                            id="kamera"
                            autoplay
                            playsinline
                            class="img-fluid rounded border"
                            style="max-height:400px;width:100%;object-fit:cover;"
                        ></video>

                        <canvas
                            id="canvas"
                            style="display:none;"
                        ></canvas>

                    </div>

                    <div
                        id="status"
                        class="alert alert-info mt-3"
                    >
                        Menyiapkan kamera dan lokasi...
                    </div>

                    <button
                        type="button"
                        id="ambilFoto"
                        class="btn btn-danger w-100 mt-2"
                    >
                        <i class="fas fa-camera me-2"></i>
                        Ambil Foto & Absen Pulang
                    </button>

                </form>

            </div>

        </div>

    </div>

</div>

@endsection

@push('scripts')

<script>
document.addEventListener('DOMContentLoaded', function () {

    const video = document.getElementById('kamera');
    const canvas = document.getElementById('canvas');
    const foto = document.getElementById('foto');
    const latitude = document.getElementById('latitude');
    const longitude = document.getElementById('longitude');
    const status = document.getElementById('status');
    const button = document.getElementById('ambilFoto');
    const form = document.getElementById('formAbsensi');
    const jam = document.getElementById('jamSekarang');

    let lokasiSiap = false;
    let kameraSiap = false;

    function updateJam() {
        const sekarang = new Date();

        jam.textContent = sekarang.toLocaleTimeString('id-ID', {
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit'
        });
    }

    updateJam();
    setInterval(updateJam, 1000);

    navigator.mediaDevices.getUserMedia({
        video: {
            facingMode: 'user'
        },
        audio: false
    })
    .then(function (stream) {
        video.srcObject = stream;
        kameraSiap = true;

        status.textContent = 'Kamera siap. Mengambil lokasi...';
    })
    .catch(function () {
        status.className = 'alert alert-danger mt-3';
        status.textContent = 'Kamera tidak dapat digunakan.';
    });

    if (navigator.geolocation) {

        navigator.geolocation.getCurrentPosition(
            function (position) {

                latitude.value = position.coords.latitude;
                longitude.value = position.coords.longitude;

                lokasiSiap = true;

                status.className = 'alert alert-success mt-3';
                status.textContent = 'Kamera dan lokasi siap. Silakan ambil foto.';
            },
            function () {

                status.className = 'alert alert-danger mt-3';
                status.textContent = 'Lokasi tidak dapat diperoleh. Izinkan akses lokasi.';
            },
            {
                enableHighAccuracy: true,
                timeout: 10000,
                maximumAge: 0
            }
        );

    } else {

        status.className = 'alert alert-danger mt-3';
        status.textContent = 'Browser tidak mendukung GPS.';
    }

    button.addEventListener('click', function () {

        if (!kameraSiap) {
            alert('Kamera belum siap.');
            return;
        }

        if (!lokasiSiap) {
            alert('Lokasi belum tersedia.');
            return;
        }

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

        foto.value = canvas.toDataURL('image/jpeg', 0.85);

        button.disabled = true;
        button.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...';

        form.submit();
    });

});
</script>

@endpush