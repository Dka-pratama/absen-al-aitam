<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TahunAjar;
use App\Models\Semester;

class TahunAjarSeeder extends Seeder
{
    public function run(): void
    {
        // NON-AKTIF (kosong)
        $taNonAktif = TahunAjar::create([
            'tahun' => '2024/2025',
            'status' => 'non-aktif',
        ]);

        Semester::create([
            'tahun_ajar_id' => $taNonAktif->id,
            'name' => 'ganjil',
            'status' => 'non-aktif',
        ]);

        Semester::create([
            'tahun_ajar_id' => $taNonAktif->id,
            'name' => 'genap',
            'status' => 'non-aktif',
        ]);

        // AKTIF (dipakai sistem)
        $taAktif = TahunAjar::create([
            'tahun' => '2025/2026',
            'status' => 'aktif',
        ]);

        Semester::create([
            'tahun_ajar_id' => $taAktif->id,
            'name' => 'ganjil',
            'status' => 'aktif',
        ]);

        Semester::create([
            'tahun_ajar_id' => $taAktif->id,
            'name' => 'genap',
            'status' => 'non-aktif',
        ]);
    }
}
