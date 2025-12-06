<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Wali\DashboardWaliController;
use App\Http\Controllers\Siswa\DashboardSiswaController; // controller siswa
use App\Http\Controllers\CRUD\{AbsensiCrud, KelasCrud, SiswaCrud, TahunCrud, WaliCrud};

// ========== ADMIN ==========
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    Route::resource('akun-siswa', SiswaCrud::class);
    Route::get('siswa-search', [SiswaCrud::class, 'search'])->name('siswa.search');

    Route::resource('akun-walikelas', WaliCrud::class);
    Route::get('wali-search', [WaliCrud::class, 'search'])->name('wali.search');

    Route::resource('kelas', KelasCrud::class);
    Route::post('kelas/{id}/naik', [KelasCrud::class, 'naikkelas'])->name('kelas.naik');
    Route::get('kelas-search', [KelasCrud::class, 'search'])->name('kelas.search');

    Route::resource('tahun', TahunCrud::class);
    Route::post('tahun/{id}/activate', [TahunCrud::class, 'activate'])->name('tahun.activate');
    Route::post('tahun/{id}/deactivate', [TahunCrud::class, 'deactivate'])->name('tahun.deactivate');

    Route::resource('absen', AbsensiCrud::class);
    Route::prefix('absen')->group(function () {
        Route::get('{id}/export-excel', [AbsensiCrud::class, 'exportExcel'])->name('absen.export.excel');
        Route::get('{id}/export-pdf', [AbsensiCrud::class, 'exportPDF'])->name('absen.export.pdf');
    });

    // Profile
    Route::get('profile', [ProfileController::class, 'index'])->name('admin.profile');
    Route::get('profile/edit', [ProfileController::class, 'edit'])->name('admin.profile.edit');
    Route::post('profile/update', [ProfileController::class, 'update'])->name('admin.profile.update');
    Route::get('profile/password', [ProfileController::class, 'passwordForm'])->name('admin.profile.password');
    Route::post('profile/password', [ProfileController::class, 'changePassword'])->name('admin.profile.password.update');
});

// ========== WALI ==========
Route::middleware(['auth', 'role:wali'])->prefix('wali')->group(function () {
    Route::get('dashboard', [DashboardWaliController::class, 'index'])->name('wali.dashboard');
});

// ========== SISWA ==========
// Route::middleware(['auth', 'role:siswa'])->prefix('siswa')->group(function () {
//     Route::get('dashboard', [DashboardSiswaController::class, 'index'])->name('siswa.dashboard');
// });

require __DIR__.'/auth.php';
