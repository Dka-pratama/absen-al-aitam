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
        $tahunAktif = TahunAjar::where('status', 'aktif')->first();
        if (!$tahunAktif) {
            return;
        }

        $kelasList = Kelas::all();

        foreach ($kelasList as $kelas) {
            for ($i = 0; $i < 30; $i++) {
                $user = User::factory()->create([
                    'role' => 'siswa',
                ]);

                $siswa = Siswa::create([
                    'user_id' => $user->id,
                    'NISN' => fake()->unique()->numerify('##########'),
                ]);

                KelasSiswa::create([
                    'siswa_id' => $siswa->id,
                    'kelas_id' => $kelas->id,
                    'tahun_ajar_id' => $tahunAktif->id,
                ]);
            }
        }
    }
}
