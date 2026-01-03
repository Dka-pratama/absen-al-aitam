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
        $tahun2024 = TahunAjar::where('tahun', '2024/2025')->first();
        $tahun2025 = TahunAjar::where('tahun', '2025/2026')->first();

        foreach (['RPL', 'TKJ', 'MM'] as $jurusan) {
            // X 2024 → XI 2025
            $this->naikKelas('X', 'XI', $jurusan, $tahun2024, $tahun2025);

            // XI 2024 → XII 2025
            $this->naikKelas('XI', 'XII', $jurusan, $tahun2024, $tahun2025);
        }
    }

    private function naikKelas($from, $to, $jurusan, $tahunLama, $tahunBaru)
    {
        $kelasLama = Kelas::where([
            'nama_kelas' => "$from $jurusan 1",
            'angkatan' => '2024',
        ])->first();

        $kelasBaru = Kelas::where([
            'nama_kelas' => "$to $jurusan 1",
            'angkatan' => '2025',
        ])->first();

        if (!$kelasLama || !$kelasBaru) {
            return;
        }

        $siswaList = KelasSiswa::where('kelas_id', $kelasLama->id)->where('tahun_ajar_id', $tahunLama->id)->get();

        foreach ($siswaList as $item) {
            KelasSiswa::firstOrCreate([
                'siswa_id' => $item->siswa_id,
                'kelas_id' => $kelasBaru->id,
                'tahun_ajar_id' => $tahunBaru->id,
            ]);
        }
    }
}
