<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\KelasSiswa;
use App\Models\Absensi;
use App\Models\Siswa;
use App\Models\Kelas;

class KelasSiswaFactory extends Factory
{
    protected $model = KelasSiswa::class;

    public function definition(): array
    {
        return [
            'siswa_id' => Siswa::factory(),
            'kelas_id' => Kelas::factory(),
            'tahun_ajar_id' => null,
        ];
    }

    public function forTahunAjar($tahunAjar)
    {
        return $this->state([
            'tahun_ajar_id' => $tahunAjar->id,
        ]);
    }

    public function configure()
    {
        return $this;
    }
}
