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

        // 🔥 AMBIL TAHUN AJAR DARI SEMESTER
        $tahunAjarAktif = $semesterAktif->tahunAjar;

        // 🔥 HANYA kelas_siswa di tahun ajar aktif
        $kelasSiswaList = KelasSiswa::where('tahun_ajar_id', $tahunAjarAktif->id)->get();

        if ($kelasSiswaList->isEmpty()) {
            $this->command->warn('Tidak ada siswa di tahun ajar aktif — skip AbsensiSeeder');
            return;
        }

        $this->command->info('Membuat data absensi otomatis...');

        $days = 30;

        foreach ($kelasSiswaList as $kelasSiswa) {
            for ($i = 1; $i < $days; $i++) {
                $tanggal = Carbon::today()->subDays($i)->format('Y-m-d');

                $exists = Absensi::where('kelas_siswa_id', $kelasSiswa->id)
                    ->where('semester_id', $semesterAktif->id)
                    ->where('tanggal', $tanggal)
                    ->exists();

                if ($exists) {
                    continue;
                }

                $rand = rand(1, 100);
                $status = $rand <= 85 ? 'hadir' : ($rand <= 92 ? 'izin' : ($rand <= 98 ? 'sakit' : 'alpa'));

                Absensi::create([
                    'kelas_siswa_id' => $kelasSiswa->id,
                    'semester_id' => $semesterAktif->id,
                    'tanggal' => $tanggal,
                    'waktu_absen' => Carbon::createFromTime(rand(6, 9), rand(0, 59)),
                    'status' => $status,
                    'method' => 'seed',
                    'keterangan' => $status === 'hadir' ? null : fake()->sentence(3),
                ]);
            }
        }

        $this->command->info('AbsensiSeeder selesai ✔');
    }
}
