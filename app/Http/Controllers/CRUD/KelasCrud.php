<?php

namespace App\Http\Controllers\CRUD;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\TahunAjar;
use App\Models\KelasSiswa;
use Illuminate\View\View;

class KelasCrud extends Controller
{
    public function index()
    {
        $Header = 'Data Kelas';
        $kelasList = Kelas::withCount('siswa')->get();
        return view('admin.kelas.index', compact('kelasList', 'Header'));
    }

    public function search(Request $request)
    {
        $keyword = $request->search;

        $kelasList = Kelas::withCount('siswa')
            ->where(function ($q) use ($keyword) {
                $q->where('nama_kelas', 'like', "%$keyword%")
                    ->orWhere('jurusan', 'like', "%$keyword%")
                    ->orWhere('angkatan', 'like', "%$keyword%");
            })
            ->get();

        return response()->json(
            $kelasList->map(function ($k) {
                return [
                    'id' => $k->id,
                    'nama_kelas' => $k->nama_kelas,
                    'jurusan' => $k->jurusan,
                    'angkatan' => $k->angkatan,
                    'siswa_count' => $k->siswa_count,

                    'url_edit' => route('kelas.edit', $k->id),
                    'url_delete' => route('kelas.destroy', $k->id),
                    'url_show' => route('kelas.show', $k->id),
                ];
            }),
        );
    }

    public function show($id)
    {
        $Header = 'Detail Kelas';
        $kelas = Kelas::findOrFail($id);
        $tahunAjarAktif = TahunAjar::where('status', 'aktif')->first();

        $siswa = KelasSiswa::with('siswa.user')
            ->where('kelas_id', $id)
            ->where('tahun_ajar_id', $tahunAjarAktif->id)
            ->get();

        $daftarKelas = Kelas::orderBy('nama_kelas')->get(); // untuk dropdown

        return view('admin.kelas.show', compact('Header', 'kelas', 'siswa', 'tahunAjarAktif', 'daftarKelas'));
    }

    public function naikKelas(Request $request, $id)
    {
        $request->validate([
            'kelas_tujuan' => 'required|exists:kelas,id',
        ]);

        $kelasAsal = Kelas::findOrFail($id);
        $kelasTujuan = Kelas::findOrFail($request->kelas_tujuan);
        $tahunAjarAktif = TahunAjar::where('status', 'aktif')->first();

        $siswa = KelasSiswa::where('kelas_id', $id)->where('tahun_ajar_id', $tahunAjarAktif->id)->get();

        foreach ($siswa as $ks) {
            // pastikan tidak ada data ganda
            KelasSiswa::updateOrCreate(
                [
                    'siswa_id' => $ks->siswa_id,
                    'tahun_ajar_id' => $tahunAjarAktif->id,
                ],
                [
                    'kelas_id' => $kelasTujuan->id,
                ],
            );
        }

        return back()->with('success', 'Semua siswa berhasil dinaikkan ke kelas ' . $kelasTujuan->nama_kelas);
    }

    public function destroy($id)
    {
        $kelas = Kelas::findOrFail($id);
        $kelas->delete();
        return redirect()->route('kelas.index')->with('success', 'Kelas deleted successfully.');
    }

    public function create()
    {
        $Header = 'Tambah Kelas';
        return view('admin.kelas.create', compact('Header'));
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'nama_kelas' => 'required|string|max:255',
                'jurusan' => 'required|string|max:255',
                'angkatan' => 'required|string|max:255',
            ],
            [
                'nama_kelas.required' => 'Nama Kelas harus diisi.',
                'jurusan.required' => 'Jurusan harus diisi.',
                'angkatan.required' => 'Angkatan harus diisi.',
            ],
        );

        Kelas::create($request->all());

        return redirect()->route('kelas.index')->with('success', 'Kelas created successfully.');
    }

    public function edit($id)
    {
        $Header = 'Edit Kelas';
        $kelas = Kelas::findOrFail($id);
        return view('admin.kelas.edit', compact('kelas', 'Header'));
    }

    public function update(Request $request, $id)
    {
        $request->validate(
            [
                'nama_kelas' => 'required|string|max:255',
                'jurusan' => 'required|string|max:255',
                'angkatan' => 'required|string|max:255',
            ],
            [
                'nama_kelas.required' => 'Nama Kelas harus diisi.',
                'jurusan.required' => 'Jurusan harus diisi.',
                'angkatan.required' => 'Angkatan harus diisi.',
            ],
        );

        $kelas = Kelas::findOrFail($id);
        $kelas->update($request->all());

        return redirect()->route('kelas.index')->with('success', 'Kelas updated successfully.');
    }
}
