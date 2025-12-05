<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class KelasSiswaFactory extends Factory
{
    public function definition(): array
    {
        return [
            // 'siswa_id' dibuat oleh SiswaFactory via has()
            'kelas_id'       => \App\Models\Kelas::factory(),
            'tahun_ajar_id'  => \App\Models\TahunAjar::factory(),
        ];
    }
}
