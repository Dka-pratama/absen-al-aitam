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
            ->where('nama_kelas', 'like', "%$keyword%")
            ->orWhere('jurusan', 'like', "%$keyword%")
            ->get();

        return response()->json($kelasList);
    }

   public function show($id)
    {
        $kelas = Kelas::findOrFail($id);

        // Ambil tahun ajar aktif
        $tahunAktif = TahunAjar::where('status', 'aktif')->first();

        // Ambil siswa dari pivot pada tahun ajar aktif
        $siswaList = KelasSiswa::where('kelas_id', $id)
            ->where('tahun_ajar_id', $tahunAktif->id)
            ->with('siswa.user')
            ->get();

        $jumlahSiswa = $siswaList->count();

        // Kelas tujuan untuk naik kelas (kecuali dirinya)
        $kelasList = Kelas::where('id', '!=', $kelas->id)->get();

        return view('admin.kelas.show', compact(
            'kelas',
            'siswaList',
            'jumlahSiswa',
            'kelasList',
            'tahunAktif'
        ));
    }

    public function naikkanSiswa(Request $request, $id)
    {
        $request->validate([
            'kelas_tujuan_id' => 'required|exists:kelas,id'
        ]);

        $kelasAsal = Kelas::findOrFail($id);
        $kelasTujuanId = $request->kelas_tujuan_id;

        $tahunAktif = TahunAjar::where('status', 'aktif')->first();

        // Ambil siswa dari kelas asal untuk tahun ajar aktif
        $pivotList = KelasSiswa::where('kelas_id', $kelasAsal->id)
            ->where('tahun_ajar_id', $tahunAktif->id)
            ->get();

        foreach ($pivotList as $pivot) {
            // Buat baris pivot baru untuk kelas tujuan
            KelasSiswa::create([
                'kelas_id'      => $kelasTujuanId,
                'siswa_id'      => $pivot->siswa_id,
                'tahun_ajar_id' => $tahunAktif->id,
            ]);
        }

        return back()->with('success', 'Semua siswa berhasil dinaikkan ke kelas tujuan.');
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
        $request->validate([
            'nama_kelas' => 'required|string|max:255',
            'jurusan' => 'required|string|max:255',
            'angkatan' => 'required|string|max:255',
        ],[
            'nama_kelas.required' => 'Nama Kelas harus diisi.',
            'jurusan.required' => 'Jurusan harus diisi.',
            'angkatan.required' => 'Angkatan harus diisi.',
        ]);

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
        $request->validate([
            'nama_kelas' => 'required|string|max:255',
            'jurusan' => 'required|string|max:255',
            'angkatan' => 'required|string|max:255',
        ],[
            'nama_kelas.required' => 'Nama Kelas harus diisi.',
            'jurusan.required' => 'Jurusan harus diisi.',
            'angkatan.required' => 'Angkatan harus diisi.',
        ]);

        $kelas = Kelas::findOrFail($id);
        $kelas->update($request->all());

        return redirect()->route('kelas.index')->with('success', 'Kelas updated successfully.');
    }
}
