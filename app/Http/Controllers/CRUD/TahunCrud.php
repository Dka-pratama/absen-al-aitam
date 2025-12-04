<?php

namespace App\Http\Controllers\CRUD;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TahunAjar as Tahun;

class TahunCrud extends Controller
{
    public function index()
    {
        $Header = 'Data Tahun Ajaran';
        $tahun = Tahun::all();
        return view('admin.tahun.index', compact('tahun', 'Header'));
    }

    public function show($id)
    {
        $tahun = Tahun::findOrFail($id);
        return view('crud.tahun.show', compact('tahun'));
    }

    public function destroy($id)
    {
        $tahun = Tahun::findOrFail($id);
        $tahun->delete();
        return redirect()->route('tahun.index')->with('success', 'Tahun deleted successfully.');
    }

    public function create()
    {
        return view('crud.tahun.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tahun_ajaran' => 'required|string|max:255|unique:tahun_ajars,tahun_ajaran',
            'status' => 'required|in:active,inactive',
        ]);

        Tahun::create($request->all());

        return redirect()->route('tahun.index')->with('success', 'Tahun created successfully.');
    }

    public function edit($id)
    {
        $tahun = Tahun::findOrFail($id);
        return view('crud.tahun.edit', compact('tahun'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tahun_ajaran' => 'required|string|max:255|unique:tahun_ajars,tahun_ajaran,' . $id,
            'status' => 'required|in:active,inactive',
        ]);

        $tahun = Tahun::findOrFail($id);
        $tahun->update($request->all());

        return redirect()->route('tahun.index')->with('success', 'Tahun updated successfully.');
    }
}
