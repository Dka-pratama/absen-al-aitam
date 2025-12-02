<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    public function definition(): array
    {
        return [
            'username' => fake()->unique()->userName(),
            'email' => null, // karena kamu pakai username
            'password' => bcrypt('password'),
            'role' => 'siswa', // default, nanti diubah saat create
            'remember_token' => Str::random(10),
        ];
    }
}
