<?php

namespace App\Http\Controllers\Wali;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Semester;
use Illuminate\Support\Facades\Auth;
use App\Models\WaliKelas;
use App\Models\KelasSiswa;
use App\Models\Absensi;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class SiswaController extends Controller
{
    public function index()
    {
        $Header = 'Data Siswa';

        $wali = WaliKelas::where('user_id', Auth::id())->firstOrFail();

        $semesterAktif = Semester::where('status', 'aktif')->firstOrFail();
        $tahunAjarAktif = $semesterAktif->tahunAjar; // relasi

        $dataSiswa = $this->getDataSiswa($wali);

        return view('wali.siswa.index', compact('dataSiswa', 'wali', 'semesterAktif', 'tahunAjarAktif', 'Header'));
    }

    public function exportExcel($waliId)
    {
        $wali = WaliKelas::findOrFail($waliId);
        $siswaData = $this->getDataSiswa($wali);
        $semesterAktif = Semester::where('status', 'aktif')->first();
        $exportData = [
            ['Kelas', $wali->kelas->nama_kelas],
            ['Wali Kelas', $wali->user->name],
            ['Tahun Ajar', $wali->tahunAjar->tahun . ' - ' . $semesterAktif->name],
            [],
            ['No', 'Nama Siswa', 'NISN', 'Hadir', 'Izin', 'Sakit', 'Alpa'],
        ];

        foreach ($siswaData as $i => $s) {
            $exportData[] = [$i + 1, $s['nama'], $s['nisn'], $s['hadir'], $s['izin'], $s['sakit'], $s['alpa']];
        }

        $kelasNama = preg_replace('/[\/\\\\:]/', '-', $wali->kelas->nama_kelas);
        $tahun = preg_replace('/[\/\\\\:]/', '-', $wali->tahunAjar->tahun);
        $filename = "Absensi-{$kelasNama}-{$tahun}.xlsx";

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
            $filename,
        );
    }

    public function exportPdf()
    {
        $semesterAktif = Semester::where('status', 'aktif')->first();
        $wali = WaliKelas::with('user', 'kelas', 'tahunAjar')
            ->where('user_id', Auth::id())
            ->where('tahun_ajar_id', $semesterAktif->tahun_ajar_id)
            ->firstOrFail();
        $semesterAktif = Semester::where('status', 'aktif')->firstOrFail();
        $tahunAjarAktif = $semesterAktif->tahunAjar;
        $dataSiswa = $this->getDataSiswa($wali);

        $pdf = Pdf::loadView('wali.siswa.pdf', compact('dataSiswa', 'wali', 'tahunAjarAktif', 'semesterAktif'));
        return $pdf->download('absensi_siswa.pdf');
    }

    private function getDataSiswa(WaliKelas $wali)
    {
        $semesterAktif = Semester::where('status', 'aktif')->firstOrFail();

        $kelasSiswaIds = KelasSiswa::where('kelas_id', $wali->kelas_id)
            ->where('tahun_ajar_id', $wali->tahun_ajar_id)
            ->pluck('id');

        $siswa = KelasSiswa::with('siswa.user')->whereIn('id', $kelasSiswaIds)->get();

        $data = [];
        foreach ($siswa as $ks) {
            $absensi = Absensi::where('kelas_siswa_id', $ks->id)->where('semester_id', $semesterAktif->id)->get();

            $data[] = [
                'nama' => $ks->siswa->user->name,
                'nisn' => $ks->siswa->NISN,
                'hadir' => $absensi->where('status', 'hadir')->count(),
                'izin' => $absensi->where('status', 'izin')->count(),
                'sakit' => $absensi->where('status', 'sakit')->count(),
                'alpa' => $absensi->where('status', 'alpa')->count(),
            ];
        }

        return $data;
    }
}
