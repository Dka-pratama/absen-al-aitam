<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Siswa;
use App\Models\User;

class SiswaFactory extends Factory
{
    protected $model = Siswa::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'NISN' => $this->faker->unique()->numerify('########'),
        ];
    }
}
