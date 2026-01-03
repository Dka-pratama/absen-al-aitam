<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\KelasSiswa;
class KelasSiswaFactory extends Factory
{
    protected $model = KelasSiswa::class;

    public function definition(): array
    {
        return [
            'siswa_id' => null,
            'kelas_id' => null,
            'tahun_ajar_id' => null,
        ];
    }

    public function setRelasi($siswa, $kelas, $tahunAjar)
    {
        return $this->state([
            'siswa_id' => $siswa->id,
            'kelas_id' => $kelas->id,
            'tahun_ajar_id' => $tahunAjar->id,
        ]);
    }
}
