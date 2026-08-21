<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">

    <title>Rekap Absensi Bulanan</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
        }

        h2 {
            text-align: center;
            margin-bottom: 5px;
        }

        p {
            text-align: center;
            margin-top: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 7px;
        }

        th {
            background: #eeeeee;
            text-align: center;
        }
    </style>
</head>

<body>

    <h2>REKAP ABSENSI BULANAN</h2>

    <p>
        Periode:
        {{ \Carbon\Carbon::createFromFormat('Y-m', $bulan)->translatedFormat('F Y') }}
    </p>


    <div class="d-flex justify-content-end gap-2 mb-3">

    <a
        href="{{ route('admin.rekap.bulanan.pdf', request()->query()) }}"
        class="btn btn-danger"
    >
        <i class="fas fa-file-pdf me-2"></i>
        PDF
    </a>

    <a
        href="{{ route('admin.rekap.bulanan.excel', request()->query()) }}"
        class="btn btn-success"
    >
        <i class="fas fa-file-excel me-2"></i>
        Excel
    </a>

</div>

    <table>

        <thead>
            <tr>
                <th>No</th>
                <th>Nama Karyawan</th>
                <th>NIK</th>
                <th>Jabatan</th>
                <th>PT / Proyek</th>
                <th>Tanggal</th>
                <th>Jam Masuk</th>
                <th>Jam Pulang</th>
                <th>Status</th>
            </tr>
        </thead>

        <tbody>

            @forelse($absensis as $absensi)

                <tr>

                    <td>{{ $loop->iteration }}</td>

                    <td>
                        {{ $absensi->karyawan->nama ?? '-' }}
                    </td>

                    <td>
                        {{ $absensi->karyawan->nik ?? '-' }}
                    </td>

                    <td>
                        {{ $absensi->karyawan->dataJabatan->jabatan ?? '-' }}
                    </td>

                    <td>
                        {{ $absensi->karyawan->dataJabatan->nama_pt ?? '-' }}
                    </td>

                    <td>
                        {{ \Carbon\Carbon::parse($absensi->tanggal)->format('d-m-Y') }}
                    </td>

                    <td>
                        {{ $absensi->jam_masuk ?? '-' }}
                    </td>

                    <td>
                        {{ $absensi->jam_pulang ?? '-' }}
                    </td>

                    <td>
                        @if($absensi->jam_masuk && $absensi->jam_pulang)
                            Selesai
                        @elseif($absensi->jam_masuk)
                            Sedang Bekerja
                        @else
                            Belum Absen
                        @endif
                    </td>

                </tr>

            @empty

                <tr>
                    <td colspan="9" style="text-align:center;">
                        Tidak ada data absensi.
                    </td>
                </tr>

            @endforelse

        </tbody>

    </table>

</body>
</html>