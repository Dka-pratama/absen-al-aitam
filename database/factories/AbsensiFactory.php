<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AbsensiFactory extends Factory
{
    public function definition(): array
    {
        return [
            'siswa_id' => null,
            'tanggal' => now(),
            'status' => fake()->randomElement(['hadir','izin','sakit','alpha']),
        ];
    }
}
