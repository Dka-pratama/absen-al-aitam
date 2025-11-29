<?php

namespace App\Http\Controllers\CRUD;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kelas;

class KelasCrud extends Controller
{
    public function index()
    {
        $kelas = Kelas::all();
        return view('crud.kelas.index', compact('kelas'));
    }

    public function show($id)
    {
        $kelas = Kelas::findOrFail($id);
        return view('crud.kelas.show', compact('kelas'));
    }

    public function destroy($id)
    {
        $kelas = Kelas::findOrFail($id);
        $kelas->delete();
        return redirect()->route('kelas.index')->with('success', 'Kelas deleted successfully.');
    }

    public function create()
    {
        return view('crud.kelas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kelas' => 'required|string|max:255',
            'kompetensi_keahlian' => 'required|string|max:255',
        ]);

        Kelas::create($request->all());

        return redirect()->route('kelas.index')->with('success', 'Kelas created successfully.');
    }

    public function edit($id)
    {
        $kelas = Kelas::findOrFail($id);
        return view('crud.kelas.edit', compact('kelas'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_kelas' => 'required|string|max:255',
            'kompetensi_keahlian' => 'required|string|max:255',
        ]);

        $kelas = Kelas::findOrFail($id);
        $kelas->update($request->all());

        return redirect()->route('kelas.index')->with('success', 'Kelas updated successfully.');
    }
}
