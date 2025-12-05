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
        // ============================================
        // 1. ADMIN
        // ============================================
        User::factory()->admin()->create([
            'name'     => 'Admin',
            'username' => 'admin',
            'email'    => 'admin@example.com',
            'password' => bcrypt('password'),
        ]);

        // ============================================
        // 2. TAHUN AJAR AKTIF
        // ============================================
        $tahunAjar = TahunAjar::factory()->create([
            'tahun'    => '2024/2025',
            'semester' => 'ganjil',
            'status'   => 'aktif',
        ]);

        // ============================================
        // 3. WALI KELAS USER MANUAL
        // ============================================
        $waliUser = User::factory()->wali()->create([
            'name'     => 'Wali Kelas',
            'username' => 'wali',
            'email'    => 'wali@example.com',
            'password' => bcrypt('password'),
        ]);

        // ============================================
        // 4. KELAS MANUAL
        // ============================================
        $kelasManual = Kelas::factory()->create([
            'nama_kelas' => 'X RPL 1',
            'jurusan'    => 'RPL',
            'angkatan'   => '2024',
        ]);

        // ============================================
        // 5. SISWA MANUAL
        // ============================================
        $userSiswa = User::factory()->create([
            'name'     => 'Siswa Tes',
            'username' => 'siswa',
            'email'    => 'siswa@example.com',
            'password' => bcrypt('password'),
            'role'     => 'siswa',
        ]);

        $siswa = Siswa::factory()->create([
            'user_id' => $userSiswa->id,
            'NISN'    => '1234567890',
        ]);

        // Relasi siswa → kelas
        $kelasSiswa = KelasSiswa::factory()->create([
            'siswa_id'      => $siswa->id,
            'kelas_id'      => $kelasManual->id,
            'tahun_ajar_id' => $tahunAjar->id,
        ]);

        // Relasi wali kelas → ke kelas manual
        WaliKelas::factory()->create([
            'user_id'       => $waliUser->id,
            'kelas_id'      => $kelasManual->id,
            'tahun_ajar_id' => $tahunAjar->id,
        ]);

        // ============================================
        // 6. KELAS + SISWA AUTO (Factory)
        // ============================================
        Kelas::factory()
            ->count(5)
            ->withSiswa(15)
            ->create()
            ->each(function ($kelas) use ($tahunAjar) {
                // bikin wali untuk kelas factory
                WaliKelas::factory()
                    ->forKelas($kelas)
                    ->state(['tahun_ajar_id' => $tahunAjar->id])
                    ->create();
            });
    }
}
