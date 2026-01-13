<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Semester;
use App\Models\KelasSiswa;
use App\Models\Absensi;
use App\Models\TahunAjar;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class AbsensiController extends Controller
{
    public function index()
{
    $Header = 'Absensi Manual Admin';
    $tahunAktif = TahunAjar::where('status', 'aktif')->firstOrFail();
    $semesterAktif = Semester::where('tahun_ajar_id', $tahunAktif->id)
        ->where('status', 'aktif')
        ->firstOrFail();

    $tanggal = request('tanggal', now()->toDateString());

    $kelasSiswa = KelasSiswa::with(['kelas', 'siswa.user'])
        ->where('tahun_ajar_id', $tahunAktif->id)
        ->with(['absensi' => function ($q) use ($semesterAktif, $tanggal) {
            $q->where('semester_id', $semesterAktif->id)
              ->where('tanggal', $tanggal);
        }])
        ->paginate(10);

    return view('admin.absensi.index', compact(
        'Header',
        'kelasSiswa',
        'semesterAktif',
        'tahunAktif',
        'tanggal'
    ));
}
    public function simpan(Request $request)
{
    $request->validate([
        'tanggal' => 'required|date',
        'status' => 'nullable|array',
    ]);

    $semesterAktif = Semester::where('status', 'aktif')->firstOrFail();
    $tanggal = Carbon::parse($request->tanggal)->toDateString();

    foreach ($request->status ?? [] as $kelasSiswaId => $status) {

        $kelasSiswa = KelasSiswa::find($kelasSiswaId);
        if (!$kelasSiswa) {
            continue;
        }
        $statusFinal = $status ?: 'alpa';

        $absen = Absensi::where('kelas_siswa_id', $kelasSiswaId)
            ->where('tanggal', $tanggal)
            ->where('semester_id', $semesterAktif->id)
            ->first();

        if ($absen) {
            $absen->update([
                'status' => $statusFinal,
                'keterangan' => $request->keterangan[$kelasSiswaId] ?? null,
            ]);
        } else {
            Absensi::create([
                'kelas_siswa_id' => $kelasSiswaId,
                'semester_id' => $semesterAktif->id,
                'tanggal' => $tanggal,
                'status' => $statusFinal,
                'method' => 'manual-admin',
                'waktu_absen' => now()->format('H:i:s'),
                'keterangan' => $request->keterangan[$kelasSiswaId] ?? null,
            ]);
        }
    }

    return back()->with('success', 'Absensi manual oleh admin berhasil disimpan.');
}

    public function toggleAbsensiMandiriGlobal()
    {
        $key = 'absensi_mandiri_global';

        $status = Cache::get($key, false);
        $newStatus = !$status;

        Cache::put($key, $newStatus, now()->addHours(12));

        return back()->with(
            'success',
            'Absensi mandiri GLOBAL ' . ($newStatus ? 'AKTIF' : 'NON-AKTIF')
        );
    }
    public function search(Request $request)
{
    $keyword = $request->search;

    $tahunAktif = TahunAjar::where('status', 'aktif')->firstOrFail();

    $data = KelasSiswa::with(['kelas', 'siswa.user'])
        ->where('tahun_ajar_id', $tahunAktif->id)
        ->when($keyword, function ($q) use ($keyword) {
            $q->whereHas('siswa', function ($s) use ($keyword) {
                $s->where('NISN', 'like', "%$keyword%")
                  ->orWhereHas('user', function ($u) use ($keyword) {
                      $u->where('name', 'like', "%$keyword%");
                  });
            })->orWhereHas('kelas', function ($k) use ($keyword) {
                $k->where('nama_kelas', 'like', "%$keyword%");
            });
        })
        ->limit(20)
        ->get()
        ->map(function ($ks) {
            return [
                'id'    => $ks->id,
                'nama'  => $ks->siswa->user->name ?? '-',
                'kelas' => $ks->kelas->nama_kelas ?? '-',
            ];
        });

    return response()->json($data);
}

}
