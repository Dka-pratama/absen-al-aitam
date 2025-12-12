<?php

namespace App\Http\Controllers\wali;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\WaliKelas;
use App\Models\KelasSiswa;
use App\Models\Absensi;

class DashboardWaliController extends Controller
{
    public function index()
    {
        $Header = 'Dashboard';
        $user = Auth::user();
        $wali = WaliKelas::with('user', 'kelas', 'tahunAjar')->where('user_id', $user->id)->first();
        if (!$wali) {
            return abort(403, 'Anda bukan wali kelas.');
        }

        $tahunAjar = $wali->tahunAjar;
        $kelas = $wali->kelas;

        $kelasSiswa = KelasSiswa::where('kelas_id', $kelas->id)->pluck('id');
        $totalSiswa = $kelasSiswa->count();

        $hariIni = date('Y-m-d');

        // --- Statistik hari ini ---
        $absensiHariIni = $kelas
            ->kelasSiswa()
            ->with([
                'absensi' => function ($q) use ($hariIni) {
                    $q->whereDate('tanggal', $hariIni);
                },
            ])
            ->get()
            ->pluck('absensi')
            ->flatten();

        $hadir = $absensiHariIni->where('status', 'hadir')->count();
        $izin = $absensiHariIni->where('status', 'izin')->count();
        $sakit = $absensiHariIni->where('status', 'sakit')->count();
        $alpa = $absensiHariIni->where('status', 'alpa')->count();

        $persentaseHadir = $totalSiswa > 0 ? round(($hadir / $totalSiswa) * 100, 1) : 0;

        // --- DATA UNTUK CHART: 30 HARI TERAKHIR ---
        $tanggal = [];
        $hadirChart = [];
        $izinChart = [];
        $sakitChart = [];
        $alpaChart = [];

        for ($i = 29; $i >= 0; $i--) {
            $tgl = date('Y-m-d', strtotime("-{$i} days"));
            $tanggal[] = $tgl;

            $data = Absensi::whereIn('kelas_siswa_id', $kelasSiswa)->whereDate('tanggal', $tgl)->get();

            $hadirChart[] = $data->where('status', 'hadir')->count();
            $izinChart[] = $data->where('status', 'izin')->count();
            $sakitChart[] = $data->where('status', 'sakit')->count();
            $alpaChart[] = $data->where('status', 'alpa')->count();
        }

        return view('wali.dashboard', [
            'wali' => $wali,
            'tahunAjar' => $tahunAjar,
            'kelas' => $kelas,
            'totalSiswa' => $totalSiswa,
            'hadir' => $hadir,
            'izin' => $izin,
            'sakit' => $sakit,
            'alpa' => $alpa,
            'persentaseHadir' => $persentaseHadir,
            'hariIni' => $hariIni,

            // Data chart
            'chartTanggal' => $tanggal,
            'chartHadir' => $hadirChart,
            'chartIzin' => $izinChart,
            'chartSakit' => $sakitChart,
            'chartAlpa' => $alpaChart,
        ], compact('Header'));
    }
}
