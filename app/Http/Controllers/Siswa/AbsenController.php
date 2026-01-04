<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Absensi;
use App\Models\KelasSiswa;
use App\Models\Semester;
use App\Models\QrToken;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class AbsenController extends Controller
{
    public function absen(Request $request)
    {
        // Semester aktif
        $semesterAktif = Semester::where('status', 'aktif')->firstOrFail();

        // Ambil token dari hasil scan QR
        $token = $request->input('token');

        if (!$token) {
            return response()->json([
                'status' => 'error',
                'message' => 'Token QR tidak ditemukan.',
            ]);
        }

        // Cari token & pastikan belum expired
        $qrToken = QrToken::where('token', $token)
            ->where('expired_at', '>', now())
            ->first();

        if (!$qrToken) {
            return response()->json([
                'status' => 'error',
                'message' => 'QR Code tidak valid atau sudah kedaluwarsa.',
            ]);
        }

        // Ambil data dari token
        $kelasId = $qrToken->kelas_id;
        $tahunAjarId = $qrToken->tahun_ajar_id;
        $tanggal = Carbon::today()->toDateString();

        // Ambil siswa dari user login
        $siswa = \App\Models\Siswa::where('user_id', auth()->id())->first();

        if (!$siswa) {
            return response()->json([
                'status' => 'error',
                'message' => 'Siswa tidak ditemukan.',
            ]);
        }

        // Validasi siswa terdaftar di kelas tsb
        $kelasSiswa = KelasSiswa::where('siswa_id', $siswa->id)
            ->where('kelas_id', $kelasId)
            ->where('tahun_ajar_id', $tahunAjarId)
            ->first();

        if (!$kelasSiswa) {
            return response()->json([
                'status' => 'error',
                'message' => 'Anda tidak terdaftar pada kelas ini.',
            ]);
        }

        // Cek apakah sudah absen hari ini
        $cek = Absensi::where('kelas_siswa_id', $kelasSiswa->id)
            ->whereDate('tanggal', $tanggal)
            ->first();

        if ($cek) {
            return response()->json([
                'status' => 'error',
                'message' => 'Anda sudah absen hari ini.',
            ]);
        }

        // Simpan absensi
        Absensi::create([
            'kelas_siswa_id' => $kelasSiswa->id,
            'tanggal' => $tanggal,
            'semester_id' => $semesterAktif->id,
            'status' => 'hadir',
            'method' => 'scan',
            'waktu_absen' => now()->format('H:i:s'),
            'keterangan' => null,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Absensi berhasil dicatat.',
        ]);
    }

    /* ================= ABSEN MANDIRI (TIDAK DIUBAH) ================= */

    public function absenMandiri(Request $request)
    {
        $user = auth()->user();
        $siswa = $user->siswa;
        $semesterAktif = Semester::where('status', 'aktif')->firstOrFail();

        $kelasSiswa = KelasSiswa::where('siswa_id', $siswa->id)->first();
        if (!$kelasSiswa) {
            return back()->with('error', 'Data kelas siswa tidak ditemukan.');
        }

        $key = 'absensi_mandiri_kelas_' . $kelasSiswa->kelas_id;

        if (!Cache::get($key, false)) {
            return back()->with('error', 'Absensi mandiri belum diaktifkan.');
        }

        if (!$request->lat || !$request->lng) {
            return back()->with('error', 'GPS tidak ditemukan.');
        }

        $latSekolah = -6.946701355942461;
        $lngSekolah = 107.59382239956506;
        $radius = 70;

        $jarak = $this->hitungJarak(
            $request->lat,
            $request->lng,
            $latSekolah,
            $lngSekolah
        );

        if ($jarak > $radius) {
            return back()->with('error', 'Anda berada di luar area sekolah.');
        }

        $tanggal = Carbon::today()->toDateString();

        $cek = Absensi::where('kelas_siswa_id', $kelasSiswa->id)
            ->whereDate('tanggal', $tanggal)
            ->first();

        if ($cek) {
            return back()->with('error', 'Anda sudah melakukan absensi hari ini.');
        }

        Absensi::create([
            'kelas_siswa_id' => $kelasSiswa->id,
            'tanggal' => $tanggal,
            'semester_id' => $semesterAktif->id,
            'status' => 'hadir',
            'method' => 'mandiri',
            'waktu_absen' => now()->format('H:i:s'),
            'keterangan' => null,
        ]);

        return back()->with('success', 'Absensi berhasil!');
    }

    // Haversine Formula
    private function hitungJarak($lat1, $lng1, $lat2, $lng2)
    {
        $earthRadius = 6371000;

        $dLat = deg2rad($lat2 - $lat1);
        $dLng = deg2rad($lng2 - $lng1);

        $a = sin($dLat / 2) * sin($dLat / 2) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            sin($dLng / 2) * sin($dLng / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c;
    }
}
