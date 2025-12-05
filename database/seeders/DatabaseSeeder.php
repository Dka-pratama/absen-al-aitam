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
    // ADMIN (manual)
    User::factory()->admin()->create([
        'name' => 'Admin',
        'username' => 'admin',
        'email' => 'admin@example.com',
        'password' => bcrypt('password'),
    ]);

    // WALI KELAS (manual + role wali)
    $wali = User::factory()->wali()->create([
        'name' => 'Wali Kelas',
        'username' => 'wali',
        'email' => 'wali@example.com',
        'password' => bcrypt('password'),
    ]);

    // SISWA (user via factory)
    $userSiswa = User::factory()->create([
        'name' => 'Siswa Tes',
        'username' => 'siswa',
        'email' => 'siswa@example.com',
        'password' => bcrypt('password'),
        'role' => 'siswa',
    ]);

    // DATA SISWA
    $siswa = Siswa::factory()->create([
        'user_id' => $userSiswa->id,
        'NISN' => '1234567890',
    ]);

    // KELAS
    $kelas = Kelas::factory()->create([
        'nama_kelas' => 'X RPL 1',
        'jurusan' => 'RPL',
        'angkatan' => '2024',
    ]);

    // TAHUN AJAR
    $tahunAjar = TahunAjar::factory()->create([
        'tahun' => '2024/2025',
        'semester' => 'ganjil',
        'status' => 'aktif',
    ]);

    // WALI_KELAS
    WaliKelas::factory()->create([
        'user_id' => $wali->id,
        'kelas_id' => $kelas->id,
        'tahun_ajar_id' => $tahunAjar->id,
    ]);

    // KELAS_SISWA
    KelasSiswa::factory()->create([
        'siswa_id' => $siswa->id,
        'kelas_id' => $kelas->id,
        'tahun_ajar_id' => $tahunAjar->id,
    ]);

    Kelas::factory()
    ->count(10)
    ->withSiswa(15)   // setiap kelas berisi 15 siswa
    ->create();

    }
}
