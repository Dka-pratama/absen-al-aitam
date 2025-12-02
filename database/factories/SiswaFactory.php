<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SiswaFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nama' => fake()->name(),
            'nis' => fake()->unique()->numerify('#######'),
            'kelas_id' => null, // diisi saat create
        ];
    }
}
