<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Absensi;
use App\Models\QrToken;
use App\Models\KelasSiswa;
use Carbon\Carbon;

class ScanController extends Controller
{
    public function scan(Request $request)
    {
        $token = $request->token;
        $userId = auth()->id();

        $qr = QrToken::where('token', $token)->where('expired_at', '>', now())->where('used', false)->first();

        if (!$qr) {
            return response()->json(['status' => 'error', 'msg' => 'QR tidak valid atau sudah expired'], 400);
        }

        // Ambil kelas_siswa_id siswa yg scan
        $kelasSiswa = KelasSiswa::where('siswa_id', $userId)
            ->where('kelas_id', $qr->kelas_id)
            ->where('tahun_ajar_id', $qr->tahun_ajar_id)
            ->first();

        if (!$kelasSiswa) {
            return response()->json(['status' => 'error', 'msg' => 'Anda bukan siswa kelas ini'], 403);
        }

        // Tandai hadir
        Absensi::updateOrCreate(
            [
                'kelas_siswa_id' => $kelasSiswa->id,
                'tanggal' => Carbon::today()->toDateString(),
            ],
            [
                'status' => 'hadir',
            ],
        );

        // Token langsung dianggap terpakai
        $qr->update(['used' => true]);

        return ['status' => 'success', 'msg' => 'Absensi berhasil'];
    }
}
