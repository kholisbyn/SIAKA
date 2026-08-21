<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AbsensiExport implements FromCollection, WithHeadings
{
    protected $absensis;
    protected $bulan;

    public function __construct($absensis, $bulan)
    {
        $this->absensis = $absensis;
        $this->bulan = $bulan;
    }

    public function collection()
    {
        return $this->absensis->map(function ($absensi, $index) {
            return [
                $index + 1,
                $absensi->karyawan->nama ?? '-',
                $absensi->karyawan->nik ?? '-',
                $absensi->karyawan->dataJabatan->jabatan ?? '-',
                $absensi->karyawan->dataJabatan->nama_pt ?? '-',
                $absensi->tanggal,
                $absensi->jam_masuk ?? '-',
                $absensi->jam_pulang ?? '-',
                $absensi->jam_masuk && $absensi->jam_pulang
                    ? 'Selesai'
                    : ($absensi->jam_masuk
                        ? 'Sedang Bekerja'
                        : 'Belum Absen'),
            ];
        });
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama Karyawan',
            'NIK',
            'Jabatan',
            'PT / Proyek',
            'Tanggal',
            'Jam Masuk',
            'Jam Pulang',
            'Status',
        ];
    }
}