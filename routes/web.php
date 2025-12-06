<?php

use App\Http\Controllers\ProfileController;
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
    Route::post('/kelas/{id}/naik', [KelasCrud::class, 'naikkelas'])
    ->name('kelas.naik');
    Route::get('/kelas-search', [KelasCrud::class, 'search'])->name('kelas.search');
    Route::resource('tahun', TahunCrud::class);
    Route::resource('absensi', AbsensiCrud::class);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
