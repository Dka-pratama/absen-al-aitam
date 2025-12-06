<?php

use App\Http\Controllers\Admin\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CRUD\AbsensiCrud;
use App\Http\Controllers\CRUD\KelasCrud;
use App\Http\Controllers\CRUD\SiswaCrud;
use App\Http\Controllers\CRUD\TahunCrud;
use App\Http\Controllers\CRUD\WaliCrud;
use App\Http\Controllers\Admin\DashboardController;

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::resource('akun-siswa', SiswaCrud::class);
    Route::get('/siswa-search', [SiswaCrud::class, 'search'])->name('siswa.search');
    Route::resource('akun-walikelas', WaliCrud::class);
    Route::get('/wali-search', [WaliCrud::class, 'search']);
    Route::resource('kelas', KelasCrud::class);
    Route::post('/kelas/{id}/naik', [KelasCrud::class, 'naikkelas'])->name('kelas.naik');
    Route::get('/kelas-search', [KelasCrud::class, 'search'])->name('kelas.search');
    Route::resource('tahun', TahunCrud::class);
    // Aktif / Nonaktifkan tahun ajar
    Route::post('/tahun/{id}/activate', [TahunCrud::class, 'activate'])->name('tahun.activate');

    Route::post('/tahun/{id}/deactivate', [TahunCrud::class, 'deactivate'])->name('tahun.deactivate');
    Route::resource('absen', AbsensiCrud::class);
    // Export routes
    Route::get('/absen/{id}/export-excel', [AbsensiCrud::class, 'exportExcel'])->name('absen.export.excel');
    Route::get('/absen/{id}/export-pdf', [AbsensiCrud::class, 'exportPDF'])->name('absen.export.pdf');
    // PROFILE ADMIN
    Route::get('/admin/profile', [ProfileController::class, 'index'])->name('admin.profile');

    Route::get('/admin/profile/edit', [ProfileController::class, 'edit'])->name('admin.profile.edit');

    Route::post('/admin/profile/update', [ProfileController::class, 'update'])->name('admin.profile.update');

    Route::get('/admin/profile/password', [ProfileController::class, 'passwordForm'])->name('admin.profile.password');

    Route::post('/admin/profile/password', [ProfileController::class, 'changePassword'])->name(
        'admin.profile.password.update',
    );
});

require __DIR__ . '/auth.php';
