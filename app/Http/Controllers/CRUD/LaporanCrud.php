<?php

namespace App\Http\Controllers\CRUD;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Absensi;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Kelas;
use App\Models\Semester;
use App\Exports\RekapAbsensiExport;

class LaporanCrud extends Controller
{
    public function index(Request $request)
    {
        $Header = 'Data Laporan Absensi';

        $kelasId = $request->kelas_id;
        $tanggalDari = $request->tanggal_dari;
        $tanggalSampai = $request->tanggal_sampai;

        $absensi = \DB::table('absensi')
            ->join('kelas_siswa', 'absensi.kelas_siswa_id', '=', 'kelas_siswa.id')
            ->join('kelas', 'kelas_siswa.kelas_id', '=', 'kelas.id')
            ->select(
                'absensi.tanggal',
                'kelas.id as kelas_id',
                'kelas.nama_kelas',

                // ✅ REKAP JUMLAH
                \DB::raw('COUNT(absensi.id) as total'),
                \DB::raw('SUM(absensi.status = "hadir") as hadir'),
                \DB::raw('SUM(absensi.status = "izin") as izin'),
                \DB::raw('SUM(absensi.status = "sakit") as sakit'),
                \DB::raw('SUM(absensi.status = "alpa") as alpa'),
            )
            ->when($kelasId, fn($q) => $q->where('kelas.id', $kelasId))
            ->when($tanggalDari && $tanggalSampai, function ($q) use ($tanggalDari, $tanggalSampai) {
                $q->whereBetween('absensi.tanggal', [$tanggalDari, $tanggalSampai]);
            })
            ->groupBy('absensi.tanggal', 'kelas.id', 'kelas.nama_kelas')
            ->orderBy('absensi.tanggal', 'desc')
            ->paginate(10);

        $kelas = Kelas::all();

        return view('admin.laporan.index', compact('absensi', 'kelas', 'Header'));
    }

    public function detail(Request $request)
{
    $Header = 'Detail Laporan Absensi';

    $request->validate([
        'kelas_id' => 'required|exists:kelas,id',
        'tanggal' => 'required|date',
    ]);

    $semesterAktif = Semester::where('status', 'aktif')->firstOrFail();

    $kelas = Kelas::findOrFail($request->kelas_id);

    $absensi = Absensi::with(['kelassiswa.siswa.user'])
        ->whereHas('kelassiswa', function ($q) use ($request) {
            $q->where('kelas_id', $request->kelas_id);
        })
        ->where('tanggal', $request->tanggal)
        ->where('semester_id', $semesterAktif->id)
        ->orderBy('kelas_siswa_id')
        ->get();

    return view('admin.laporan.detail', compact(
        'Header',
        'kelas',
        'absensi'
    ))->with('tanggal', $request->tanggal);
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

private function getRekap(Request $request)
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
        ->where('kelas_siswa.kelas_id', $request->kelas_id)
        ->whereBetween('tanggal', [$dari, $sampai])
        ->groupBy('siswa.id', 'users.name', 'siswa.NISN')
        ->orderBy('users.name')
        ->get();
}


    public function exportRangeExcel(Request $request)
{
    $request->validate([
        'kelas_id' => 'required|exists:kelas,id',
        'mode' => 'required|in:bulan,minggu',
    ]);

    $kelas = Kelas::findOrFail($request->kelas_id);
    $rekap = $this->getRekap($request);

    return Excel::download(
        new RekapAbsensiExport($rekap),
        "Rekap-{$kelas->nama_kelas}.xlsx"
    );
}


    public function exportRangePDF(Request $request)
{
    $request->validate([
        'kelas_id' => 'required|exists:kelas,id',
        'mode' => 'required|in:bulan,minggu',
    ]);

    $kelas = Kelas::findOrFail($request->kelas_id);
    $rekap = $this->getRekap($request);
    [$dari, $sampai] = $this->getRangeTanggal($request);

    $pdf = Pdf::loadView('admin.laporan.export-pdf', [
        'kelas' => $kelas,
        'rekap' => $rekap,
        'dari' => $dari,
        'sampai' => $sampai,
    ])->setPaper('a4', 'landscape');

    return $pdf->stream("Rekap-{$kelas->nama_kelas}.pdf");
}



    public function exportPage(Request $request)
{
    $kelas = Kelas::orderBy('nama_kelas')->get();

    return view('admin.laporan.export', compact('kelas'));
}


    public function destroy($id)
    {
        $absensi = Absensi::findOrFail($id);
        $absensi->delete();
        return redirect()->route('absensi.index')->with('success', 'Absensi deleted successfully.');
    }
}
