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
        $siswa = $user->siswa;
        $kelasSiswaIds = $siswa->kelasSiswa()->pluck('id');

        if (!$siswa) {
            abort(403, 'Akun ini belum terdaftar sebagai siswa');
        }

        // ambil kelas_siswa aktif, fallback ke terakhir
        $kelasSiswaAktif = $siswa
            ->kelasSiswa()
            ->whereHas('tahunAjar', fn($q) => $q->where('status', 'aktif'))
            ->with('kelas', 'tahunAjar')
            ->first();

        $kelasSiswa =
            $kelasSiswaAktif ?? $siswa->kelasSiswa()->with('kelas', 'tahunAjar')->orderByDesc('tahun_ajar_id')->first();
        $kelas = $kelasSiswa->kelas;
        if (!$kelasSiswa) {
            abort(404, 'Data kelas siswa tidak ditemukan');
        }

        // ambil semester sesuai tahun ajar kelas siswa
        $semester = Semester::where('tahun_ajar_id', $kelasSiswa->tahun_ajar_id)->where('status', 'aktif')->first();
        $hariIni = now()->toDateString();

        $absenHariIni = Absensi::where('kelas_siswa_id', $kelasSiswa->id)
            ->when($semester, fn($q) => $q->where('semester_id', $semester->id))
            ->whereDate('tanggal', $hariIni)
            ->first();

        $kelasSiswaIds = $siswa->kelasSiswa()->pluck('id');

        $absen = Absensi::whereIn('kelas_siswa_id', $kelasSiswaIds)
            ->when($semester, fn($q) => $q->where('semester_id', $semester->id))
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');

        $absensiMingguIni = Absensi::where('kelas_siswa_id', $kelasSiswa->id)
            ->when($semester, fn($q) => $q->where('semester_id', $semester->id))
            ->whereBetween('tanggal', [now()->startOfWeek(), now()->endOfWeek()])
            ->get()
            ->keyBy(fn($a) => \Carbon\Carbon::parse($a->tanggal)->format('l'));

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

        $siswa = $user->siswa;

        $siswa = $user->siswa;
        if (!$siswa) {
            abort(403, 'Akun ini belum terdaftar sebagai siswa');
        }

        $kelasSiswaAktif = $siswa->kelasSiswa()->whereHas('tahunAjar', fn($q) => $q->where('status', 'aktif'))->first();

        $kelasSiswa = $kelasSiswaAktif ?? $siswa->kelasSiswa()->orderByDesc('tahun_ajar_id')->first();

        if (!$kelasSiswa) {
            abort(404, 'Data kelas siswa tidak ditemukan');
        }

        $semester = Semester::where('tahun_ajar_id', $kelasSiswa->tahun_ajar_id)->where('status', 'aktif')->first();

        if (!$kelasSiswa) {
            abort(404, 'Siswa belum terdaftar di kelas tahun ajar aktif');
        }

        $query = Absensi::where('kelas_siswa_id', $kelasSiswa->id)->when(
            $semester,
            fn($q) => $q->where('semester_id', $semester->id),
        );

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
