<?php

namespace App\Http\Controllers\Wali;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\WaliKelas;
use App\Models\KelasSiswa;
use App\Models\Absensi;
use App\Models\Semester;

class DashboardWaliController extends Controller
{
    public function index()
    {
        $Header = 'Dashboard';
        $user = Auth::user();
        $semesterAktif = Semester::where('status', 'aktif')->firstOrFail();
        $wali = WaliKelas::with('user', 'kelas', 'tahunAjar')
            ->where('user_id', $user->id)
            ->where('tahun_ajar_id', $semesterAktif->tahun_ajar_id)
            ->firstOrFail();
        if (!$wali) {
            return abort(403, 'Anda bukan wali kelas.');
        }

        $tahunAjar = $semesterAktif->tahunAjar;
        $kelas = $wali->kelas;

        $kelasSiswa = KelasSiswa::where('kelas_id', $kelas->id)->where('tahun_ajar_id', $tahunAjar->id)->pluck('id');
        $totalSiswa = $kelasSiswa->count();

        $hariIni = date('Y-m-d');

        // --- Statistik hari ini ---
        $absensiHariIni = KelasSiswa::where('kelas_id', $kelas->id)
            ->where('tahun_ajar_id', $tahunAjar->id)
            ->with([
                'absensi' => function ($q) use ($hariIni, $semesterAktif) {
                    $q->whereDate('tanggal', $hariIni)->where('semester_id', $semesterAktif->id);
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

        $tanggal = [];
        $hadirChart = [];
        $izinChart = [];
        $sakitChart = [];
        $alpaChart = [];

        for ($i = 29; $i >= 0; $i--) {
            $tgl = date('Y-m-d', strtotime("-{$i} days"));
            $tanggal[] = $tgl;

            $data = Absensi::whereIn('kelas_siswa_id', $kelasSiswa)
                ->where('semester_id', $semesterAktif->id)
                ->whereDate('tanggal', $tgl)
                ->get();
            $hadirChart[] = $data->where('status', 'hadir')->count();
            $izinChart[] = $data->where('status', 'izin')->count();
            $sakitChart[] = $data->where('status', 'sakit')->count();
            $alpaChart[] = $data->where('status', 'alpa')->count();
        }

        return view(
            'wali.dashboard',
            [
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
            ],
            compact('Header'),
        );
    }
}
