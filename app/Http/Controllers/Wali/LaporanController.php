<?php

namespace App\Http\Controllers\Wali;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\WaliKelas;
use App\Models\KelasSiswa;
use App\Models\Absensi;
use App\Models\Semester;
use App\Models\TahunAjar;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $Header = 'Laporan';
        $semesterAktif = Semester::where('status', 'aktif')->firstOrFail();

        $user = auth()->user();
        $wali = WaliKelas::where('user_id', $user->id)
    ->where('tahun_ajar_id', $semesterAktif->tahun_ajar_id)
    ->firstOrFail();

        $semester_id = $request->semester_id
    ?? Semester::where('status', 'aktif')->value('id');

        $kelas_id = $wali->kelas_id;
        $tahun_ajar_id = $request->tahun_ajar_id ?? $wali->tahun_ajar_id;
        $dari_tanggal = $request->dari_tanggal;
        $sampai_tanggal = $request->sampai_tanggal;

        // Query absensi per tanggal untuk kelas wali
        $absensiQuery = Absensi::query()
    ->join('kelas_siswa', 'absensi.kelas_siswa_id', '=', 'kelas_siswa.id')
    ->join('semester', 'absensi.semester_id', '=', 'semester.id')
    ->where('kelas_siswa.kelas_id', $kelas_id)
    ->where('absensi.semester_id', $semester_id)
    ->selectRaw(
    'absensi.tanggal,
     SUM(absensi.status = "hadir") as hadir,
     SUM(absensi.status = "izin") as izin,
     SUM(absensi.status = "sakit") as sakit,
     SUM(absensi.status = "alpa") as alpa'
)
    ->groupBy('tanggal')
    ->orderBy('tanggal', 'desc');


        // Filter rentang tanggal jika ada
        if ($dari_tanggal && $sampai_tanggal) {
            $absensiQuery->whereBetween('tanggal', [$dari_tanggal, $sampai_tanggal]);
        } elseif ($dari_tanggal) {
            $absensiQuery->where('tanggal', '>=', $dari_tanggal);
        } elseif ($sampai_tanggal) {
            $absensiQuery->where('tanggal', '<=', $sampai_tanggal);
        }

        $absensi = $absensiQuery->paginate(10)->withQueryString();

        $tahunAjar = TahunAjar::all();

        return view('wali.laporan', compact('semesterAktif','Header', 'absensi', 'tahunAjar', 'wali'));
    }

    public function laporanDetail(Request $request)
    {
        $user = auth()->user();
        $semesterAktif = Semester::where('status', 'aktif')->firstOrFail();
        $semesterAktif = Semester::where('status', 'aktif')->firstOrFail();
        $wali = WaliKelas::where('user_id', $user->id)
    ->where('tahun_ajar_id', $semesterAktif->tahun_ajar_id)
    ->firstOrFail();
        $tanggal = $request->tanggal;

        $kelasSiswaIds = KelasSiswa::where('kelas_id', $wali->kelas_id)
            ->where('tahun_ajar_id', $wali->tahun_ajar_id)
            ->pluck('id');

        $absensi = Absensi::with('kelasSiswa.siswa.user')
    ->whereHas('kelasSiswa', function ($q) use ($wali) {
        $q->where('kelas_id', $wali->kelas_id)
          ->where('tahun_ajar_id', $wali->tahun_ajar_id);
    })
    ->where('semester_id', $semesterAktif->id)
    ->where('tanggal', $tanggal)
    ->get();

        return view('wali.laporan_detail', compact('absensi', 'wali', 'tanggal'));
    }
}
