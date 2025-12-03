<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\KelasSiswa>
 */
class KelasSiswaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'siswa_id' => \App\Models\Siswa::factory(),
            'kelas_id' => \App\Models\Kelas::factory(),
            'tahun_ajar_id' => \App\Models\TahunAjar::factory(),
        ];
    }
}
