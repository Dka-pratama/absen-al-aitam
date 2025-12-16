<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Absensi;
use App\Models\KelasSiswa;
use Carbon\Carbon;
use App\Models\Semester;


class AbsensiSeeder extends Seeder
{
    public function run(): void
    {
        $semesterAktif = Semester::where('status', 'aktif')->first();

if (!$semesterAktif) {
    $this->command->warn('Semester aktif tidak ditemukan — skip AbsensiSeeder');
    return;
}

        $kelasSiswaList = KelasSiswa::all();

        if ($kelasSiswaList->isEmpty()) {
            $this->command->warn('KelasSiswa kosong — skip AbsensiSeeder');
            return;
        }

        $this->command->info('Membuat data absensi otomatis untuk seluruh siswa...');

        // 30 hari kebelakang
        $days = 30;

        foreach ($kelasSiswaList as $kelasSiswa) {
            for ($i = 0; $i < $days; $i++) {
                $tanggal = Carbon::today()->subDays($i)->format('Y-m-d');

                // Cegah duplikasi
                $exists = Absensi::where('kelas_siswa_id', $kelasSiswa->id)
    ->where('semester_id', $semesterAktif->id)
    ->where('tanggal', $tanggal)
    ->exists();
                if ($exists) {
                    continue;
                }

                // Status realistis
                $rand = rand(1, 100);

                if ($rand <= 85) {
                    $status = 'hadir';
                } elseif ($rand <= 92) {
                    $status = 'izin';
                } elseif ($rand <= 98) {
                    $status = 'sakit';
                } else {
                    $status = 'alpa';
                }

                Absensi::create([
                    'kelas_siswa_id' => $kelasSiswa->id,
                    'semester_id' => $semesterAktif->id,
                    'tanggal' => $tanggal,
                    'waktu_absen' => Carbon::createFromTime(rand(6, 9), rand(0, 59), rand(0, 59)),
                    'status' => $status,
                    'keterangan' => $status === 'hadir' ? null : fake()->sentence(3),
                ]);
            }
        }

        $this->command->info('AbsensiSeeder selesai ✔');
    }
}
