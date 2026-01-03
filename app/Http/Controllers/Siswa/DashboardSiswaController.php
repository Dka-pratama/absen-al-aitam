<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Kelas;
use App\Models\Absensi;
use Illuminate\Support\Facades\DB;
use App\Models\Semester;

class DashboardSiswaController extends Controller
{
    public function index()
    {
        $Header = 'Dashboard';
        $user = Auth::user();
        $semesterAktif = Semester::where('status', 'aktif')->firstOrFail();

        $kelas = $user->siswa->kelasSiswa()->with('kelas')->first();
        if (!$user->siswa) {
             abort(403, 'Akun ini belum terdaftar sebagai siswa');
        }
        $siswa = $user->siswa;

        $kelasSiswa = $siswa->KelasSiswa()->pluck('id');
        $kelasSiswa2 = $siswa->kelasSiswa()->first();
        $hariIni = now()->toDateString();

        $absenHariIni = Absensi::where('kelas_siswa_id', $kelasSiswa2->id)
            ->where('semester_id', $semesterAktif->id)
            ->whereDate('tanggal', $hariIni)
            ->first();
        $absen = Absensi::whereIn('kelas_siswa_id', $kelasSiswa)
            ->where('semester_id', $semesterAktif->id)
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');
        $absensiMingguIni = Absensi::whereIn('kelas_siswa_id', $kelasSiswa)
            ->where('semester_id', $semesterAktif->id)
            ->whereBetween('tanggal', [now()->startOfWeek(), now()->endOfWeek()])
            ->get()
            ->keyBy(function ($a) {
                return \Carbon\Carbon::parse($a->tanggal)->format('l'); // e.g. "Monday"
            });

        // List hari (urutan tetap)
        $hariList = [
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
        ];

        $riwayat = [];

        foreach ($hariList as $eng => $indo) {
            $riwayat[] = [
                'hari' => $indo,
                'status' => $absensiMingguIni[$eng]->status ?? '-', // default "-"
            ];
        }
        return view('siswa.dashboard', compact('user', 'kelas', 'absen', 'absenHariIni', 'riwayat', 'Header'));
    }

    public function rekap(Request $request)
{
    $Header = 'Rekap Absensi';
    $user = Auth::user();

    $tahunAjarAktif = \App\Models\TahunAjar::where('status', 'aktif')->firstOrFail();
    $semesterAktif = $tahunAjarAktif->semesterAktif;

    if (!$semesterAktif) {
        abort(500, 'Semester aktif belum disetting');
    }

    $siswa = $user->siswa;

    $kelasSiswa = $siswa->kelasSiswa()
        ->where('tahun_ajar_id', $tahunAjarAktif->id)
        ->first();

    if (!$kelasSiswa) {
        abort(404, 'Siswa belum terdaftar di kelas tahun ajar aktif');
    }

    $query = Absensi::where('kelas_siswa_id', $kelasSiswa->id)
        ->where('semester_id', $semesterAktif->id);

    if ($request->start_date) {
        $query->whereDate('tanggal', '>=', $request->start_date);
    }

    if ($request->end_date) {
        $query->whereDate('tanggal', '<=', $request->end_date);
    }

    $rekap = $query->orderBy('tanggal', 'desc')->paginate(15);

    return view('siswa.rekap', compact('rekap', 'Header'));
}

}
