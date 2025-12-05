<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\KelasSiswa;
use App\Models\Absensi;

class KelasSiswaFactory extends Factory
{
    protected $model = KelasSiswa::class;

public function definition(): array
{
    return [
        'siswa_id' => \App\Models\Siswa::factory(), // WAJIB ADA!
        'kelas_id' => \App\Models\Kelas::factory(),
        'tahun_ajar_id' => \App\Models\TahunAjar::factory(),
    ];
}

public function configure()
{
    return $this->afterCreating(function (KelasSiswa $ks) {

        Absensi::factory()
            ->count(30)
            ->state(fn () => [
                'kelas_siswa_id' => $ks->id,
                'tanggal' => now()->subDays(rand(1,30))->format('Y-m-d')
            ])
            ->create();
    });
}


}
