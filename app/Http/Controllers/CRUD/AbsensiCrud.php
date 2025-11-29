<?php

namespace App\Http\Controllers\CRUD;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Absensi;

class AbsensiCrud extends Controller
{
    public function index()
    {
        $absensis = Absensi::all();
        return view('crud.absensi.index', compact('absensis'));
    }

    public function show($id)
    {
        $absensi = Absensi::findOrFail($id);
        return view('crud.absensi.show', compact('absensi'));
    }

    public function destroy($id)
    {
        $absensi = Absensi::findOrFail($id);
        $absensi->delete();
        return redirect()->route('absensi.index')->with('success', 'Absensi deleted successfully.');
    }

    
}
