<?php

namespace App\Http\Controllers\Wali;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\QrToken;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QrController extends Controller
{
    // Generate token baru (dipanggil tiap 1 menit oleh AJAX)
    public function generate(Request $request)
    {
        $kelasId = $request->kelas_id;
        $tahunAjarId = $request->tahun_ajar_id;

        // Hapus token lama yg expired
        QrToken::where('expired_at', '<', now()->subSecond())->delete();

        // Buat token acak
        $token = bin2hex(random_bytes(16));

        $qr = QrToken::create([
            'kelas_id' => $kelasId,
            'tahun_ajar_id' => $tahunAjarId,
            'token' => $token,
            'expired_at' => now()->addMinutes(1), // Token berlaku 1 menit
        ]);

        // Buat QR (base64)
        $qrBase64 = base64_encode(QrCode::format('svg')->size(300)->generate($token));

        return [
            'token' => $token,
            'qr' => $qrBase64,
        ];
    }
}
