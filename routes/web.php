<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\Admin\BackupController;

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\KaryawanController;
use App\Http\Controllers\Admin\JabatanController;
use App\Http\Controllers\Admin\KtpController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RekapController;
use App\Http\Controllers\Admin\BiodataController as AdminBiodataController;

use App\Http\Controllers\Karyawan\DashboardController as KaryawanDashboardController;
use App\Http\Controllers\Karyawan\LaporanPekerjaanController;
use App\Http\Controllers\Karyawan\LaporanPengeluaranController;
use App\Http\Controllers\Karyawan\ProfileController as KaryawanProfileController;
use App\Http\Controllers\Karyawan\BiodataController as KaryawanBiodataController;

use App\Models\LaporanPekerjaan;
use App\Models\LaporanPengeluaran;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth'])->group(function () {

Route::get('/admin/pengaturan', function () {
    return view('admin.pengaturan');
})->name('admin.pengaturan');

    Route::post('/admin/pengaturan/backup', [
        BackupController::class,
        'backup'
    ])->name('admin.backup');

    Route::get('/dashboard', [
        DashboardController::class,
        'index'
    ])->name('dashboard');

    Route::get('/admin/rekap', [
        RekapController::class,
        'index'
    ])->name('admin.rekap.index');

    Route::get('/admin/rekap/pekerjaan', [
        RekapController::class,
        'pekerjaan'
    ])->name('admin.rekap.pekerjaan');

    Route::get('/admin/rekap/keuangan', [
        RekapController::class,
        'keuangan'
    ])->name('admin.rekap.keuangan');

    Route::get('/admin/rekap/harian', [
        RekapController::class,
        'harian'
    ])->name('admin.rekap.harian');

    Route::get('/admin/rekap/mingguan', [
        RekapController::class,
        'mingguan'
    ])->name('admin.rekap.mingguan');

    Route::get('/admin/rekap/bulanan', [
        RekapController::class,
        'bulanan'
    ])->name('admin.rekap.bulanan');

    Route::get('/admin/rekap/export/excel', [
        RekapController::class,
        'exportExcel'
    ])->name('admin.rekap.export.excel');

    Route::get('/admin/rekap/export/pdf', [
        RekapController::class,
        'exportPdf'
    ])->name('admin.rekap.export.pdf');

    Route::get('/admin/rekap/pekerjaan/pdf', [
        RekapController::class,
        'pekerjaanPdf'
    ])->name('admin.rekap.pekerjaan.pdf');

    Route::get('/admin/laporan', function () {
        return view('admin.laporan.index');
    })->name('admin.laporan.index');

    Route::get('/admin/laporan/pekerjaan', function () {

        $laporan = LaporanPekerjaan::with([
            'user.karyawan.dataJabatan'
        ])
        ->latest()
        ->get();

        return view(
            'admin.laporan.pekerjaan',
            compact('laporan')
        );

    })->name('admin.laporan.pekerjaan');

    Route::delete('/admin/laporan/pekerjaan/{laporan}', function (
        LaporanPekerjaan $laporan
    ) {

        $laporan->delete();

        return back()->with(
            'success',
            'Laporan pekerjaan berhasil dihapus.'
        );

    })->name('admin.laporan.pekerjaan.delete');

    Route::get('/admin/laporan/keuangan', function () {

        $laporan = LaporanPengeluaran::with([
            'user.karyawan.dataJabatan',
            'detail'
        ])
        ->latest()
        ->get();

        return view(
            'admin.laporan.keuangan',
            compact('laporan')
        );

    })->name('admin.laporan.keuangan');

    Route::delete('/admin/laporan/keuangan/{laporan}', function (
        LaporanPengeluaran $laporan
    ) {

        $laporan->detail()->delete();
        $laporan->delete();

        return back()->with(
            'success',
            'Laporan keuangan berhasil dihapus.'
        );

    })->name('admin.laporan.keuangan.delete');

    Route::get('/karyawan/dashboard', [
        KaryawanDashboardController::class,
        'index'
    ])->name('karyawan.dashboard');

    Route::get('/karyawan/absensi/masuk', [
        AbsensiController::class,
        'masuk'
    ])->name('karyawan.absensi.masuk');

    Route::post('/karyawan/absensi/masuk', [
        AbsensiController::class,
        'simpanMasuk'
    ])->name('karyawan.absensi.simpan-masuk');

    Route::get('/karyawan/absensi/pulang', [
        AbsensiController::class,
        'pulang'
    ])->name('karyawan.absensi.pulang');

    Route::post('/karyawan/absensi/pulang', [
        AbsensiController::class,
        'simpanPulang'
    ])->name('karyawan.absensi.simpan-pulang');

    Route::get('/karyawan/biodata', [
        KaryawanBiodataController::class,
        'edit'
    ])->name('karyawan.biodata.edit');

    Route::put('/karyawan/biodata', [
        KaryawanBiodataController::class,
        'update'
    ])->name('karyawan.biodata.update');

    Route::get('/karyawan/profile', [
        KaryawanProfileController::class,
        'edit'
    ])->name('karyawan.profile');

    Route::patch('/karyawan/profile', [
        KaryawanProfileController::class,
        'update'
    ])->name('karyawan.profile.update');

    Route::resource(
        'karyawan/laporan-pekerjaan',
        LaporanPekerjaanController::class
    )
    ->names('karyawan.laporan-pekerjaan')
    ->only([
        'index',
        'create',
        'store'
    ]);

    Route::resource(
        'karyawan/laporan-pengeluaran',
        LaporanPengeluaranController::class
    )
    ->names('karyawan.laporan-pengeluaran')
    ->only([
        'index',
        'create',
        'store'
    ]);

    Route::resource(
        'admin/users',
        UserController::class
    )
    ->names('admin.users')
    ->only([
        'index',
        'create',
        'store',
        'edit',
        'update',
        'destroy'
    ]);

    Route::get('/admin/biodata', [
        AdminBiodataController::class,
        'index'
    ])->name('admin.biodata.index');

    Route::get('/admin/biodata/{karyawan}', [
        AdminBiodataController::class,
        'show'
    ])->name('admin.biodata.show');

    Route::get('/admin/biodata/{karyawan}/edit', [
        AdminBiodataController::class,
        'edit'
    ])->name('admin.biodata.edit');

    Route::put('/admin/biodata/{karyawan}', [
        AdminBiodataController::class,
        'update'
    ])->name('admin.biodata.update');

    Route::delete('/admin/biodata/{karyawan}', [
        AdminBiodataController::class,
        'destroy'
    ])->name('admin.biodata.destroy');

    Route::get('/admin/verifikasi-ktp', [
        KtpController::class,
        'index'
    ])->name('admin.ktp.index');

    Route::patch('/admin/verifikasi-ktp/{ktp}', [
        KtpController::class,
        'update'
    ])->name('admin.ktp.update');

    Route::resource(
        'jabatan',
        JabatanController::class
    );

    Route::resource(
        'karyawan',
        KaryawanController::class
    );

    Route::resource(
        'absensi',
        AbsensiController::class
    );

    Route::get('/profile', [
        ProfileController::class,
        'edit'
    ])->name('profile.edit');

    Route::patch('/profile', [
        ProfileController::class,
        'update'
    ])->name('profile.update');

    Route::delete('/profile', [
        ProfileController::class,
        'destroy'
    ])->name('profile.destroy');
});

require __DIR__.'/auth.php';