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
    public function index()
    {
        // Tahun ajar aktif
        $tahunAktif = TahunAjar::where('status', 'aktif')->first();

        if (!$tahunAktif) {
            return redirect()
                ->route('tahun.index')
                ->with('error', 'Silakan aktifkan tahun ajar terlebih dahulu.');
        }

        // Tahun sebelumnya (nonaktif terakhir)
        $tahunSebelumnya = TahunAjar::where('status', 'non-aktif')
            ->orderBy('id', 'desc')
            ->first();

        if (!$tahunSebelumnya) {
            return redirect()
                ->route('kelas.index')
                ->with('error', 'Tidak ada tahun ajar sebelumnya.');
        }

        // Kelas asal: punya siswa di tahun sebelumnya
        $kelasAsal = Kelas::whereHas('kelasSiswa', function ($q) use ($tahunSebelumnya) {
            $q->where('tahun_ajar_id', $tahunSebelumnya->id);
        })->get();

        // Kelas tujuan: BELUM punya siswa di tahun aktif
        $kelasTujuan = Kelas::whereDoesntHave('kelasSiswa', function ($q) use ($tahunAktif) {
            $q->where('tahun_ajar_id', $tahunAktif->id);
        })->get();

        return view('admin.naik-kelas', compact(
            'tahunAktif',
            'tahunSebelumnya',
            'kelasAsal',
            'kelasTujuan'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kelas_asal_id'   => 'required|exists:kelas,id',
            'kelas_tujuan_id' => 'required|exists:kelas,id',
        ]);

        $tahunAktif = TahunAjar::where('status', 'aktif')->first();

        if (!$tahunAktif) {
            return back()->withErrors([
                'tahun' => 'Tahun ajar aktif tidak ditemukan.'
            ]);
        }

        $tahunAsal = TahunAjar::where('status', 'non-aktif')
            ->orderBy('id', 'desc')
            ->first();

        if (!$tahunAsal) {
            return back()->withErrors([
                'tahun' => 'Tahun ajar asal tidak ditemukan.'
            ]);
        }

        $sudahAda = KelasSiswa::where('kelas_id', $request->kelas_tujuan_id)
            ->where('tahun_ajar_id', $tahunAktif->id)
            ->exists();

        if ($sudahAda) {
            return back()->withErrors([
                'kelas_tujuan_id' => 'Kelas tujuan sudah terisi siswa.'
            ]);
        }
        $siswaList = KelasSiswa::where('kelas_id', $request->kelas_asal_id)
            ->where('tahun_ajar_id', $tahunAsal->id)
            ->get();

        if ($siswaList->isEmpty()) {
            return back()->withErrors([
                'kelas_asal_id' => 'Tidak ada siswa di kelas asal.'
            ]);
        }

        DB::transaction(function () use ($siswaList, $request, $tahunAktif) {
            foreach ($siswaList as $item) {
                KelasSiswa::create([
                    'siswa_id'      => $item->siswa_id,
                    'kelas_id'      => $request->kelas_tujuan_id,
                    'tahun_ajar_id' => $tahunAktif->id,
                ]);
            }
        });

        return redirect()
            ->route('kelas.index')
            ->with('success', 'Siswa berhasil dipromosikan ke kelas baru.');
    }
}