<?php

namespace App\Http\Controllers\CRUD;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kelas;

class KelasCrud extends Controller
{
    public function index()
    {
        $Header = 'Data Kelas';
        $kelasList = Kelas::withCount('siswa')->get();
        return view('admin.kelas.index', compact('kelasList','Header'));
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
        return view('admin.kelas.show', compact('kelas'));
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
        ]);

        Kelas::create($request->all());

        return redirect()->route('kelas.index')->with('success', 'Kelas created successfully.');
    }

    public function edit($id)
    {
        $Header = 'Edit Kelas';
        $kelas = Kelas::findOrFail($id);
        return view('admin.kelas.edit', compact('kelas','Header'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_kelas' => 'required|string|max:255',
            'jurusan' => 'required|string|max:255',
            'angkatan' => 'required|string|max:255',
        ]);

        $kelas = Kelas::findOrFail($id);
        $kelas->update($request->all());

        return redirect()->route('kelas.index')->with('success', 'Kelas updated successfully.');
    }
}
