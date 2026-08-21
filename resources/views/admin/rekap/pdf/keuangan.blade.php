<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <title>Rekap Laporan Keuangan</title>

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

        .right {
            text-align: right;
        }

        .total {
            font-weight: bold;
            background-color: #eeeeee;
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

        <h2>REKAP LAPORAN KEUANGAN</h2>

        <h3>SIAKA</h3>

        <p>
            Sistem Informasi Absensi Karyawan
        </p>

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

                <th width="20%">
                    Keterangan
                </th>

                <th width="18%">
                    Nama Barang
                </th>

                <th width="12%">
                    Nominal
                </th>

                <th width="14%">
                    Tanggal
                </th>

            </tr>

        </thead>


        <tbody>

            @php
                $total = 0;
                $nomor = 1;
            @endphp


            @forelse($laporan as $item)

                @forelse($item->detail as $detail)

                    @php
                        $nominal = (float) ($detail->nominal ?? 0);
                        $total += $nominal;
                    @endphp

                    <tr>

                        <td class="center">
                            {{ $nomor++ }}
                        </td>

                        <td>

                            <strong>
                                {{ $item->user->karyawan->nama ?? $item->user->name ?? '-' }}
                            </strong>

                        </td>

                        <td>

                            {{ $item->user->karyawan->dataJabatan->nama_pt ?? '-' }}

                        </td>

                        <td>

                            {{ $item->keterangan ?? '-' }}

                        </td>

                        <td>

                            {{ $detail->nama_barang ?? '-' }}

                        </td>

                        <td class="right">

                            Rp
                            {{ number_format($nominal, 0, ',', '.') }}

                        </td>

                        <td class="center">

                            {{ $item->created_at
                                ? $item->created_at->format('d-m-Y H:i')
                                : '-' }}

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td class="center">
                            {{ $nomor++ }}
                        </td>

                        <td>

                            {{ $item->user->karyawan->nama ?? $item->user->name ?? '-' }}

                        </td>

                        <td>

                            {{ $item->user->karyawan->dataJabatan->nama_pt ?? '-' }}

                        </td>

                        <td>

                            {{ $item->keterangan ?? '-' }}

                        </td>

                        <td colspan="3" class="center">

                            Tidak ada detail pengeluaran

                        </td>

                    </tr>

                @endforelse

            @empty

                <tr>

                    <td
                        colspan="7"
                        class="center"
                    >

                        Tidak ada data laporan keuangan.

                    </td>

                </tr>

            @endforelse


            <tr class="total">

                <td
                    colspan="5"
                    class="right"
                >

                    TOTAL PENGELUARAN

                </td>

                <td class="right">

                    Rp
                    {{ number_format($total, 0, ',', '.') }}

                </td>

                <td>

                </td>

            </tr>

        </tbody>

    </table>


    <div class="footer">

        Dicetak oleh Administrator

        <br>

        {{ now()->format('d-m-Y H:i:s') }}

    </div>

</body>

</html>