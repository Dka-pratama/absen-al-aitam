<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            TahunAjarSeeder::class,
            KelasSeeder::class,
            AuthSeeder::class,
            SiswaSeeder::class,
            AbsensiSeeder::class,
        ]);
    }
}
