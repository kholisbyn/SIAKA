<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <title>Rekap Laporan Pekerjaan</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
            color: #222;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h2 {
            margin: 0;
            font-size: 20px;
        }

        .header h3 {
            margin: 5px 0;
            font-size: 15px;
        }

        .header p {
            margin: 3px 0;
            color: #555;
        }

        .info {
            margin-bottom: 15px;
        }

        .info table {
            width: 100%;
            border: none;
        }

        .info td {
            border: none;
            padding: 3px;
        }

        table.data {
            width: 100%;
            border-collapse: collapse;
        }

        table.data th {
            background-color: #eeeeee;
            border: 1px solid #333;
            padding: 7px;
            text-align: center;
        }

        table.data td {
            border: 1px solid #333;
            padding: 6px;
            vertical-align: top;
        }

        .center {
            text-align: center;
        }

        .footer {
            margin-top: 20px;
            text-align: right;
            font-size: 10px;
            color: #555;
        }
    </style>
</head>

<body>

    <div class="header">

        <h2>REKAP LAPORAN PEKERJAAN</h2>

        <h3>SIAKA</h3>

        <p>Sistem Informasi Absensi Karyawan</p>

    </div>

    <div class="info">

        <table>

            <tr>
                <td width="20%">
                    <strong>PT / Proyek</strong>
                </td>

                <td>
                    : {{ $ptProyek }}
                </td>
            </tr>

            <tr>
                <td>
                    <strong>Tanggal Cetak</strong>
                </td>

                <td>
                    : {{ now()->format('d-m-Y H:i') }}
                </td>
            </tr>

            <tr>
                <td>
                    <strong>Total Laporan</strong>
                </td>

                <td>
                    : {{ $laporan->count() }} laporan
                </td>
            </tr>

        </table>

    </div>

    <table class="data">

        <thead>

            <tr>

                <th width="4%">
                    No
                </th>

                <th width="17%">
                    Nama Karyawan
                </th>

                <th width="15%">
                    PT / Proyek
                </th>

                <th width="12%">
                    Tanggal
                </th>

                <th width="47%">
                    Laporan Pekerjaan
                </th>

                <th width="5%">
                    Status
                </th>

            </tr>

        </thead>

        <tbody>

            @forelse($laporan as $item)

                <tr>

                    <td class="center">
                        {{ $loop->iteration }}
                    </td>

                    <td>

                        <strong>
                            {{ $item->user->karyawan->nama ?? $item->user->name ?? '-' }}
                        </strong>

                        @if(isset($item->user->karyawan->nik))

                            <br>

                            <small>
                                NIK: {{ $item->user->karyawan->nik }}
                            </small>

                        @endif

                    </td>

                    <td>

                        {{ $item->user->karyawan->dataJabatan->nama_pt ?? '-' }}

                    </td>

                    <td class="center">

                        @if($item->tanggal)

                            {{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}

                        @else

                            -

                        @endif

                    </td>

                    <td>

                        {{ $item->laporan ?? $item->deskripsi ?? $item->keterangan ?? '-' }}

                    </td>

                    <td class="center">

                        {{ $item->status ?? 'Selesai' }}

                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="6" class="center">

                        Tidak ada data laporan pekerjaan.

                    </td>

                </tr>

            @endforelse

        </tbody>

    </table>

    <div class="footer">

        Dicetak oleh Administrator
        <br>
        {{ now()->format('d-m-Y H:i:s') }}

    </div>

</body>

</html>