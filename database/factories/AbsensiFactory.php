<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Absensi;
use App\Models\KelasSiswa;

class AbsensiFactory extends Factory
{
    protected $model = Absensi::class;

    public function definition(): array
    {
        return [
            'kelas_siswa_id' => KelasSiswa::factory(),
            'tanggal' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'status'     => $this->faker->randomElement(['hadir', 'izin', 'sakit', 'alpha']),
            'waktu_absen' => $this->faker->time(),
            'keterangan' => $this->faker->sentence(3)
        ];
    }
}
