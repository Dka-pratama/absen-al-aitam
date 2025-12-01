<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CRUD\AbsensiCrud;
use App\Http\Controllers\CRUD\KelasCrud;
use App\Http\Controllers\CRUD\SiswaCrud;
use App\Http\Controllers\CRUD\TahunCrud;
use App\Http\Controllers\CRUD\WaliCrud;
use App\Http\Controllers\Admin\DashboardController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::resource('akun-siswa', SiswaCrud::class);
    Route::resource('akun-walikelas', WaliCrud::class);
    Route::resource('kelas', KelasCrud::class);
    Route::resource('tahun-ajaran', TahunCrud::class);
    Route::resource('absensi', AbsensiCrud::class);
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
