<?php

namespace App\Http\Controllers\CRUD;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TahunAjar as Tahun;
use App\Models\Absensi;
use App\Models\Kelas;
use App\Models\Semester;
use Illuminate\Support\Facades\DB;

class TahunCrud extends Controller
{
    public function index()
    {
        $Header = 'Data Tahun Ajaran';
        $semester = Semester::with('tahunAjar')->orderBy('created_at', 'desc')->paginate(15);
        return view('admin.tahun.index', compact('semester', 'Header'));
    }

    public function show($id)
    {
        $Header = 'Detail Tahun Ajaran';
        $semester = Semester::with('tahunAjar')->findOrFail($id);

        $tahunAjarId = $semester->tahun_ajar_id;
        $semesterId = $semester->id;
        $kelasSiswaIds = \DB::table('kelas_siswa')->where('tahun_ajar_id', $id)->pluck('id'); // ← ambil ID pivot (kelas_siswa_id)

        // Statistik absensi berdasarkan pivot kelas_siswa_id
        $stats = [
            'hadir' => Absensi::whereIn('kelas_siswa_id', $kelasSiswaIds)->where('status', 'hadir')->count(),
            'izin' => Absensi::whereIn('kelas_siswa_id', $kelasSiswaIds)->where('status', 'izin')->count(),
            'sakit' => Absensi::whereIn('kelas_siswa_id', $kelasSiswaIds)->where('status', 'sakit')->count(),
            'alfa' => Absensi::whereIn('kelas_siswa_id', $kelasSiswaIds)->where('status', 'alfa')->count(),
        ];

        // Rekap Per Kelas
        $rekapKelas = Kelas::get()->map(function ($k) use ($tahunAjarId, $semesterId) {
            $pivotIds = \DB::table('kelas_siswa')
                ->where('kelas_id', $k->id)
                ->where('tahun_ajar_id', $tahunAjarId)
                ->pluck('id');

            $k->absensi_count = Absensi::whereIn('kelas_siswa_id', $pivotIds)
                ->where('semester_id', $semesterId)
                ->count();

            $k->siswa_count = $pivotIds->count();

            return $k;
        });

        return view('admin.tahun.show', compact('Header', 'semester', 'stats', 'rekapKelas'));
    }

    public function activate($id)
    {
        DB::transaction(function () use ($id) {
            // 1. Nonaktifkan semua semester
            Semester::where('status', 'aktif')->update(['status' => 'non-aktif']);

            // 2. Ambil semester target
            $semester = Semester::with('tahunAjar')->findOrFail($id);

            // 3. Aktifkan semester
            $semester->update(['status' => 'aktif']);

            // 4. Nonaktifkan semua tahun ajar
            Tahun::where('status', 'aktif')->update(['status' => 'non-aktif']);

            // 5. Aktifkan tahun ajar milik semester
            $semester->tahunAjar->update(['status' => 'aktif']);
        });

        return back()->with('success', 'Semester & Tahun Ajar berhasil diaktifkan.');
    }

    public function deactivate($id)
    {
        DB::transaction(function () use ($id) {
            $tahunAjar = Tahun::findOrFail($id);

            if ($tahunAjar->status === 'aktif') {
                // 1. Nonaktifkan tahun ajar
                $tahunAjar->update(['status' => 'non-aktif']);

                // 2. Nonaktifkan semua semester miliknya
                Semester::where('tahun_ajar_id', $id)->update(['status' => 'non-aktif']);
            }
        });

        return back()->with('success', 'Tahun ajar & semester berhasil dinonaktifkan.');
    }

    public function destroy($id)
    {
        $tahun = Tahun::with('semesters')->findOrFail($id);

        // 1. Tidak boleh hapus kalau tinggal 1
        if (Tahun::count() <= 1) {
            return back()->with('error', 'Tidak bisa dihapus, minimal harus ada 1 tahun ajar.');
        }

        // 2. Tidak boleh hapus tahun ajar aktif
        if ($tahun->status === 'aktif') {
            return back()->with('error', 'Tidak bisa menghapus tahun ajar yang sedang aktif.');
        }

        $tahun->delete();

        return redirect()->route('tahun.index')->with('success', 'Tahun ajar berhasil dihapus.');
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
            'status' => 'required|in:aktif,non-aktif',
        ]);

        if ($request->status === 'aktif') {
            Tahun::where('status', 'aktif')->update(['status' => 'non-aktif']);
        }

        $tahunAjar = Tahun::create([
            'tahun' => $request->tahun,
            'status' => $request->status,
        ]);

        Semester::create([
            'tahun_ajar_id' => $tahunAjar->id,
            'name' => 'ganjil',
            'status' => 'aktif',
        ]);

        Semester::create([
            'tahun_ajar_id' => $tahunAjar->id,
            'name' => 'genap',
            'status' => 'non-aktif',
        ]);

        return redirect()->route('tahun.index')->with('success', 'Tahun ajar berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $Header = 'Edit Tahun Ajar';
        $tahunAjar = Tahun::findOrFail($id);
        return view('admin.tahun.edit', compact('tahunAjar', 'Header'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tahun' => 'required|string|max:20',
            'status' => 'required|in:Aktif,Non-Aktif',
        ]);

        $tahunAjar = Tahun::findOrFail($id);

        if ($request->status === 'Aktif') {
            Tahun::where('id', '!=', $id)
                ->where('status', 'Aktif')
                ->update(['status' => 'Non-Aktif']);
        }

        $tahunAjar->update($request->all());

        return redirect()->route('tahun.index')->with('success', 'Tahun ajar berhasil diperbarui.');
    }
}
