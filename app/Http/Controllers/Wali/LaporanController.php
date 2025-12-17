<?php

namespace App\Http\Controllers\Wali;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\WaliKelas;
use App\Models\KelasSiswa;
use App\Models\Absensi;
use App\Models\Semester;
use Illuminate\Pagination\LengthAwarePaginator;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $Header = 'Laporan';

        // Semester terpilih (default: aktif)
        $semesterId = $request->semester_id ?? Semester::where('status', 'aktif')->value('id');

        $semesterAktif = Semester::with('tahunAjar')->findOrFail($semesterId);

        // List semester untuk dropdown
        $semesters = Semester::with('tahunAjar')->orderBy('tahun_ajar_id', 'desc')->orderBy('name')->get();

        $wali = WaliKelas::where('user_id', auth()->id())
            ->where('tahun_ajar_id', $semesterAktif->tahun_ajar_id)
            ->first();

        /**
         * 🔴 JIKA TIDAK ADA WALI (misal buka semester lama)
         */
        if (!$wali) {
            $absensi = new LengthAwarePaginator([], 0, 15, request()->get('page', 1), [
                'path' => request()->url(),
                'query' => request()->query(),
            ]);

            return view('wali.laporan', compact('Header', 'absensi', 'wali', 'semesterAktif', 'semesters'));
        }

        // ===============================
        // QUERY NORMAL
        // ===============================
        $dari_tanggal = $request->dari_tanggal;
        $sampai_tanggal = $request->sampai_tanggal;

        $absensiQuery = Absensi::query()
            ->join('kelas_siswa', 'absensi.kelas_siswa_id', '=', 'kelas_siswa.id')
            ->where('kelas_siswa.kelas_id', $wali->kelas_id)
            ->where('absensi.semester_id', $semesterAktif->id)
            ->selectRaw(
                '
            absensi.tanggal,
            SUM(absensi.status = "hadir") as hadir,
            SUM(absensi.status = "izin") as izin,
            SUM(absensi.status = "sakit") as sakit,
            SUM(absensi.status = "alpa") as alpa
        ',
            )
            ->groupBy('absensi.tanggal')
            ->orderBy('absensi.tanggal', 'desc');

        if ($dari_tanggal && $sampai_tanggal) {
            $absensiQuery->whereBetween('absensi.tanggal', [$dari_tanggal, $sampai_tanggal]);
        }

        $absensi = $absensiQuery->paginate(15)->withQueryString();

        return view('wali.laporan', compact('Header', 'absensi', 'wali', 'semesterAktif', 'semesters'));
    }

    public function laporanDetail(Request $request)
    {
        $Header = 'Detail Laporan';
        $user = auth()->user();
        $semester = Semester::findOrFail($request->semester_id);
        $wali = WaliKelas::where('user_id', $user->id)->where('tahun_ajar_id', $semester->tahun_ajar_id)->firstOrFail();
        $tanggal = $request->tanggal;

        $kelasSiswaIds = KelasSiswa::where('kelas_id', $wali->kelas_id)
            ->where('tahun_ajar_id', $wali->tahun_ajar_id)
            ->pluck('id');

        $absensi = Absensi::with('kelasSiswa.siswa.user')
            ->whereHas('kelasSiswa', function ($q) use ($wali) {
                $q->where('kelas_id', $wali->kelas_id)->where('tahun_ajar_id', $wali->tahun_ajar_id);
            })
            ->where('semester_id', $semester->id)
            ->where('tanggal', $tanggal)
            ->get();

        return view('wali.laporan_detail', compact('Header', 'absensi', 'wali', 'tanggal', 'semester'));
    }
}
