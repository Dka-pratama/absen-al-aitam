<?php

namespace App\Http\Controllers\Wali;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WaliKelas;
use App\Models\KelasSiswa;
use App\Models\Absensi;
use Carbon\Carbon;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class AbsenController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $wali = WaliKelas::with('kelas', 'tahunAjar')
            ->where('user_id', $user->id)
            ->firstOrFail();

        // Ambil siswa
        $siswa = KelasSiswa::with('siswa.user')
            ->where('kelas_id', $wali->kelas_id)
            ->where('tahun_ajar_id', $wali->tahun_ajar_id)
            ->get();


        // Ambil absensi hari ini
        $today = Carbon::today()->toDateString();

        $absensiToday = Absensi::whereHas('kelasSiswa', function ($q) use ($wali) {
            $q->where('kelas_id', $wali->kelas_id)
                ->where('tahun_ajar_id', $wali->tahun_ajar_id);
        })
            ->where('tanggal', $today)
            ->get();

        // PENTING: kirim absensi dalam bentuk keyed by siswa_id
        $absensiMap = $absensiToday->keyBy('kelas_siswa_id');

        // Hitung persentase
        $persentase = $this->hitungPersentase($siswa, $absensiToday);

        return view('wali.absensi', compact(
            'wali',
            'siswa',
            'persentase',
            'absensiMap'
        ));
    }

    public function simpan(Request $request)
{
    $wali = WaliKelas::where('user_id', auth()->id())->firstOrFail();
    $tanggal = Carbon::today()->toDateString();

    foreach ($request->status as $kelasSiswaId => $status) {

        Absensi::updateOrCreate(
            [
                'kelas_siswa_id' => $kelasSiswaId,
                'tanggal' => $tanggal,
            ],
            [
                'status' => $status,
                'keterangan' => $request->keterangan[$kelasSiswaId] ?? null,
            ]
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

}
