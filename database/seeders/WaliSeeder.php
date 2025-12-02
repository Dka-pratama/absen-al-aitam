<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Wali;
use App\Models\Kelas;

class WaliSeeder extends Seeder
{
    public function run(): void
    {
        $kelas = Kelas::factory()->count(3)->create();

        foreach ($kelas as $k) {
            // Buat user
            $user = User::factory()->create([
                'role' => 'wali',
                'username' => 'wali'.$k->id,
            ]);

            // Relasi ke wali
            Wali::factory()->create([
                'kelas_id' => $k->id,
                'user_id' => $user->id,
            ]);
        }
    }
}
