<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\WaliKelas;
use App\Models\Kelas;
use App\Models\TahunAjar;

class AuthSeeder extends Seeder
{
    public function run(): void
    {
        // ===== ADMIN =====
        User::firstOrCreate(
            ['username' => 'admin'],
            [
                'name' => 'Administrator',
                'email' => 'admin@example.com',
                'password' => bcrypt('password'),
                'role' => 'admin',
            ],
        );

        // ===== WALI KELAS =====
        $tahunAktif = TahunAjar::where('status', 'aktif')->first();

        if ($tahunAktif) {
            $kelasList = Kelas::all();

            foreach ($kelasList as $kelas) {
                $user = User::firstOrCreate(
                    ['username' => 'wali_' . str_replace(' ', '_', strtolower($kelas->nama_kelas))],
                    [
                        'name' => 'Wali ' . $kelas->nama_kelas,
                        'email' => fake()->safeEmail(),
                        'password' => bcrypt('password'),
                        'role' => 'wali',
                    ],
                );

                WaliKelas::firstOrCreate(
                    [
                        'user_id' => $user->id,
                        'kelas_id' => $kelas->id,
                        'tahun_ajar_id' => $tahunAktif->id,
                    ],
                    [
                        'NUPTK' => fake()->unique()->numerify('################'),
                    ],
                );
            }
        }
    }
}
