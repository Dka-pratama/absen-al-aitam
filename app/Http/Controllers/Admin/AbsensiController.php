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
use App\Models\PengaturanAbsensi;


class AbsensiController extends Controller
{
    public function index()
    {
        $Header = 'Data Absensi Manual';
        $settingLokasi = PengaturanAbsensi::first();

        $tahunAktif = TahunAjar::where('status', 'aktif')->firstOrFail();
        $semesterAktif = Semester::where('status', 'aktif')->firstOrFail();

        $hariIni = now()->toDateString();

$kelasSiswa = KelasSiswa::with([
    'kelas',
    'siswa.user',
    'absensi' => function ($q) use ($semesterAktif, $hariIni) {
        $q->where('semester_id', $semesterAktif->id)
          ->where('tanggal', $hariIni);
    },
])
->where('tahun_ajar_id', $tahunAktif->id)
->paginate(10);


        return view(
    'admin.absensi.index',
    compact('kelasSiswa', 'semesterAktif', 'Header', 'settingLokasi')
);

    }

    public function simpan(Request $request)
{
    $request->validate([
        'status' => 'nullable|array',
    ]);

    $semesterAktif = Semester::where('status', 'aktif')->firstOrFail();
    $tanggalHariIni = now()->toDateString();

    foreach ($request->status ?? [] as $kelasSiswaId => $status) {

        $kelasSiswa = KelasSiswa::find($kelasSiswaId);
        if (!$kelasSiswa) {
            continue;
        }

        $statusFinal = $status ?: 'alpa';

        Absensi::updateOrCreate(
            [
                'kelas_siswa_id' => $kelasSiswaId,
                'tanggal' => $tanggalHariIni,
                'semester_id' => $semesterAktif->id,
            ],
            [
                'status' => $statusFinal,
                'method' => 'manual-admin',
                'waktu_absen' => now()->format('H:i:s'),
                'keterangan' => $request->keterangan[$kelasSiswaId] ?? null,
            ]
        );
    }

    return back()->with('success', 'Absensi berhasil diperbarui (real-time).');
}


    public function toggleAbsensiMandiriGlobal()
    {
        $key = 'absensi_mandiri_global';

        $status = Cache::get($key, false);
        $newStatus = !$status;

        Cache::put($key, $newStatus, now()->addHours(12));

        return back()->with('success', 'Absensi mandiri GLOBAL ' . ($newStatus ? 'AKTIF' : 'NON-AKTIF'));
    }
    public function search(Request $request)
    {
        $keyword = $request->search;

        $tahunAktif = TahunAjar::where('status', 'aktif')->firstOrFail();

        $data = KelasSiswa::with(['kelas', 'siswa.user'])
            ->where('tahun_ajar_id', $tahunAktif->id)
            ->when($keyword, function ($q) use ($keyword) {
                $q->whereHas('siswa', function ($s) use ($keyword) {
                    $s->where('NIS', 'like', "%$keyword%")->orWhereHas('user', function ($u) use ($keyword) {
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
                    'id' => $ks->id,
                    'nama' => $ks->siswa->user->name ?? '-',
                    'kelas' => $ks->kelas->nama_kelas ?? '-',
                ];
            });

        return response()->json($data);
    }
    public function simpanLokasiAbsensi(Request $request)
{
    $request->validate([
        'lat_sekolah'   => 'required|numeric',
        'lng_sekolah'   => 'required|numeric',
        'radius_meter' => 'required|integer|min:1',
    ]);

    // Ambil record pertama (karena setting bersifat global)
    $setting = PengaturanAbsensi::first();

    if (!$setting) {
        // kalau belum ada, buat baru
        $setting = PengaturanAbsensi::create([
            'lat_sekolah'   => $request->lat_sekolah,
            'lng_sekolah'   => $request->lng_sekolah,
            'radius_meter' => $request->radius_meter,
        ]);
    } else {
        // kalau sudah ada, update
        $setting->update([
            'lat_sekolah'   => $request->lat_sekolah,
            'lng_sekolah'   => $request->lng_sekolah,
            'radius_meter' => $request->radius_meter,
        ]);
    }

    return back()->with('success', 'Lokasi absensi berhasil diperbarui');
}

}
