<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kelas;
use App\Models\TahunAjar;
use App\Models\KelasSiswa;
use Illuminate\Support\Facades\DB;

class PromosiKelasController extends Controller
{
    public function index(Request $request)
    {
        $Header = 'Naik Kelas';

        // Tahun ajar aktif
        $tahunAktif = TahunAjar::where('status', 'aktif')->first();
        if (!$tahunAktif) {
            return redirect()->route('tahun.index')->with('error', 'Silakan aktifkan tahun ajar terlebih dahulu.');
        }

        // Semua tahun ajar non-aktif (untuk dropdown)
        $listTahun = TahunAjar::where('status', 'non-aktif')->orderBy('tahun', 'desc')->get();

        // Tahun ajar asal (dipilih user)
        $tahunAsal = TahunAjar::find($request->tahun_asal);

        // Default kosong
        $kelasAsal = collect();

        // Jika tahun asal dipilih → ambil kelas asal
        if ($tahunAsal) {
            $kelasAsal = Kelas::whereHas('kelasSiswa', function ($q) use ($tahunAsal) {
                $q->where('tahun_ajar_id', $tahunAsal->id);
            })->get();
        }

        // Kelas tujuan (tahun aktif & masih kosong)
        $kelasTujuan = Kelas::whereDoesntHave('kelasSiswa', function ($q) use ($tahunAktif) {
            $q->where('tahun_ajar_id', $tahunAktif->id);
        })->get();

        return view(
            'admin.naik-kelas',
            compact('Header', 'tahunAktif', 'listTahun', 'tahunAsal', 'kelasAsal', 'kelasTujuan'),
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'tahun_asal' => 'required|exists:tahun_ajar,id',
            'kelas_asal_id' => 'required|exists:kelas,id',
            'kelas_tujuan_id' => 'required|exists:kelas,id',
        ]);

        // Tahun aktif
        $tahunAktif = TahunAjar::where('status', 'aktif')->first();
        if (!$tahunAktif) {
            return back()->withErrors([
                'tahun' => 'Tahun ajar aktif tidak ditemukan.',
            ]);
        }

        // Tahun asal (dari pilihan user)
        $tahunAsal = TahunAjar::find($request->tahun_asal);

        // Pastikan kelas tujuan masih kosong
        $sudahAda = KelasSiswa::where('kelas_id', $request->kelas_tujuan_id)
            ->where('tahun_ajar_id', $tahunAktif->id)
            ->exists();

        if ($sudahAda) {
            return back()->withErrors([
                'kelas_tujuan_id' => 'Kelas tujuan sudah terisi siswa.',
            ]);
        }

        // Ambil siswa kelas asal di tahun asal
        $siswaList = KelasSiswa::where('kelas_id', $request->kelas_asal_id)
            ->where('tahun_ajar_id', $tahunAsal->id)
            ->get();

        if ($siswaList->isEmpty()) {
            return back()->withErrors([
                'kelas_asal_id' => 'Tidak ada siswa di kelas asal.',
            ]);
        }

        // Promosi siswa
        DB::transaction(function () use ($siswaList, $request, $tahunAktif) {
            foreach ($siswaList as $item) {
                KelasSiswa::create([
                    'siswa_id' => $item->siswa_id,
                    'kelas_id' => $request->kelas_tujuan_id,
                    'tahun_ajar_id' => $tahunAktif->id,
                ]);
            }
        });

        return redirect()->route('kelas.index')->with('success', 'Siswa berhasil dipromosikan.');
    }
}
