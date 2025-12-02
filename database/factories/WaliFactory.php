<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class WaliFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nama' => fake()->name(),
            'nip' => fake()->unique()->numerify('1980########'),
            'kelas_id' => null,
        ];
    }
}
