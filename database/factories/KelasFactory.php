<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Kelas;
use App\Models\KelasSiswa;
use App\Models\Siswa;
use App\Models\TahunAjar;

class KelasFactory extends Factory
{
    protected $model = Kelas::class;

    public function definition(): array
    {
        return [
            'nama_kelas' => 'X ' . $this->faker->randomElement(['RPL', 'TKJ', 'MM']) . ' ' . $this->faker->numberBetween(1, 5),
            'jurusan' => $this->faker->randomElement(['RPL', 'TKJ', 'MM']),
            'angkatan' => $this->faker->numberBetween(2022, 2025),
        ];
    }

    public function withSiswa($jumlah = 10)
    {
        return $this->afterCreating(function ($kelas) use ($jumlah) {

            // Membuat siswa sebanyak jumlah
            Siswa::factory($jumlah)->create()->each(function ($siswa) use ($kelas) {

                // Menghubungkan siswa ke kelas_siswa
                KelasSiswa::factory()->create([
                    'siswa_id' => $siswa->id,
                    'kelas_id' => $kelas->id,
                    'tahun_ajar_id' => TahunAjar::factory(),
                ]);
            });
        });
    }
}
