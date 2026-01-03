<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kelas;

class KelasSeeder extends Seeder
{
    public function run(): void
    {
        foreach (['RPL', 'TKJ', 'MM'] as $jurusan) {
            foreach (['X', 'XI', 'XII'] as $tingkat) {
                Kelas::firstOrCreate(
                    [
                        'nama_kelas' => "$tingkat $jurusan 1",
                        'jurusan' => $jurusan,
                    ],
                    [
                        'angkatan' => null,
                    ],
                );
            }
        }
    }
}
