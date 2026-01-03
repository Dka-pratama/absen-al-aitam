<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TahunAjar;
use App\Models\Kelas;
use App\Models\User;
use App\Models\Siswa;
use App\Models\KelasSiswa;

class SiswaBaruSeeder extends Seeder
{
    public function run(): void
    {
        $tahunAktif = TahunAjar::where('status', 'aktif')->first();

        if (!$tahunAktif) return;

        // Ambil semua kelas X
        $kelasX = Kelas::where('nama_kelas', 'LIKE', 'X %')->get();

        foreach ($kelasX as $kelas) {
            // contoh: 30 siswa per kelas X
            for ($i = 0; $i < 30; $i++) {

                $user = User::factory()->create([
                    'role' => 'siswa',
                ]);

                $siswa = Siswa::create([
                    'user_id' => $user->id,
                    'NISN' => fake()->unique()->numerify('##########'),
                ]);

                KelasSiswa::firstOrCreate([
                    'siswa_id' => $siswa->id,
                    'kelas_id' => $kelas->id,
                    'tahun_ajar_id' => $tahunAktif->id,
                ]);
            }
        }
    }
}
