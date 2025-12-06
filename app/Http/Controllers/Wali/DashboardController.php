<?php

namespace App\Http\Controllers\Wali;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Absensi;
use App\Models\WaliKelas;
use App\Models\KelasSiswa;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Ambil data wali kelas yang login
        $wali = WaliKelas::with(['kelas', 'tahunAjar'])
            ->where('user_id', $user->id)
            ->first();

        if (!$wali) {
            abort(403, "Anda bukan wali kelas");
        }

        // jumlah siswa di kelas
        $jumlahSiswa = KelasSiswa::where('kelas_id', $wali->kelas_id)
            ->where('tahun_ajar_id', $wali->tahun_ajar_id)
            ->count();

        // Absensi hari ini
        $today = Carbon::today()->toDateString();

        $absensiHariIni = Absensi::whereIn('kelas_siswa_id', function ($query) use ($wali) {
            $query->select('id')
                ->from('kelas_siswa')
                ->where('kelas_id', $wali->kelas_id)
                ->where('tahun_ajar_id', $wali->tahun_ajar_id);
        })
            ->where('tanggal', $today)
            ->count();


        return view('wali.dashboard', compact(
            'user',
            'wali',
            'jumlahSiswa',
            'absensiHariIni'
        ));
    }

}
