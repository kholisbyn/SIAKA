<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Karyawan;
use App\Models\LaporanPekerjaan;
use App\Models\LaporanPengeluaran;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\RekapExport;

class RekapController extends Controller
{
    public function index()
    {
        $ptProyeks = Karyawan::with('dataJabatan')
            ->get()
            ->map(function ($karyawan) {
                return $karyawan->dataJabatan->nama_pt ?? null;
            })
            ->filter()
            ->unique()
            ->values();

        return view(
            'admin.rekap.index',
            compact('ptProyeks')
        );
    }


    public function pekerjaan(Request $request)
    {
        $ptProyeks = Karyawan::with('dataJabatan')
            ->get()
            ->map(function ($karyawan) {
                return $karyawan->dataJabatan->nama_pt ?? null;
            })
            ->filter()
            ->unique()
            ->values();

        $laporan = LaporanPekerjaan::with([
            'user.karyawan.dataJabatan'
        ])
            ->when($request->pt_proyek, function ($query) use ($request) {
                $query->whereHas(
                    'user.karyawan.dataJabatan',
                    function ($q) use ($request) {
                        $q->where(
                            'nama_pt',
                            $request->pt_proyek
                        );
                    }
                );
            })
            ->latest()
            ->get();

        return view(
            'admin.rekap.pekerjaan',
            compact(
                'laporan',
                'ptProyeks'
            )
        );
    }


    public function pekerjaanPdf(Request $request)
    {
        $laporan = LaporanPekerjaan::with([
            'user.karyawan.dataJabatan'
        ])
            ->when($request->pt_proyek, function ($query) use ($request) {
                $query->whereHas(
                    'user.karyawan.dataJabatan',
                    function ($q) use ($request) {
                        $q->where(
                            'nama_pt',
                            $request->pt_proyek
                        );
                    }
                );
            })
            ->latest()
            ->get();

        $ptProyek = $request->pt_proyek
            ?: 'Semua PT / Proyek';

        $pdf = Pdf::loadView(
            'admin.rekap.pdf.pekerjaan',
            [
                'laporan' => $laporan,
                'ptProyek' => $ptProyek,
            ]
        );

        $pdf->setPaper(
            'A4',
            'landscape'
        );

        return $pdf->download(
            'rekap-laporan-pekerjaan-' .
            now()->format('Y-m-d') .
            '.pdf'
        );
    }


    public function keuangan(Request $request)
    {
        $ptProyeks = Karyawan::with('dataJabatan')
            ->get()
            ->map(function ($karyawan) {
                return $karyawan->dataJabatan->nama_pt ?? null;
            })
            ->filter()
            ->unique()
            ->values();

        $laporan = LaporanPengeluaran::with([
            'user.karyawan.dataJabatan',
            'detail'
        ])
            ->when($request->pt_proyek, function ($query) use ($request) {
                $query->whereHas(
                    'user.karyawan.dataJabatan',
                    function ($q) use ($request) {
                        $q->where(
                            'nama_pt',
                            $request->pt_proyek
                        );
                    }
                );
            })
            ->latest()
            ->get();

        return view(
            'admin.rekap.keuangan',
            compact(
                'laporan',
                'ptProyeks'
            )
        );
    }


    public function harian(Request $request)
    {
        $tanggal = $request->tanggal
            ?? now()->format('Y-m-d');

        $absensis = Absensi::with([
            'karyawan.dataJabatan'
        ])
            ->whereDate(
                'tanggal',
                $tanggal
            )
            ->when($request->pt_proyek, function ($query) use ($request) {
                $query->whereHas(
                    'karyawan.dataJabatan',
                    function ($q) use ($request) {
                        $q->where(
                            'nama_pt',
                            $request->pt_proyek
                        );
                    }
                );
            })
            ->latest()
            ->get();

        $ptProyeks = Karyawan::with('dataJabatan')
            ->get()
            ->map(function ($karyawan) {
                return $karyawan->dataJabatan->nama_pt ?? null;
            })
            ->filter()
            ->unique()
            ->values();

        return view(
            'admin.rekap.harian',
            compact(
                'absensis',
                'ptProyeks',
                'tanggal'
            )
        );
    }


    public function mingguan(Request $request)
    {
        $tanggal = $request->tanggal
            ? Carbon::parse($request->tanggal)
            : now();

        $tanggalMulai = $tanggal
            ->copy()
            ->startOfWeek();

        $tanggalAkhir = $tanggal
            ->copy()
            ->endOfWeek();

        $absensis = Absensi::with([
            'karyawan.dataJabatan'
        ])
            ->whereBetween(
                'tanggal',
                [
                    $tanggalMulai->format('Y-m-d'),
                    $tanggalAkhir->format('Y-m-d')
                ]
            )
            ->when($request->pt_proyek, function ($query) use ($request) {
                $query->whereHas(
                    'karyawan.dataJabatan',
                    function ($q) use ($request) {
                        $q->where(
                            'nama_pt',
                            $request->pt_proyek
                        );
                    }
                );
            })
            ->orderBy('tanggal')
            ->get();

        $ptProyeks = Karyawan::with('dataJabatan')
            ->get()
            ->map(function ($karyawan) {
                return $karyawan->dataJabatan->nama_pt ?? null;
            })
            ->filter()
            ->unique()
            ->values();

        return view(
            'admin.rekap.mingguan',
            compact(
                'absensis',
                'ptProyeks',
                'tanggal',
                'tanggalMulai',
                'tanggalAkhir'
            )
        );
    }


    public function bulanan(Request $request)
    {
        $bulan = $request->bulan
            ?? now()->format('Y-m');

        $tanggalBulan = Carbon::createFromFormat(
            'Y-m',
            $bulan
        );

        $absensis = Absensi::with([
            'karyawan.dataJabatan'
        ])
            ->whereYear(
                'tanggal',
                $tanggalBulan->year
            )
            ->whereMonth(
                'tanggal',
                $tanggalBulan->month
            )
            ->when($request->pt_proyek, function ($query) use ($request) {
                $query->whereHas(
                    'karyawan.dataJabatan',
                    function ($q) use ($request) {
                        $q->where(
                            'nama_pt',
                            $request->pt_proyek
                        );
                    }
                );
            })
            ->orderBy('tanggal')
            ->get();

        $ptProyeks = Karyawan::with('dataJabatan')
            ->get()
            ->map(function ($karyawan) {
                return $karyawan->dataJabatan->nama_pt ?? null;
            })
            ->filter()
            ->unique()
            ->values();

        return view(
            'admin.rekap.bulanan',
            compact(
                'absensis',
                'ptProyeks',
                'bulan'
            )
        );
    }


    public function exportExcel(Request $request)
    {
        $jenis = $request->jenis
            ?? 'pekerjaan';

        return Excel::download(
            new RekapExport(
                $jenis,
                $request->all()
            ),
            'rekap-' . $jenis . '.xlsx'
        );
    }


    public function exportPdf(Request $request)
    {
        $jenis = $request->jenis
            ?? 'pekerjaan';


        /*
        |--------------------------------------------------------------------------
        | PDF LAPORAN PEKERJAAN
        |--------------------------------------------------------------------------
        */

        if ($jenis === 'pekerjaan') {
            return $this->pekerjaanPdf($request);
        }


        /*
        |--------------------------------------------------------------------------
        | PDF LAPORAN KEUANGAN
        |--------------------------------------------------------------------------
        */

        if ($jenis === 'keuangan') {
            $laporan = LaporanPengeluaran::with([
                'user.karyawan.dataJabatan',
                'detail'
            ])
                ->when($request->pt_proyek, function ($query) use ($request) {
                    $query->whereHas(
                        'user.karyawan.dataJabatan',
                        function ($q) use ($request) {
                            $q->where(
                                'nama_pt',
                                $request->pt_proyek
                            );
                        }
                    );
                })
                ->latest()
                ->get();

            $pdf = Pdf::loadView(
                'admin.rekap.pdf.keuangan',
                [
                    'laporan' => $laporan,
                    'ptProyek' => $request->pt_proyek
                        ?: 'Semua PT / Proyek',
                ]
            );

            $pdf->setPaper(
                'A4',
                'landscape'
            );

            return $pdf->download(
                'rekap-laporan-keuangan-' .
                now()->format('Y-m-d') .
                '.pdf'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | PDF ABSENSI
        |--------------------------------------------------------------------------
        */

        if (in_array($jenis, [
            'harian',
            'mingguan',
            'bulanan'
        ])) {

            $data = [
                'jenis' => $jenis,
                'pt_proyek' => $request->pt_proyek,
            ];


            if ($jenis === 'harian') {

                $tanggal = $request->tanggal
                    ?? now()->format('Y-m-d');

                $data['tanggal'] = $tanggal;

                $data['absensis'] = Absensi::with([
                    'karyawan.dataJabatan'
                ])
                    ->whereDate(
                        'tanggal',
                        $tanggal
                    )
                    ->when($request->pt_proyek, function ($query) use ($request) {
                        $query->whereHas(
                            'karyawan.dataJabatan',
                            function ($q) use ($request) {
                                $q->where(
                                    'nama_pt',
                                    $request->pt_proyek
                                );
                            }
                        );
                    })
                    ->latest()
                    ->get();
            }


            if ($jenis === 'mingguan') {

                $tanggal = $request->tanggal
                    ? Carbon::parse($request->tanggal)
                    : now();

                $tanggalMulai = $tanggal
                    ->copy()
                    ->startOfWeek();

                $tanggalAkhir = $tanggal
                    ->copy()
                    ->endOfWeek();

                $data['tanggalMulai'] = $tanggalMulai;
                $data['tanggalAkhir'] = $tanggalAkhir;

                $data['absensis'] = Absensi::with([
                    'karyawan.dataJabatan'
                ])
                    ->whereBetween(
                        'tanggal',
                        [
                            $tanggalMulai->format('Y-m-d'),
                            $tanggalAkhir->format('Y-m-d')
                        ]
                    )
                    ->when($request->pt_proyek, function ($query) use ($request) {
                        $query->whereHas(
                            'karyawan.dataJabatan',
                            function ($q) use ($request) {
                                $q->where(
                                    'nama_pt',
                                    $request->pt_proyek
                                );
                            }
                        );
                    })
                    ->orderBy('tanggal')
                    ->get();
            }


            if ($jenis === 'bulanan') {

                $bulan = $request->bulan
                    ?? now()->format('Y-m');

                $tanggalBulan = Carbon::createFromFormat(
                    'Y-m',
                    $bulan
                );

                $data['bulan'] = $bulan;

                $data['absensis'] = Absensi::with([
                    'karyawan.dataJabatan'
                ])
                    ->whereYear(
                        'tanggal',
                        $tanggalBulan->year
                    )
                    ->whereMonth(
                        'tanggal',
                        $tanggalBulan->month
                    )
                    ->when($request->pt_proyek, function ($query) use ($request) {
                        $query->whereHas(
                            'karyawan.dataJabatan',
                            function ($q) use ($request) {
                                $q->where(
                                    'nama_pt',
                                    $request->pt_proyek
                                );
                            }
                        );
                    })
                    ->orderBy('tanggal')
                    ->get();
            }


            $pdf = Pdf::loadView(
                'admin.rekap.pdf.absensi',
                $data
            );

            $pdf->setPaper(
                'A4',
                'landscape'
            );

            return $pdf->download(
                'rekap-absensi-' .
                $jenis .
                '-' .
                now()->format('Y-m-d') .
                '.pdf'
            );
        }


        return back()->with(
            'error',
            'Jenis rekap tidak valid.'
        );
    }
}