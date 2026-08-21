<?php

namespace App\Exports;

use App\Models\Absensi;
use App\Models\Karyawan;
use App\Models\LaporanPekerjaan;
use App\Models\LaporanPengeluaran;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RekapExport implements FromArray, WithHeadings
{
    protected string $jenis;
    protected array $filter;

    public function __construct(string $jenis, array $filter = [])
    {
        $this->jenis = $jenis;
        $this->filter = $filter;
    }

    public function headings(): array
    {
        if ($this->jenis === 'pekerjaan') {
            return [
                'No',
                'Nama Karyawan',
                'PT / Proyek',
                'Laporan Pekerjaan',
                'Tanggal',
            ];
        }

        if ($this->jenis === 'keuangan') {
            return [
                'No',
                'Nama Karyawan',
                'PT / Proyek',
                'Keterangan',
                'Nama Barang',
                'Nominal',
                'Tanggal',
            ];
        }

        return [
            'No',
            'Nama Karyawan',
            'PT / Proyek',
            'Tanggal',
            'Jam Masuk',
            'Jam Pulang',
            'Status',
        ];
    }

    public function array(): array
    {
        if ($this->jenis === 'pekerjaan') {
            return $this->pekerjaan();
        }

        if ($this->jenis === 'keuangan') {
            return $this->keuangan();
        }

        if ($this->jenis === 'harian') {
            return $this->absensiHarian();
        }

        if ($this->jenis === 'mingguan') {
            return $this->absensiMingguan();
        }

        if ($this->jenis === 'bulanan') {
            return $this->absensiBulanan();
        }

        return [];
    }

    protected function pekerjaan(): array
    {
        $laporan = LaporanPekerjaan::with([
            'user.karyawan.dataJabatan'
        ])
            ->when($this->filter['pt_proyek'] ?? null, function ($query, $pt) {
                $query->whereHas('user.karyawan.dataJabatan', function ($q) use ($pt) {
                    $q->where('nama_pt', $pt);
                });
            })
            ->latest()
            ->get();

        $rows = [];

        foreach ($laporan as $index => $item) {
            $rows[] = [
                $index + 1,
                $item->user->karyawan->nama ?? $item->user->name ?? '-',
                $item->user->karyawan->dataJabatan->nama_pt ?? '-',
                $item->isi_laporan ?? '-',
                $item->created_at
                    ? $item->created_at->format('d-m-Y H:i')
                    : '-',
            ];
        }

        return $rows;
    }

    protected function keuangan(): array
    {
        $laporan = LaporanPengeluaran::with([
            'user.karyawan.dataJabatan',
            'detail'
        ])
            ->when($this->filter['pt_proyek'] ?? null, function ($query, $pt) {
                $query->whereHas('user.karyawan.dataJabatan', function ($q) use ($pt) {
                    $q->where('nama_pt', $pt);
                });
            })
            ->latest()
            ->get();

        $rows = [];
        $no = 1;

        foreach ($laporan as $item) {
            foreach ($item->detail as $detail) {
                $rows[] = [
                    $no++,
                    $item->user->karyawan->nama ?? $item->user->name ?? '-',
                    $item->user->karyawan->dataJabatan->nama_pt ?? '-',
                    $item->keterangan ?? '-',
                    $detail->nama_barang ?? '-',
                    $detail->nominal ?? 0,
                    $item->created_at
                        ? $item->created_at->format('d-m-Y H:i')
                        : '-',
                ];
            }
        }

        return $rows;
    }

    protected function absensiHarian(): array
    {
        $tanggal = $this->filter['tanggal']
            ?? now()->format('Y-m-d');

        $absensis = Absensi::with([
            'karyawan.dataJabatan'
        ])
            ->whereDate('tanggal', $tanggal)
            ->when($this->filter['pt_proyek'] ?? null, function ($query, $pt) {
                $query->whereHas('karyawan.dataJabatan', function ($q) use ($pt) {
                    $q->where('nama_pt', $pt);
                });
            })
            ->latest()
            ->get();

        return $this->formatAbsensi($absensis);
    }

    protected function absensiMingguan(): array
    {
        $tanggal = !empty($this->filter['tanggal'])
            ? Carbon::parse($this->filter['tanggal'])
            : now();

        $tanggalMulai = $tanggal->copy()->startOfWeek();
        $tanggalAkhir = $tanggal->copy()->endOfWeek();

        $absensis = Absensi::with([
            'karyawan.dataJabatan'
        ])
            ->whereBetween('tanggal', [
                $tanggalMulai->format('Y-m-d'),
                $tanggalAkhir->format('Y-m-d')
            ])
            ->when($this->filter['pt_proyek'] ?? null, function ($query, $pt) {
                $query->whereHas('karyawan.dataJabatan', function ($q) use ($pt) {
                    $q->where('nama_pt', $pt);
                });
            })
            ->orderBy('tanggal')
            ->get();

        return $this->formatAbsensi($absensis);
    }

    protected function absensiBulanan(): array
    {
        $bulan = $this->filter['bulan']
            ?? now()->format('Y-m');

        $tanggalBulan = Carbon::createFromFormat('Y-m', $bulan);

        $absensis = Absensi::with([
            'karyawan.dataJabatan'
        ])
            ->whereYear('tanggal', $tanggalBulan->year)
            ->whereMonth('tanggal', $tanggalBulan->month)
            ->when($this->filter['pt_proyek'] ?? null, function ($query, $pt) {
                $query->whereHas('karyawan.dataJabatan', function ($q) use ($pt) {
                    $q->where('nama_pt', $pt);
                });
            })
            ->orderBy('tanggal')
            ->get();

        return $this->formatAbsensi($absensis);
    }

    protected function formatAbsensi($absensis): array
    {
        $rows = [];

        foreach ($absensis as $index => $absensi) {
            $status = '-';

            if ($absensi->jam_masuk && $absensi->jam_pulang) {
                $status = 'Selesai';
            } elseif ($absensi->jam_masuk) {
                $status = 'Sedang Bekerja';
            } else {
                $status = 'Belum Absen';
            }

            $rows[] = [
                $index + 1,
                $absensi->karyawan->nama ?? '-',
                $absensi->karyawan->dataJabatan->nama_pt ?? '-',
                $absensi->tanggal
                    ? Carbon::parse($absensi->tanggal)->format('d-m-Y')
                    : '-',
                $absensi->jam_masuk ?? '-',
                $absensi->jam_pulang ?? '-',
                $status,
            ];
        }

        return $rows;
    }
}