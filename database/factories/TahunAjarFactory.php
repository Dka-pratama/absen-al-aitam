<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TahunAjar>
 */
class TahunAjarFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $start = $this->faker->numberBetween(2022, 2025);
        return [
            'tahun' => $start . '/' . ($start + 1),
            'semester' => $this->faker->randomElement(['Ganjil', 'Genap']),
            'status' => 'aktif',
        ];
    }
}
