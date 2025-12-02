<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class KelasFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nama_kelas' => fake()->randomElement(['X RPL 1','X RPL 2','XI TKJ 1','XI TKJ 2']),
            'jurusan' => fake()->randomElement(['RPL','TKJ','MM']),
            'tingkat' => fake()->randomElement(['X','XI','XII']),
        ];
    }
}
