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
        $siswa = Siswa::with(['user', 'kelasSiswa.kelas'])
            ->whereHas('kelasSiswa.tahunAjar', function ($q) {
                $q->where('status', 'aktif');
            })
            ->paginate(15);
        return view('admin.siswa.index', compact('siswa', 'Header'));
    }
    public function search(Request $r)
    {
        $keyword = $r->search;

        $data = Siswa::with(['user', 'kelas'])
            ->where('NISN', 'like', "%$keyword%")
            ->orWhereHas('user', function ($q) use ($keyword) {
                $q->where('name', 'like', "%$keyword%")->orWhere('username', 'like', "%$keyword%");
            })
            ->orWhereHas('kelas', function ($q) use ($keyword) {
                $q->where('nama_kelas', 'like', "%$keyword%");
            })
            ->paginate(15);

        return response()->json($data);
    }

    public function show($id)
    {
        $Header = 'Data Siswa';
        // Ambil siswa beserta relasinya
        $siswa = Siswa::with(['user', 'kelas', 'absensi'])->findOrFail($id);

        // Hitung jumlah absensi berdasarkan status
        $hadir = $siswa->absensi->where('status', 'hadir')->count();
        $sakit = $siswa->absensi->where('status', 'sakit')->count();
        $izin = $siswa->absensi->where('status', 'izin')->count();
        $alpa = $siswa->absensi->where('status', 'alpa')->count();

        return view('admin.siswa.show', compact('siswa', 'Header', 'hadir', 'sakit', 'izin', 'alpa'));
    }

    public function destroy($id)
    {
        $siswa = Siswa::findOrFail($id);

        // Hapus akun user yang terhubung
        if ($siswa->user && $siswa->user->role == 'siswa') {
            $siswa->user->delete();
        }

        // Hapus data siswa
        $siswa->delete();

        return redirect()->route('akun-siswa.index')->with('success', 'Data siswa & akun user berhasil dihapus.');
    }

    public function create()
    {
        $Header = 'Tambah Akun Siswa';
        $kelas = Kelas::all();
        return view('admin.siswa.create', compact('kelas', 'Header'));
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'name' => 'required',
                'username' => 'required|unique:users',
                'password' => 'required',
                'NISN' => 'required|unique:siswa',
                'kelas_id' => 'required',
            ],
            [
                'name.required' => 'Nama lengkap wajib diisi.',
                'username.required' => 'Username wajib diisi.',
                'username.unique' => 'Username sudah digunakan.',
                'password.required' => 'Password wajib diisi.',
                'NISN.required' => 'NISN wajib diisi.',
                'NISN.unique' => 'NISN sudah terdaftar.',
                'kelas_id.required' => 'Kelas wajib dipilih.',
            ],
        );

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

        return redirect()
            ->route('akun-siswa.index')
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
        $user = $siswa->user;

        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'NISN' => 'required|string|max:20|unique:siswa,NISN,' . $siswa->id,
            'kelas_id' => 'required|exists:kelas,id',
        ]);

        // Update User
        $user->update([
            'name' => $request->name,
            'username' => $request->username,
        ]);

        if ($request->password) {
            $user->update([
                'password' => Hash::make($request->password),
            ]);
        }

        // Update NISN
        $siswa->update([
            'NISN' => $request->NISN,
        ]);

        // ================================================
        //       UPDATE KELAS AKTIF DI TABLE PIVOT
        // ================================================

        $tahunAktif = TahunAjar::where('status', 'aktif')->first();

        // Ambil pivot untuk tahun ajar aktif
        $pivot = $siswa->kelasSiswa()->where('tahun_ajar_id', $tahunAktif->id)->first();

        if ($pivot) {
            // Update pivot
            $pivot->update([
                'kelas_id' => $request->kelas_id,
            ]);
        } else {
            // Jika belum ada pivot (kasus tertentu)
            $siswa->kelasSiswa()->create([
                'kelas_id' => $request->kelas_id,
                'tahun_ajar_id' => $tahunAktif->id,
            ]);
        }

        return redirect()->route('akun-siswa.index')->with('success', 'Akun siswa berhasil di update.');
    }
}
