<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <title>Rekap Absensi</title>

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
            vertical-align: middle;
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

        <h2>REKAP ABSENSI</h2>

        <h3>SIAKA</h3>

        <p>
            Sistem Informasi Absensi Karyawan
        </p>

    </div>


    <div class="info">

        <table>

            <tr>

                <td width="20%">
                    <strong>Jenis Rekap</strong>
                </td>

                <td>
                    :
                    @if($jenis === 'harian')
                        Harian
                    @elseif($jenis === 'mingguan')
                        Mingguan
                    @elseif($jenis === 'bulanan')
                        Bulanan
                    @else
                        Absensi
                    @endif
                </td>

            </tr>


            @if($jenis === 'harian')

                <tr>

                    <td>
                        <strong>Tanggal</strong>
                    </td>

                    <td>
                        :
                        {{ \Carbon\Carbon::parse($tanggal)->format('d-m-Y') }}
                    </td>

                </tr>

            @elseif($jenis === 'mingguan')

                <tr>

                    <td>
                        <strong>Periode</strong>
                    </td>

                    <td>
                        :
                        {{ $tanggalMulai->format('d-m-Y') }}
                        s/d
                        {{ $tanggalAkhir->format('d-m-Y') }}
                    </td>

                </tr>

            @elseif($jenis === 'bulanan')

                <tr>

                    <td>
                        <strong>Bulan</strong>
                    </td>

                    <td>
                        :
                        {{ \Carbon\Carbon::createFromFormat('Y-m', $bulan)->format('F Y') }}
                    </td>

                </tr>

            @endif


            <tr>

                <td>
                    <strong>PT / Proyek</strong>
                </td>

                <td>
                    :
                    {{ $pt_proyek ?: 'Semua PT / Proyek' }}
                </td>

            </tr>


            <tr>

                <td>
                    <strong>Total Data</strong>
                </td>

                <td>
                    :
                    {{ $absensis->count() }} data
                </td>

            </tr>


            <tr>

                <td>
                    <strong>Tanggal Cetak</strong>
                </td>

                <td>
                    :
                    {{ now()->format('d-m-Y H:i') }}
                </td>

            </tr>

        </table>

    </div>


    <table class="data">

        <thead>

            <tr>

                <th width="5%">
                    No
                </th>

                <th width="20%">
                    Nama Karyawan
                </th>

                <th width="17%">
                    PT / Proyek
                </th>

                <th width="13%">
                    Tanggal
                </th>

                <th width="12%">
                    Jam Masuk
                </th>

                <th width="12%">
                    Jam Pulang
                </th>

                <th width="21%">
                    Status
                </th>

            </tr>

        </thead>


        <tbody>

            @forelse($absensis as $absensi)

                <tr>

                    <td class="center">
                        {{ $loop->iteration }}
                    </td>


                    <td>

                        <strong>
                            {{ $absensi->karyawan->nama ?? '-' }}
                        </strong>

                        @if($absensi->karyawan->nik ?? null)

                            <br>

                            <small>
                                NIK:
                                {{ $absensi->karyawan->nik }}
                            </small>

                        @endif

                    </td>


                    <td>

                        {{ $absensi->karyawan->dataJabatan->nama_pt ?? '-' }}

                    </td>


                    <td class="center">

                        {{ \Carbon\Carbon::parse($absensi->tanggal)->format('d-m-Y') }}

                    </td>


                    <td class="center">

                        @if($absensi->jam_masuk)

                            {{ $absensi->jam_masuk }}

                        @else

                            -

                        @endif

                    </td>


                    <td class="center">

                        @if($absensi->jam_pulang)

                            {{ $absensi->jam_pulang }}

                        @else

                            -

                        @endif

                    </td>


                    <td class="center">

                        @if(
                            $absensi->jam_masuk &&
                            $absensi->jam_pulang
                        )

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

                    <td
                        colspan="7"
                        class="center"
                    >

                        Tidak ada data absensi.

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