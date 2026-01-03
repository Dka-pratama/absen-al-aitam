<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\KelasSiswa;
use App\Models\TahunAjar;

class SiswaSeeder extends Seeder
{
    public function run(): void
    {
        $tahun = TahunAjar::where('tahun', '2024/2025')->first();

        if (!$tahun) {
            $this->command->error('Tahun ajar 2024/2025 tidak ditemukan');
            return;
        }

        $kelasX = Kelas::where('nama_kelas', 'LIKE', 'X %')->get();

        foreach ($kelasX as $kelas) {
            for ($i = 0; $i < 30; $i++) {
                // 🔥 30 siswa per kelas
                $user = User::factory()->create(['role' => 'siswa']);

                $siswa = Siswa::create([
                    'user_id' => $user->id,
                    'NISN' => fake()->unique()->numerify('##########'),
                ]);

                KelasSiswa::create([
                    'siswa_id' => $siswa->id,
                    'kelas_id' => $kelas->id,
                    'tahun_ajar_id' => $tahun->id,
                ]);
            }
        }

        $this->command->info('SiswaSeeder: siswa & kelas_siswa berhasil dibuat');
    }
}
