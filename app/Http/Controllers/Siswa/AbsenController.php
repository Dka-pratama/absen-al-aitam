<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Absensi;
use App\Models\KelasSiswa;
use Illuminate\Support\Facades\Cache;

class AbsenController extends Controller
{
    public function absen(Request $request)
    {
        $payload = json_decode($request->input('data'), true);

        if (!$payload) {
            return response()->json([
                'status' => 'error',
                'message' => 'QR Code tidak valid.',
            ]);
        }

        $tanggal = $payload['tanggal'];
        $kelasId = $payload['kelas_id'];
        $tahunAjarId = $payload['tahun_ajar_id'];

        $siswa = \App\Models\Siswa::where('user_id', auth()->id())->first();

        if (!$siswa) {
            return response()->json([
                'status' => 'error',
                'message' => 'Siswa tidak ditemukan.',
            ]);
        }

        $kelasSiswa = \App\Models\KelasSiswa::where('siswa_id', $siswa->id)
            ->where('kelas_id', $kelasId)
            ->where('tahun_ajar_id', $tahunAjarId)
            ->first();

        if (!$kelasSiswa) {
            return response()->json([
                'status' => 'error',
                'message' => 'Anda tidak terdaftar pada kelas ini.',
            ]);
        }

        // Cek sudah absen
        $cek = \App\Models\Absensi::whereDate('tanggal', $tanggal)->where('kelas_siswa_id', $kelasSiswa->id)->first();

        if ($cek) {
            return response()->json([
                'status' => 'error',
                'message' => 'Anda sudah absen hari ini.',
            ]);
        }

        Absensi::create([
            'kelas_siswa_id' => $kelasSiswa->id,
            'tanggal' => $tanggal,
            'status' => 'hadir',
            'method' => 'scan',
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Absensi berhasil dicatat!',
        ]);
    }
    public function absenMandiri(Request $request)
    {
        $user = auth()->user();
        $siswa = $user->siswa;

        $kelasSiswa = KelasSiswa::where('siswa_id', $siswa->id)->first();
        if (!$kelasSiswa) {
            return back()->with('error', 'Data kelas siswa tidak ditemukan.');
        }

        $key = 'absensi_mandiri_kelas_' . $kelasSiswa->kelas_id;

        // cek apakah wali kelas mengaktifkan
        if (!Cache::get($key, false)) {
            return back()->with('error', 'Absensi mandiri belum diaktifkan.');
        }

        // Validasi GPS
        if (!$request->lat || !$request->lng) {
            return back()->with('error', 'GPS tidak ditemukan.');
        }

        // Lokasi sekolah
        $latSekolah = -6.944586356277864;
        $lngSekolah = 107.59453839636247;
        $radius = 70; // meter

        $jarak = $this->hitungJarak($request->lat, $request->lng, $latSekolah, $lngSekolah);

        if ($jarak > $radius) {
            return back()->with('error', 'Anda berada di luar area sekolah.');
        }

        // Cek sudah absen hari ini atau belum
        $cek = Absensi::where('kelas_siswa_id', $kelasSiswa->id)
            ->whereDate('tanggal', now()->toDateString())
            ->first();

        if ($cek) {
            return back()->with('error', 'Anda sudah melakukan absensi hari ini.');
        }

        // Simpan absensi
        Absensi::create([
            'kelas_siswa_id' => $kelasSiswa->id,
            'tanggal' => now()->toDateString(),
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

        $a =
            sin($dLat / 2) * sin($dLat / 2) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLng / 2) * sin($dLng / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c;
    }
}
