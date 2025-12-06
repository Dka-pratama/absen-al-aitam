<?php

namespace App\Http\Controllers\CRUD;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TahunAjar as Tahun;
use App\Models\Absensi;
use App\Models\Kelas;

class TahunCrud extends Controller
{
    public function index()
    {
        $Header = 'Data Tahun Ajaran';
        $tahun = Tahun::orderBy('created_at', 'desc')->paginate(15);
        return view('admin.tahun.index', compact('tahun', 'Header'));
    }

    public function show($id)
    {
        $Header = 'Detail Tahun Ajaran';
        $tahunAjar = Tahun::findOrFail($id);

        // Ambil semua baris pivot kelas_siswa milik tahun ajar ini
        $kelasSiswaIds = \DB::table('kelas_siswa')->where('tahun_ajar_id', $id)->pluck('id'); // ← ambil ID pivot (kelas_siswa_id)

        // Statistik absensi berdasarkan pivot kelas_siswa_id
        $stats = [
            'hadir' => Absensi::whereIn('kelas_siswa_id', $kelasSiswaIds)->where('status', 'hadir')->count(),
            'izin' => Absensi::whereIn('kelas_siswa_id', $kelasSiswaIds)->where('status', 'izin')->count(),
            'sakit' => Absensi::whereIn('kelas_siswa_id', $kelasSiswaIds)->where('status', 'sakit')->count(),
            'alfa' => Absensi::whereIn('kelas_siswa_id', $kelasSiswaIds)->where('status', 'alfa')->count(),
        ];

        // Rekap Per Kelas
        $rekapKelas = Kelas::get()->map(function ($k) use ($id) {
            // Ambil semua pivot kelas_siswa untuk kelas tersebut & tahun ajar tersebut
            $pivotIds = \DB::table('kelas_siswa')->where('kelas_id', $k->id)->where('tahun_ajar_id', $id)->pluck('id');

            // Hitung absensi untuk pivot itu
            $k->absensi_count = Absensi::whereIn('kelas_siswa_id', $pivotIds)->count();

            // Hitung jumlah siswa juga
            $k->siswa_count = $pivotIds->count();

            return $k;
        });

        return view('admin.tahun.show', compact('Header', 'tahunAjar', 'stats', 'rekapKelas'));
    }

    public function activate($id)
    {
        // Nonaktifkan semua
        Tahun::where('status', 'aktif')->update(['status' => 'nonaktif']);

        $tahunAjar = Tahun::findOrFail($id);
        $tahunAjar->update(['status' => 'aktif']);

        return redirect()->back()->with('success', 'Tahun ajar berhasil diaktifkan.');
    }

    public function deactivate($id)
    {
        $tahunAjar = Tahun::findOrFail($id);

        if ($tahunAjar->status == 'aktif') {
            $tahunAjar->update(['status' => 'nonaktif']);
        }

        return redirect()->back()->with('success', 'Tahun ajar berhasil dinonaktifkan.');
    }

    public function destroy($id)
    {
        $tahun = Tahun::findOrFail($id);
        $tahun->delete();
        return redirect()->route('tahun.index')->with('success', 'Tahun deleted successfully.');
    }

    public function create()
    {
        $Header = 'Tambah Tahun Ajaran';
        return view('admin.tahun.create', compact('Header'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tahun' => 'required|string|max:20',
            'semester' => 'required|in:Ganjil,Genap',
            'status' => 'required|in:Aktif,Non-Aktif',
        ]);

        // Jika status aktif, nonaktifkan semua tahun ajar lain
        if ($request->status === 'Aktif') {
            Tahun::where('status', 'Aktif')->update(['status' => 'Non-Aktif']);
        }

        Tahun::create($request->all());

        return redirect()->route('tahun.index')->with('success', 'Tahun ajar berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $tahunAjar = Tahun::findOrFail($id);
        return view('admin.tahun.edit', compact('tahunAjar'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tahun' => 'required|string|max:20',
            'semester' => 'required|in:Ganjil,Genap',
            'status' => 'required|in:Aktif,Non-Aktif',
        ]);

        $tahunAjar = Tahun::findOrFail($id);

        // Jika status aktif, nonaktifkan yang lain
        if ($request->status === 'Aktif') {
            Tahun::where('id', '!=', $id)
                ->where('status', 'Aktif')
                ->update(['status' => 'Non-Aktif']);
        }

        $tahunAjar->update($request->all());

        return redirect()->route('tahun.index')->with('success', 'Tahun ajar berhasil diperbarui.');
    }
}
