<?php

namespace App\Http\Controllers\Wali;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
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
        $wali = WaliKelas::where('user_id', Auth::id())->firstOrFail();
        $dataSiswa = $this->getDataSiswa($wali);

        return view('wali.siswa.index', compact('dataSiswa', 'wali'));
    }

    public function exportExcel($waliId)
    {
        $wali = WaliKelas::findOrFail($waliId);
        $siswaData = $this->getDataSiswa($wali);

        $exportData = [
            ['Kelas', $wali->kelas->nama_kelas],
            ['Wali Kelas', $wali->user->name],
            ['Tahun Ajar', $wali->tahunAjar->tahun . ' - ' . $wali->tahunAjar->semester],
            [],
            ['No', 'Nama Siswa', 'NISN', 'Hadir', 'Izin', 'Sakit', 'Alpa'],
        ];

        foreach ($siswaData as $i => $s) {
            $exportData[] = [$i + 1, $s['nama'], $s['nisn'], $s['hadir'], $s['izin'], $s['sakit'], $s['alpa']];
        }

        // Hapus semua karakter terlarang di filename
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
        $wali = WaliKelas::where('user_id', Auth::id())->firstOrFail();
        $dataSiswa = $this->getDataSiswa($wali);

        $pdf = Pdf::loadView('wali.siswa.pdf', compact('dataSiswa', 'wali'));
        return $pdf->download('absensi_siswa.pdf');
    }

    private function getDataSiswa(WaliKelas $wali)
    {
        $kelasSiswaIds = KelasSiswa::where('kelas_id', $wali->kelas_id)->pluck('id');

        $siswa = KelasSiswa::with('siswa.user')->whereIn('id', $kelasSiswaIds)->get();

        $data = [];
        foreach ($siswa as $ks) {
            $absensi = Absensi::where('kelas_siswa_id', $ks->id)->get();
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
