<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TahunAjar;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\KelasSiswa;

class KenaikanKelasSeeder extends Seeder
{
    public function run(): void
    {
        $tahunLama = TahunAjar::where('tahun', '2024/2025')->first();
        $tahunBaru = TahunAjar::where('tahun', '2025/2026')->first();

        if (!$tahunLama || !$tahunBaru) return;

        $map = [
            'X'  => 'XI',
            'XI' => 'XII',
        ];

        foreach ($map as $from => $to) {
            $kelasLamaList = Kelas::where('nama_kelas', 'LIKE', "$from %")->get();

            foreach ($kelasLamaList as $kelasLama) {

                $kelasBaru = Kelas::where('nama_kelas', str_replace($from, $to, $kelasLama->nama_kelas))
                    ->first();

                if (!$kelasBaru) continue;

                $siswaList = KelasSiswa::where('kelas_id', $kelasLama->id)
                    ->where('tahun_ajar_id', $tahunLama->id)
                    ->get();

                foreach ($siswaList as $item) {
                    KelasSiswa::firstOrCreate([
                        'siswa_id' => $item->siswa_id,
                        'kelas_id' => $kelasBaru->id,
                        'tahun_ajar_id' => $tahunBaru->id,
                    ]);
                }
            }
        }
    }
}

