<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\User;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        return [
            'name'      => $this->faker->name(),
            'username'  => $this->faker->unique()->userName(),
            'email'     => null,
            'password'  => bcrypt('password'),
            'role'      => 'siswa', // default siswa
        ];
    }

    public function wali()
    {
        return $this->state(fn () => [
            'role' => 'wali',
        ]);
    }
    public function admin()
    {
        return $this->state(fn () => ['role' => 'admin']);
    }
}
