<?php

namespace App\Http\Controllers\CRUD;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Absensi;

class AbsensiCrud extends Controller
{
    public function index(Request $request)
    {

        $Header = 'Data Absensi';
        $kelasId = $request->kelas_id;
        $tahunAjarId = $request->tahun_ajar_id;
        $tanggal = $request->tanggal;

        $absensi = \DB::table('absensi')
            ->join('kelas_siswa', 'absensi.kelas_siswa_id', '=', 'kelas_siswa.id')
            ->join('kelas', 'kelas_siswa.kelas_id', '=', 'kelas.id')
            ->join('wali_kelas', 'wali_kelas.kelas_id', '=', 'kelas.id')
            ->join('tahun_ajar', 'wali_kelas.tahun_ajar_id', '=', 'tahun_ajar.id')
            ->select(
                'absensi.tanggal',
                'kelas.id as kelas_id',
                'kelas.nama_kelas',
                'tahun_ajar.id as tahun_ajar_id',
                'tahun_ajar.tahun',
                'tahun_ajar.semester'
            )
            ->when($kelasId, function ($q) use ($kelasId) {
                $q->where('kelas.id', $kelasId);
            })
            ->when($tahunAjarId, function ($q) use ($tahunAjarId) {
                $q->where('tahun_ajar.id', $tahunAjarId);
            })
            ->when($tanggal, function ($q) use ($tanggal) {
                $q->where('absensi.tanggal', $tanggal);
            })
            ->groupBy(
                'absensi.tanggal',
                'kelas.id',
                'kelas.nama_kelas',
                'tahun_ajar.id',
                'tahun_ajar.tahun',
                'tahun_ajar.semester'
            )
            ->orderBy('absensi.tanggal', 'desc')
            ->get();

        $kelas = \App\Models\Kelas::all();
        $tahunAjar = \App\Models\TahunAjar::all();

        return view('admin.absensi.index', compact(
            'absensi', 
            'kelas', 
            'tahunAjar', 
            'Header'));
    }


    public function show($id)
    {
        $absensi = Absensi::findOrFail($id);
        return view('admin.absensi.show', compact('absensi'));
    }

    public function destroy($id)
    {
        $absensi = Absensi::findOrFail($id);
        $absensi->delete();
        return redirect()->route('absensi.index')->with('success', 'Absensi deleted successfully.');
    }


}
