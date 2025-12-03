<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\WaliKelas;
use App\Models\User;

class WaliKelasFactory extends Factory
{
    protected $model = WaliKelas::class;

    public function definition(): array
    {
        return [
            'NUPTK' => $this->faker->unique()->numerify('##########'),
            'user_id' => User::factory()->state(['role' => 'wali']),
            'kelas_id' => \App\Models\Kelas::factory(),
            'tahun_ajar_id' => \App\Models\TahunAjar::factory(),
        ];
    }
}
