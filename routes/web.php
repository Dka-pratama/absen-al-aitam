<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Siswa\DashboardSiswaController;
use App\Http\Controllers\Admin\PromosiKelasController;
use App\Http\Controllers\Admin\AbsensiController as AdminAbsensiController;
use App\Http\Controllers\Wali\{
    DashboardWaliController,
    SiswaController,
    LaporanController,
    AbsenController,
    QrController,
    ProfileWaliController,
};
use App\Http\Controllers\CRUD\{LaporanCrud, KelasCrud, SiswaCrud, TahunCrud, WaliCrud};

Route::get('/', function () {
    if (auth()->check()) {
        if (auth()->user()->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        } elseif (auth()->user()->hasRole('wali')) {
            return redirect()->route('wali.dashboard');
        } elseif (auth()->user()->hasRole('siswa')) {
            return redirect()->route('siswa.dashboard');
        }
    }
    return redirect()->route('login'); // jika belum login
});

// ========== ADMIN ==========
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->group(function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

        Route::resource('akun-siswa', SiswaCrud::class);
        Route::get('siswa-search', [SiswaCrud::class, 'search'])->name('siswa.search');
        Route::get('siswa/import-export', [SiswaCrud::class, 'importExport'])->name('siswa.import.export');
        Route::get('siswa/template', [SiswaCrud::class, 'template'])->name('siswa.template');
        Route::get('siswa/export', [SiswaCrud::class, 'export'])->name('siswa.export');
        Route::post('siswa/import', [SiswaCrud::class, 'import'])->name('siswa.import');

        Route::get('/siswa/export-update', [SiswaCrud::class, 'exportUpdate'])->name('siswa.export-update');

        Route::post('/siswa/import-update', [SiswaCrud::class, 'importUpdate'])->name('siswa.import-update');

        Route::resource('akun-walikelas', WaliCrud::class);
        Route::get('wali-search', [WaliCrud::class, 'search'])->name('wali.search');

        Route::resource('kelas', KelasCrud::class);
        Route::post('kelas/{id}/naik', [KelasCrud::class, 'naikkelas'])->name('kelas.naik');
        Route::get('kelas-search', [KelasCrud::class, 'search'])->name('kelas.search');

        Route::resource('tahun', TahunCrud::class);
        Route::post('tahun/{id}/activate', [TahunCrud::class, 'activate'])->name('tahun.activate');
        Route::post('tahun/{id}/deactivate', [TahunCrud::class, 'deactivate'])->name('tahun.deactivate');

        Route::resource('laporan', LaporanCrud::class)->except(['show']);
        Route::get('laporan/detail', [LaporanCrud::class, 'detail'])->name('laporan.detail');

        Route::prefix('laporan')->group(function () {
            Route::get('export', [LaporanCrud::class, 'exportPage'])->name('laporan.export');

            Route::get('export-range/pdf', [LaporanCrud::class, 'exportRangePDF'])->name('laporan.export.range.pdf');

            Route::get('export-range/excel', [LaporanCrud::class, 'exportRangeExcel'])->name(
                'laporan.export.range.excel',
            );
        });

        Route::get('/naik-kelas', [PromosiKelasController::class, 'index'])->name('promosi.index');
        Route::post('/naik-kelas', [PromosiKelasController::class, 'store'])->name('promosi.store');
        Route::get('profile', [ProfileController::class, 'index'])->name('admin.profile');
        Route::get('profile/edit', [ProfileController::class, 'edit'])->name('admin.profile.edit');
        Route::post('profile/update', [ProfileController::class, 'update'])->name('admin.profile.update');
        Route::get('profile/password', [ProfileController::class, 'passwordForm'])->name('admin.profile.password');
        Route::post('profile/password', [ProfileController::class, 'changePassword'])->name(
            'admin.profile.password.update',
        );
        Route::get('/absensi/manual', [AdminAbsensiController::class, 'index'])->name('admin.absensi.manual');
        Route::post('/absensi/manual', [AdminAbsensiController::class, 'simpan'])->name('admin.absensi.manual.simpan');
        Route::post('/absensi-mandiri/toggle-global', [
            AdminAbsensiController::class,
            'toggleAbsensiMandiriGlobal',
        ])->name('admin.absensi.mandiri.global');
        Route::post('/absensi/lokasi', [AdminAbsensiController::class, 'simpanLokasiAbsensi'])->name(
            'admin.absensi.lokasi',
        );
        Route::get('absensi-search', [AdminAbsensiController::class, 'search'])->name('admin.absensi.search');
    });

// ========== WALI ==========
Route::middleware(['auth', 'role:wali'])
    ->prefix('wali')
    ->group(function () {
        Route::get('absensi', [AbsenController::class, 'index'])->name('wali.absensi');
        Route::post('absensi', [AbsenController::class, 'simpan'])->name('wali.absensi.simpan');
        Route::get('dashboard', [DashboardWaliController::class, 'index'])->name('wali.dashboard');
        Route::get('siswa', [SiswaController::class, 'index'])->name('wali.siswa.index');
        Route::get('laporan', [LaporanController::class, 'index'])->name('wali.laporan');
        Route::get('/laporan/detail', [LaporanController::class, 'laporanDetail'])->name('wali.laporan.detail');
        Route::prefix('laporan')->group(function () {
            Route::get('wali.laporan.export', [LaporanController::class, 'exportPage'])->name('wali.laporan.export');

            Route::get('export-range/pdf', [LaporanController::class, 'exportRangePDF'])->name(
                'wali.laporan.export.range.pdf',
            );

            Route::get('export-range/excel', [LaporanController::class, 'exportRangeExcel'])->name(
                'wali.laporan.export.range.excel',
            );
        });

    Route::get('wali.laporan.export', [LaporanController::class, 'exportPage'])->name('wali.laporan.export');

    Route::get('export-range/pdf', [LaporanController::class, 'exportRangePDF'])
        ->name('wali.laporan.export.range.pdf');

    Route::get('export-range/excel', [LaporanController::class, 'exportRangeExcel'])
        ->name('wali.laporan.export.range.excel');
});
        Route::get('absensi', [AbsenController::class, 'index'])->name('wali.absensi');
        Route::post('absensi', [AbsenController::class, 'simpan'])->name('wali.absensi.simpan');
        Route::post('/qr/generate', [QrController::class, 'generate'])->name('wali.qr.generate');
        Route::get('/profile', [ProfileWaliController::class, 'index'])->name('wali.profile');
        Route::post('/kelas/{kelasId}/toggle-mandiri', [
            App\Http\Controllers\Wali\AbsenController::class,
            'toggleAbsensiMandiri',
        ])->name('wali.toggleMandiri');
        Route::get('profile', [ProfileWaliController::class, 'index'])->name('wali.profile');
        Route::get('profile/edit', [ProfileWaliController::class, 'edit'])->name('wali.profile.edit');
        Route::post('profile/update', [ProfileWaliController::class, 'update'])->name('wali.profile.update');
        Route::get('profile/password', [ProfileWaliController::class, 'passwordForm'])->name('wali.profile.password');
        Route::post('profile/password', [ProfileWaliController::class, 'changePassword'])->name(
            'wali.profile.password.update',
        );
        Route::get('walikelas/siswa/export-excel/{wali}', [SiswaController::class, 'exportExcel'])->name(
            'siswa.export.excel',
        );
        Route::get('siswa/export/pdf', [SiswaController::class, 'exportPdf'])->name('siswa.export.pdf');
    });

// ========== SISWA ==========
Route::middleware(['auth', 'role:siswa'])
    ->prefix('siswa')
    ->group(function () {
        Route::get('dashboard', [DashboardSiswaController::class, 'index'])->name('siswa.dashboard');
        Route::get('rekap', [DashboardSiswaController::class, 'rekap'])->name('siswa.rekap');
        Route::post('/absen', [App\Http\Controllers\Siswa\AbsenController::class, 'absen'])->name('siswa.absen');
        Route::post('/scan', [App\Http\Controllers\Siswa\AbsenController::class, 'absen'])->name('siswa.scan');
        Route::post('/absen-mandiri', [App\Http\Controllers\Siswa\AbsenController::class, 'absenMandiri'])->name(
            'siswa.absenMandiri',
        );
    });

require __DIR__ . '/auth.php';
