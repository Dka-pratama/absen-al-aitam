<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\TahunAjar;
use App\Models\WaliKelas;
use App\Models\KelasSiswa;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ====== Admin ======
        User::factory()
            ->admin()
            ->create([
                'name' => 'Admin',
                'username' => 'admin',
                'email' => 'admin@example.com',
                'password' => bcrypt('password'),
            ]);

        // ====== Tahun Ajar Aktif ======
        $tahunAjar = TahunAjar::factory()->create([
            'tahun' => '2024/2025',
            'semester' => 'Ganjil',
            'status' => 'aktif',
        ]);

        // ====== Wali Kelas Manual ======
        $waliUser = User::factory()
            ->wali()
            ->create([
                'name' => 'Wali Kelas',
                'username' => 'wali',
                'email' => 'wali@example.com',
                'password' => bcrypt('password'),
            ]);

        // ====== Kelas Manual ======
        $kelasManual = Kelas::factory()->create([
            'nama_kelas' => 'X RPL 1',
            'jurusan' => 'RPL',
            'angkatan' => '2024',
        ]);

        // ====== Siswa Manual ======
        $userSiswa = User::factory()->create([
            'name' => 'Siswa Tes',
            'username' => 'siswa',
            'email' => 'siswa@example.com',
            'password' => bcrypt('password'),
            'role' => 'siswa',
        ]);

        $siswa = Siswa::factory()->create([
            'user_id' => $userSiswa->id,
            'NISN' => '1234567890',
        ]);

        KelasSiswa::factory()
            ->forTahunAjar($tahunAjar)
            ->create([
                'siswa_id' => $siswa->id,
                'kelas_id' => $kelasManual->id,
            ]);

        // Wali kelas untuk kelas manual
        WaliKelas::factory()->create([
            'user_id' => $waliUser->id,
            'kelas_id' => $kelasManual->id,
            'tahun_ajar_id' => $tahunAjar->id,
        ]);

        // ====== Kelas Auto + Siswa Auto ======
        Kelas::factory()
            ->count(5)
            ->create()
            ->each(function ($kelas) use ($tahunAjar) {
                // Buat 15 siswa untuk setiap kelas
                Siswa::factory(15)
                    ->create()
                    ->each(function ($siswa) use ($kelas, $tahunAjar) {
                        KelasSiswa::factory()
                            ->forTahunAjar($tahunAjar)
                            ->create([
                                'siswa_id' => $siswa->id,
                                'kelas_id' => $kelas->id,
                            ]);
                    });

                // Wali kelas
                WaliKelas::factory()
                    ->state([
                        'kelas_id' => $kelas->id,
                        'tahun_ajar_id' => $tahunAjar->id,
                    ])
                    ->create();
            });
        $this->call(AbsensiSeeder::class);
        $this->command->info('DatabaseSeeder selesai Semua ✔');
    }
}
