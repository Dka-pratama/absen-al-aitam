<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\KelasSiswa;

class KelasFactory extends Factory
{
    protected $model = Kelas::class;

    public function definition(): array
    {
        return [
            'nama_kelas' =>
                'X ' . $this->faker->randomElement(['RPL', 'TKJ', 'MM']) . ' ' . $this->faker->numberBetween(1, 5),
            'jurusan' => $this->faker->randomElement(['RPL', 'TKJ', 'MM']),
            'angkatan' => $this->faker->numberBetween(2022, 2025),
        ];
    }

    public function withSiswa($tahunAjar, $jumlah = 10)
    {
        return $this->afterCreating(function ($kelas) use ($jumlah, $tahunAjar) {
            Siswa::factory($jumlah)
                ->create()
                ->each(function ($siswa) use ($kelas, $tahunAjar) {
                    KelasSiswa::factory()
                        ->forTahunAjar($tahunAjar)
                        ->create([
                            'siswa_id' => $siswa->id,
                            'kelas_id' => $kelas->id,
                        ]);
                });
        });
    }
}
