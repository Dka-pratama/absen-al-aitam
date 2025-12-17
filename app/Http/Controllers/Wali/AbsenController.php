<?php

namespace App\Http\Controllers\Wali;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WaliKelas;
use App\Models\KelasSiswa;
use App\Models\Absensi;
use Carbon\Carbon;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Models\Siswa;
use Illuminate\Support\Facades\Cache;
use App\Models\Semester;

class AbsenController extends Controller
{
    public function index()
    {
        $semesterAktif = Semester::where('status', 'aktif')->firstOrFail();

        $Header = 'Absensi';
        $user = auth()->user();
        $wali = WaliKelas::with('kelas', 'tahunAjar')
            ->where('user_id', $user->id)
            ->where('tahun_ajar_id', $semesterAktif->tahun_ajar_id)
            ->firstOrFail();

        // Ambil siswa
        $siswa = KelasSiswa::with('siswa.user')
            ->where('kelas_id', $wali->kelas_id)
            ->where('tahun_ajar_id', $wali->tahun_ajar_id)
            ->get();

        // Ambil absensi hari ini
        $today = Carbon::today()->toDateString();

        $absensiToday = Absensi::whereHas('kelasSiswa', function ($q) use ($wali) {
            $q->where('kelas_id', $wali->kelas_id)->where('tahun_ajar_id', $wali->tahun_ajar_id);
        })
            ->where('tanggal', $today)
            ->where('semester_id', $semesterAktif->id)
            ->get();

        $absensiMap = $absensiToday->keyBy('kelas_siswa_id');
        $persentase = $this->hitungPersentase($siswa, $absensiToday);

        $payload = [
            'kelas_id' => $wali->kelas_id,
            'tahun_ajar_id' => $wali->tahun_ajar_id,
            'semester_id' => $semesterAktif->id,
            'tanggal' => $today,
        ];

        $qr = base64_encode(QrCode::size(300)->generate(json_encode($payload)));
        // ==========================

        return view(
            'wali.absensi',
            compact('wali', 'siswa', 'persentase', 'absensiMap', 'qr', 'Header', 'semesterAktif'),
        );
    }

    public function simpan(Request $request)
    {
        $semesterAktif = Semester::where('status', 'aktif')->firstOrFail();
        $user = auth()->user();
        $wali = WaliKelas::with('kelas', 'tahunAjar')
            ->where('user_id', $user->id)
            ->where('tahun_ajar_id', $semesterAktif->tahun_ajar_id)
            ->firstOrFail();
        $tanggal = Carbon::today()->toDateString();
        $semesterAktif = Semester::where('status', 'aktif')->firstOrFail();

        foreach ($request->status as $kelasSiswaId => $status) {
            Absensi::updateOrCreate(
                [
                    'kelas_siswa_id' => $kelasSiswaId,
                    'tanggal' => $tanggal,
                    'semester_id' => $semesterAktif->id,
                ],
                [
                    'status' => $status,
                    'keterangan' => $request->keterangan[$kelasSiswaId] ?? null,
                ],
            );
        }

        return back()->with('success', 'Absensi berhasil disimpan!');
    }

    private function hitungPersentase($siswa, $absensi)
    {
        $total = max($siswa->count(), 1); // anti divide-by-zero
        $h = $absensi->where('status', 'hadir')->count();
        $i = $absensi->where('status', 'izin')->count();
        $s = $absensi->where('status', 'sakit')->count();
        $a = $absensi->where('status', 'alpa')->count();

        return [
            'hadir' => round(($h / $total) * 100),
            'izin' => round(($i / $total) * 100),
            'sakit' => round(($s / $total) * 100),
            'alpa' => round(($a / $total) * 100),
        ];
    }

    public function absensi()
    {
        $wali = auth()->user()->waliKelas; // relasi
        $kelasId = $wali->kelas_id;

        $qrContent = $kelasId . '|' . now()->format('Y-m-d');

        $qr = QrCode::size(220)->generate($qrContent);

        $siswa = Siswa::where('kelas_id', $kelasId)->get();

        return view('wali.absensi', compact('qr', 'siswa'));
    }
    public function toggleAbsensiMandiri($kelasId)
    {
        $key = 'absensi_mandiri_kelas_' . $kelasId;

        $status = Cache::get($key, false);
        $newStatus = !$status;

        Cache::put($key, $newStatus, now()->addHours(12));

        return back()->with('success', 'Absensi mandiri: ' . ($newStatus ? 'AKTIF' : 'NON-AKTIF'));
    }
}
