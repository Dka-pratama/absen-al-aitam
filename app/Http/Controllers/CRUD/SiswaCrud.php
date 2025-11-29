<?php

namespace App\Http\Controllers\CRUD;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SiswaCrud extends Controller
{
    public function index()
    {
        $siswa = Siswa::with(['user', 'kelas'])->get();
        return view('admin.siswa.index', compact('siswa'));
    }

    public function show($id)
    {
        $siswa = Siswa::with('kelas', 'user')->findOrFail($id);
        return view('crud.siswa.show', compact('siswa'));
    }

    public function destroy($id)
    {
        $siswa = Siswa::findOrFail($id);
        $siswa->delete();
        return redirect()->route('siswa.index')->with('success', 'Akun Siswa berhasil dihapus.');
    }

    public function create()
    {
        $kelas = Kelas::all();
        return view('admin.siswa.create', compact('kelas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'      => 'required',
            'username'  => 'required|unique:users',
            'password'  => 'required',
            'NISN'      => 'required|unique:siswa',
            'kelas_id'  => 'required'
        ]);

        $user = User::create([
            'nama'     => $request->nama,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role'     => 'siswa',
        ]);

        Siswa::create([
            'NISN'     => $request->NISN,
            'kelas_id' => $request->kelas_id,
            'user_id'  => $user->id,
        ]);

        return redirect()->route('siswa.index')->with('success', 'Akun Siswa berhasil dibuat.');
    }

    public function edit($id)
    {
        $siswa = Siswa::with('user')->findOrFail($id);
        $kelas = Kelas::all();
        return view('admin.siswa.edit', compact('siswa','kelas'));
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
