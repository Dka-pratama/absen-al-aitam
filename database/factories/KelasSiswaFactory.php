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
            'tahun_ajar_id' => null, // WAJIB null agar dipasang manual
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
        return $this->afterCreating(function (KelasSiswa $ks) {
            Absensi::factory()
                ->count(30)
                ->state(function () use ($ks) {
                    return [
                        'kelas_siswa_id' => $ks->id,
                        'tanggal' => now()->subDays(rand(1, 30))->format('Y-m-d'),
                    ];
                })
                ->create();
        });
    }
}
