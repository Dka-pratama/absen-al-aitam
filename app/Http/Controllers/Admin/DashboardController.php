<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserSession;
use App\Models\Kelas;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

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

        $raw = UserSession::select(
            DB::raw('HOUR(login_at) as jam'),
            DB::raw('COUNT(*) as total')
        )
        ->whereDate('login_at', Carbon::today())
        ->whereHas('user', function ($q) {
            $q->whereIn('role', ['siswa', 'wali']);
        })
        ->groupBy('jam')
        ->get()
        ->keyBy('jam');

    $labels = [];
    $values = [];

    for ($i = 0; $i < 24; $i++) {
        $labels[] = sprintf('%02d:00', $i);
        $values[] = $raw[$i]->total ?? 0; // jika jam itu kosong → 0
    }

        return view(
            'admin.dashboard',
            compact('totalSiswa', 
            'totalKelas', 
            'totalWali', 
            'totalAkun', 
            'totalJurusan', 
            'Header',
            'labels',
        'values'),
        );
    }
}
