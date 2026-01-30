<?php

namespace App\Http\Controllers\Wali;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\WaliKelas;
use App\Models\KelasSiswa;
use App\Models\Absensi;
use App\Models\Kelas;
use App\Models\Semester;
use Illuminate\Pagination\LengthAwarePaginator;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\RekapAbsensiExport;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $Header = 'Laporan';
        $semesterId = $request->semester_id ?? Semester::where('status', 'aktif')->value('id');
        $semesterAktif = Semester::with('tahunAjar')->findOrFail($semesterId);
        $semesters = Semester::with('tahunAjar')->orderBy('tahun_ajar_id', 'desc')->orderBy('name')->get();
        $wali = WaliKelas::where('user_id', auth()->id())
            ->where('tahun_ajar_id', $semesterAktif->tahun_ajar_id)
            ->first();

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
    private function getRangeTanggal(Request $request)
    {
        if ($request->mode === 'bulan') {
            $dari = $request->bulan . '-01';
            $sampai = date('Y-m-t', strtotime($dari));
        } else {
            $dari = $request->tanggal_dari;
            $sampai = $request->tanggal_sampai;
        }

        return [$dari, $sampai];
    }

    private function getRekap(Request $request, $kelasId)
    {
        [$dari, $sampai] = $this->getRangeTanggal($request);

        return Absensi::select(
                'siswa.id',
                'users.name',
                'siswa.NISN',
                \DB::raw('SUM(status="hadir") as hadir'),
                \DB::raw('SUM(status="izin") as izin'),
                \DB::raw('SUM(status="sakit") as sakit'),
                \DB::raw('SUM(status="alpa") as alpa'),
                \DB::raw('COUNT(*) as total')
            )
            ->join('kelas_siswa', 'absensi.kelas_siswa_id', '=', 'kelas_siswa.id')
            ->join('siswa', 'kelas_siswa.siswa_id', '=', 'siswa.id')
            ->join('users', 'siswa.user_id', '=', 'users.id')
            ->where('kelas_siswa.kelas_id', $kelasId)
            ->whereBetween('tanggal', [$dari, $sampai])
            ->groupBy('siswa.id', 'users.name', 'siswa.NISN')
            ->orderBy('users.name')
            ->get();
    }

    public function exportExcel(Request $request)
    {
        $request->validate([
            'mode' => 'required|in:bulan,minggu',
        ]);

        $wali = Auth::user()->waliKelas;
        $kelas = $wali->kelas;

        $rekap = $this->getRekap($request, $kelas->id);

        return Excel::download(
            new RekapAbsensiExport($rekap),
            "Rekap-{$kelas->nama_kelas}.xlsx"
        );
    }

    public function exportPDF(Request $request)
    {
        $request->validate([
            'mode' => 'required|in:bulan,minggu',
        ]);

        $wali = Auth::user()->waliKelas;
        $kelas = $wali->kelas;

        $rekap = $this->getRekap($request, $kelas->id);
        [$dari, $sampai] = $this->getRangeTanggal($request);

        $pdf = Pdf::loadView('wali.laporan.export-pdf', [
            'kelas' => $kelas,
            'rekap' => $rekap,
            'dari' => $dari,
            'sampai' => $sampai,
        ])->setPaper('a4', 'landscape');

        return $pdf->download("Rekap-{$kelas->nama_kelas}.pdf");
    }

    public function exportRangeExcel(Request $request)
{
    $request->validate([
        'mode' => 'required|in:bulan,minggu',
    ]);

    $semesterAktif = Semester::where('status', 'aktif')->first();

    $wali = WaliKelas::where('user_id', auth()->id())
    ->where('tahun_ajar_id', $semesterAktif->tahun_ajar_id)
    ->first();

    if (!$wali || !$wali->kelas) {
        return redirect()
            ->route('wali.laporan')
            ->with('error', 'Akun wali belum terhubung dengan kelas.');
    }
    $kelas = $wali->kelas;

    $rekap = $this->getRekap($request, $kelas->id);

    return Excel::download(
        new RekapAbsensiExport($rekap),
        "Rekap-{$kelas->nama_kelas}.xlsx"
    );
}

public function exportRangePDF(Request $request)
{
    $request->validate([
        'mode' => 'required|in:bulan,minggu',
    ]);

    $semesterAktif = Semester::where('status', 'aktif')->first();

    $wali = WaliKelas::where('user_id', auth()->id())
    ->where('tahun_ajar_id', $semesterAktif->tahun_ajar_id)
    ->first();

    if (!$wali || !$wali->kelas) {
        return redirect()
            ->route('wali.laporan')
            ->with('error', 'Akun wali belum terhubung dengan kelas.');
    }

    $kelas = $wali->kelas;

    $rekap = $this->getRekap($request, $kelas->id);
    [$dari, $sampai] = $this->getRangeTanggal($request);

    $pdf = Pdf::loadView('wali.export-pdf', [
        'kelas' => $kelas,
        'rekap' => $rekap,
        'dari' => $dari,
        'sampai' => $sampai,
    ])->setPaper('a4', 'landscape');

    return $pdf->download("Rekap-{$kelas->nama_kelas}.pdf");
}


    public function exportPage()
{
    $Header = 'Export Laporan';
    return view('wali.export', compact('Header'));
}

}
