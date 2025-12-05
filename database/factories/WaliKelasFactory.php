<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\WaliKelas;
use App\Models\User;
use App\Models\Kelas;
use App\Models\TahunAjar;

class WaliKelasFactory extends Factory
{
    protected $model = WaliKelas::class;

    public function definition(): array
    {
        return [
            'NUPTK' => $this->faker->unique()->numerify('##########'),
            'user_id' => User::factory()->state(['role' => 'wali']),
            'kelas_id' => Kelas::factory(),
            'tahun_ajar_id' => TahunAjar::factory(),
        ];
    }

    /**
     * Assign to an existing class
     */
    public function forExistingKelas()
    {
        return $this->state(function () {
            return [
                'kelas_id' => Kelas::inRandomOrder()->first()->id ?? Kelas::factory(),
            ];
        });
    }

    /**
     * Assign to a specific class
     */
    public function forKelas($kelas)
    {
        return $this->state([
            'kelas_id' => $kelas->id,
        ]);
    }

    /**
     * Assign tahun ajar aktif automatically
     */
    public function forTahunAjarAktif()
    {
        return $this->state(function () {
            $tahunAjar = TahunAjar::where('status', 'aktif')->first()
                ?? TahunAjar::factory()->create(['status' => 'aktif']);

            return ['tahun_ajar_id' => $tahunAjar->id];
        });
    }
}
