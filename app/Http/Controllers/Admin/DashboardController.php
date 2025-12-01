<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\Wali;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $totalSiswa = Siswa::count();
        $totalKelas = Kelas::count();
        $totalWali = Wali::count();
        $totalAkun = User::count();
        $totalJurusan = Kelas::distinct('jurusan')->count('jurusan');
        return view('admin.dashboard', 
        compact('totalSiswa', 
        'totalKelas', 
        'totalWali', 
        'totalAkun',
        'totalJurusan'));
    }
}
