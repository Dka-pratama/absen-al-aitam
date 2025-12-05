<?php

namespace App\Http\Controllers\CRUD;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\KelasSiswa;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\TahunAjar;

class SiswaCrud extends Controller
{
    public function index()
    {
        $Header = 'Data Siswa';
        $siswa = Siswa::with(['user', 'kelasSiswa.kelas'])->whereHas('kelasSiswa.tahunAjar', function ($q) {
            $q->where('status', 'aktif');
        })
            ->get();
        return view('admin.siswa.index', compact('siswa', 'Header'));
    }
    public function search(Request $r)
    {
        $keyword = $r->search;

        $data = Siswa::with(['user', 'kelas'])
            ->where('NISN', 'like', "%$keyword%")
            ->orWhereHas('user', function ($q) use ($keyword) {
                $q->where('name', 'like', "%$keyword%")
                    ->orWhere('username', 'like', "%$keyword%");
            })
            ->orWhereHas('kelas', function ($q) use ($keyword) {
                $q->where('nama_kelas', 'like', "%$keyword%");
            })
            ->get();

        return response()->json($data);
    }

    public function show($id)
    {
        $siswa = Siswa::with('kelas', 'user')->findOrFail($id);
        return view('admin.siswa.show', compact('siswa'));
    }

    public function destroy($id)
    {
        $siswa = Siswa::findOrFail($id);
        $siswa->delete();
        return redirect()->route('siswa.index')->with('success', 'Akun Siswa berhasil dihapus.');
    }

    public function create()
    {
        $Header = 'Tambah Akun Siswa';
        $kelas = Kelas::all();
        return view('admin.siswa.create', compact('kelas', 'Header'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'username' => 'required|unique:users',
            'password' => 'required',
            'NISN' => 'required|unique:siswa',
            'kelas_id' => 'required'
        ]);

        // 1. Buat akun user
        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => 'siswa',
        ]);

        // 2. Masukkan siswa
        $siswa = Siswa::create([
            'NISN' => $request->NISN,
            'user_id' => $user->id,
        ]);

        // 3. Masukkan ke tabel kelas_siswa (relasi siswa ke kelas saat ini)
        KelasSiswa::create([
            'siswa_id' => $siswa->id,
            'kelas_id' => $request->kelas_id,
            'tahun_ajar_id' => TahunAjar::where('status', 'aktif')->first()->id ?? null, // opsional jika ada tahun ajar aktif
        ]);

        return redirect()->route('akun-siswa.index')
            ->with('success', 'Akun Siswa berhasil dibuat & dimasukkan ke kelas.');
    }


    public function edit($id)
    {
        $Header = 'Data Siswa';
        $siswa = Siswa::with(['user', 'kelasSiswa.kelas'])->findOrFail($id);

        $kelasAktif = $siswa->kelasSiswa->last()->kelas->id ?? null;

        $kelasList = Kelas::all();

        return view('admin.siswa.edit', compact('siswa', 'kelasList', 'kelasAktif', 'Header'));
    }


    public function update(Request $request, $id)
    {
        $siswa = Siswa::findOrFail($id);
        $user = User::findOrFail($siswa->user_id);

        $request->validate([
            'nama' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'NISN' => 'required|string|max:20|unique:siswas,nisn,' . $siswa->id,
            'kelas_id' => 'required',
        ]);

        $user->update([
            'nama' => $request->nama,
            'username' => $request->username,
        ]);

        if ($request->password) {
            $user->update([
                'password' => Hash::make($request->password),
            ]);
        }
        $siswa->update([
            'NISN' => $request->NISN,
            'kelas_id' => $request->kelas_id,
        ]);
        return redirect()->route('siswa.index')->with('success', 'Siswa updated successfully.');
    }
}
