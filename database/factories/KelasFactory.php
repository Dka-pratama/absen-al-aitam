<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Kelas;
use App\Models\Wali;

class KelasFactory extends Factory
{
    protected $model = Kelas::class;

    public function definition(): array
    {
        return [
            'nama_kelas' => 'X ' . $this->faker->randomElement(['RPL', 'TKJ', 'MM']) . ' ' . $this->faker->numberBetween(1, 5),
            'jurusan' => $this->faker->randomElement(['RPL', 'TKJ', 'MM']),
            'angkatan' => $this->faker->numberBetween(2022, 2025),
        ];
    }
}
