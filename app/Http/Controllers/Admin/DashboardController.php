<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kelas;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $Header = 'Dashboard';
        $totalSiswa = User::where('role', 'siswa')->count();
        $totalKelas = Kelas::count();
        $totalWali = User::where('role', 'wali')->count();
        $totalAkun = User::count();
        $totalJurusan = Kelas::distinct('jurusan')->count('jurusan');
        return view(
            'admin.dashboard',
            compact('totalSiswa', 'totalKelas', 'totalWali', 'totalAkun', 'totalJurusan', 'Header'),
        );
    }
}
