<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Siswa;
use App\Models\Kelas;

class SiswaSeeder extends Seeder
{
    public function run(): void
    {
        $kelas = Kelas::first(); // Ambil salah satu kelas

        for ($i = 1; $i <= 5; $i++) {
            $user = User::factory()->create([
                'role' => 'siswa',
                'username' => 'siswa'.$i
            ]);

            $siswa = Siswa::factory()->create([
                'kelas_id' => $kelas->id,
                'user_id' => $user->id
            ]);
        }
    }
}
