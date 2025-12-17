<?php

namespace App\Http\Controllers\CRUD;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Absensi;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class AbsensiCrud extends Controller
{
    public function index(Request $request)
    {
        $Header = 'Data Absensi';

        $kelasId = $request->kelas_id;
        $tahunAjarId = $request->tahun_ajar_id;
        $semesterId = $request->semester_id;
        $tanggal = $request->tanggal;

        $absensi = \DB::table('absensi')
            ->join('kelas_siswa', 'absensi.kelas_siswa_id', '=', 'kelas_siswa.id')
            ->join('kelas', 'kelas_siswa.kelas_id', '=', 'kelas.id')
            ->join('wali_kelas', 'wali_kelas.kelas_id', '=', 'kelas.id')
            ->join('tahun_ajar', 'wali_kelas.tahun_ajar_id', '=', 'tahun_ajar.id')
            ->join('semester', 'absensi.semester_id', '=', 'semester.id')
            ->select(
                'absensi.id',
                'absensi.tanggal',
                'kelas.id as kelas_id',
                'kelas.nama_kelas',
                'tahun_ajar.id as tahun_ajar_id',
                'tahun_ajar.tahun',
                'semester.id as semester_id',
                'semester.name as semester',
            )
            ->when($kelasId, fn($q) => $q->where('kelas.id', $kelasId))
            ->when($tahunAjarId, fn($q) => $q->where('tahun_ajar.id', $tahunAjarId))
            ->when($semesterId, fn($q) => $q->where('semester.id', $semesterId))
            ->when($tanggal, fn($q) => $q->where('absensi.tanggal', $tanggal))
            ->groupBy(
                'absensi.id',
                'absensi.tanggal',
                'kelas.id',
                'kelas.nama_kelas',
                'tahun_ajar.id',
                'tahun_ajar.tahun',
                'semester.id',
                'semester.name',
            )
            ->orderBy('absensi.tanggal', 'desc')
            ->paginate(15);

        $kelas = \App\Models\Kelas::all();
        $tahunAjar = \App\Models\TahunAjar::all();
        $semester = \App\Models\Semester::all();

        return view('admin.absensi.index', compact('absensi', 'kelas', 'tahunAjar', 'semester', 'Header'));
    }

    private function getAbsensiFullData($id)
    {
        // Data utama
        $absen = \DB::table('absensi')
            ->join('kelas_siswa', 'absensi.kelas_siswa_id', '=', 'kelas_siswa.id')
            ->join('kelas', 'kelas_siswa.kelas_id', '=', 'kelas.id')
            ->join('wali_kelas', 'wali_kelas.kelas_id', '=', 'kelas.id')
            ->join('tahun_ajar', 'wali_kelas.tahun_ajar_id', '=', 'tahun_ajar.id')
            ->join('semester', 'absensi.semester_id', '=', 'semester.id')
            ->select(
                'absensi.*',
                'kelas.id as kelas_id',
                'kelas.nama_kelas',
                'tahun_ajar.id as tahun_ajar_id',
                'tahun_ajar.tahun',
                'semester.id as semester_id',
                'semester.name as semester',
            )
            ->where('absensi.id', $id)
            ->first();

        // Detail siswa
        $detail = \DB::table('absensi')
            ->join('kelas_siswa', 'absensi.kelas_siswa_id', '=', 'kelas_siswa.id')
            ->join('siswa', 'kelas_siswa.siswa_id', '=', 'siswa.id')
            ->join('users', 'siswa.user_id', '=', 'users.id')
            ->select('users.name', 'siswa.NISN', 'absensi.status')
            ->whereDate('absensi.tanggal', $absen->tanggal)
            ->where('kelas_siswa.kelas_id', $absen->kelas_id)
            ->where('absensi.semester_id', $absen->semester_id) // 🔥 WAJIB
            ->get();

        return (object) [
            'absen' => $absen,
            'detail' => $detail,
        ];
    }

    public function show($id)
    {
        $data = $this->getAbsensiFullData($id);
        $Header = 'Detail Absensi Kelas';
        return view(
            'admin.absensi.show',
            [
                'absen' => $data->absen,
                'detail' => $data->detail,
            ],
            compact('Header'),
        );
    }

    public function exportExcel($id)
    {
        $data = $this->getAbsensiFullData($id);
        $absen = $data->absen;
        $detail = $data->detail;

        $exportData = [
            ['Tanggal', $absen->tanggal],
            ['Kelas', $absen->nama_kelas],
            ['Tahun Ajar', $absen->tahun . ' - ' . $absen->semester],
            [],
            ['No', 'Nama Siswa', 'NISN', 'Status'],
        ];

        foreach ($detail as $i => $d) {
            $exportData[] = [$i + 1, $d->name, $d->NISN, ucfirst($d->status)];
        }

        return Excel::download(
            new class ($exportData) implements \Maatwebsite\Excel\Concerns\FromArray {
                protected $data;
                public function __construct($data)
                {
                    $this->data = $data;
                }
                public function array(): array
                {
                    return $this->data;
                }
            },
            "Absensi-{$absen->nama_kelas}-{$absen->tanggal}.xlsx",
        );
    }

    public function exportPDF($id)
    {
        $data = $this->getAbsensiFullData($id);

        $pdf = Pdf::loadView('admin.absensi.export-pdf', [
            'absen' => $data->absen,
            'detail' => $data->detail,
        ]);

        return $pdf->stream("Absensi-{$data->absen->nama_kelas}-{$data->absen->tanggal}.pdf");
    }

    public function destroy($id)
    {
        $absensi = Absensi::findOrFail($id);
        $absensi->delete();
        return redirect()->route('absensi.index')->with('success', 'Absensi deleted successfully.');
    }
}
