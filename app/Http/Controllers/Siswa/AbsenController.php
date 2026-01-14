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
use App\Models\TahunAjar;

class AbsenController extends Controller
{
    public function absen(Request $request)
    {
        try {
            $tahunAktif = TahunAjar::where('status', 'aktif')->first();

            $semesterAktif = Semester::where('tahun_ajar_id', $tahunAktif->id)->where('status', 'aktif')->first();

            $token = $request->input('token');

            if (!$token) {
                return response()->json(
                    [
                        'status' => 'error',
                        'message' => 'Token tidak dikirim.',
                    ],
                    400,
                );
            }

            $qrToken = QrToken::where('token', $token)
                ->where('expired_at', '>', now()->subSeconds(10))
                ->first();

            if (!$qrToken) {
                return response()->json(
                    [
                        'status' => 'error',
                        'message' => 'QR Code tidak valid atau sudah kedaluwarsa.',
                    ],
                    400,
                );
            }

            $siswa = \App\Models\Siswa::where('user_id', auth()->id())->first();
            if (!$siswa) {
                return response()->json(
                    [
                        'status' => 'error',
                        'message' => 'Akun siswa tidak ditemukan.',
                    ],
                    404,
                );
            }

            $kelasSiswa = KelasSiswa::where('siswa_id', $siswa->id)
                ->where('kelas_id', $qrToken->kelas_id)
                ->where('tahun_ajar_id', $qrToken->tahun_ajar_id)
                ->first();

            if (!$kelasSiswa) {
                return response()->json(
                    [
                        'status' => 'error',
                        'message' => 'Anda tidak terdaftar di kelas ini.',
                    ],
                    403,
                );
            }

            $tanggal = now()->toDateString();

            $cek = Absensi::where('kelas_siswa_id', $kelasSiswa->id)->whereDate('tanggal', $tanggal)->first();

            if ($cek) {
                return response()->json(
                    [
                        'status' => 'error',
                        'message' => 'Anda sudah absen hari ini.',
                    ],
                    409,
                );
            }

            if (!$semesterAktif) {
                return response()->json(
                    [
                        'status' => 'error',
                        'msg' => 'Semester aktif tidak ditemukan',
                    ],
                    500,
                );
            }

            Absensi::create([
                'kelas_siswa_id' => $kelasSiswa->id,
                'tanggal' => $tanggal,
                'semester_id' => $semesterAktif->id,
                'status' => 'hadir',
                'method' => 'scan',
                'waktu_absen' => now()->format('H:i:s'),
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Absensi berhasil dicatat.',
            ]);
        } catch (\Throwable $e) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => $e->getMessage(),
                ],
                500,
            );
        }
    }

    public function absenMandiri(Request $request)
    {
        $user = auth()->user();
        $siswa = $user->siswa;
        $semesterAktif = Semester::where('status', 'aktif')->firstOrFail();

        $kelasSiswa = KelasSiswa::where('siswa_id', $siswa->id)->first();
        if (!$kelasSiswa) {
            return back()->with('error', 'Data kelas siswa tidak ditemukan.');
        }

        $kelasId = $kelasSiswa->kelas_id;

        $globalAktif = Cache::get('absensi_mandiri_global', false);
        $kelasAktif = Cache::get('absensi_mandiri_kelas_' . $kelasId, false);

        if (!$globalAktif && !$kelasAktif) {
            return back()->with('error', 'Absensi mandiri belum diaktifkan.');
        }

        if (!$request->lat || !$request->lng) {
            return back()->with('error', 'GPS tidak ditemukan.');
        }
        // -6.9443854010929815, 107.58977839651386
        $latSekolah = -6.9443854010929815;
        $lngSekolah = 107.58977839651386;
        $radius = 1000;

        $jarak = $this->hitungJarak($request->lat, $request->lng, $latSekolah, $lngSekolah);

        $manualByAdmin = Cache::get('absensi_manual_admin', false);

        if (!$manualByAdmin) {
            if ($jarak > $radius) {
                return back()->with('error', 'Anda berada di luar area sekolah.');
            }
        }

        $tanggal = Carbon::today()->toDateString();

        $cek = Absensi::where('kelas_siswa_id', $kelasSiswa->id)->whereDate('tanggal', $tanggal)->first();

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

        $a =
            sin($dLat / 2) * sin($dLat / 2) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLng / 2) * sin($dLng / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c;
    }
}
