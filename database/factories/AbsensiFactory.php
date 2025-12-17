<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Absensi;
use App\Models\KelasSiswa;
use App\Models\Semester;

class AbsensiFactory extends Factory
{
    protected $model = Absensi::class;

    public function definition(): array
    {
        $semesterAktif = Semester::where('status', 'aktif')->first();

        // Ambil 1 hubungan kelas_siswa
        $kelasSiswa = KelasSiswa::inRandomOrder()->first();

        // Tentukan tanggal absensi
        $tanggal = fake()->dateTimeBetween('-20 days', 'now')->format('Y-m-d');

        // Pastikan tidak ada absensi ganda pada hari itu
        $cek = Absensi::where('kelas_siswa_id', $kelasSiswa->id)->where('tanggal', $tanggal)->exists();

        if ($cek) {
            // Jika sudah ada, jangan buat absensi untuk hari itu → pilih tanggal lain
            $tanggal = fake()->dateTimeBetween('-20 days', 'now')->format('Y-m-d');
        }

        return [
            'kelas_siswa_id' => $kelasSiswa->id,
            'semester_id' => $semesterAktif->id,
            'tanggal' => $tanggal,
            'status' => $this->faker->randomElement(['hadir', 'izin', 'sakit', 'alpa']),
            'waktu_absen' => $this->faker->time(),
            'keterangan' => $this->faker->sentence(3),
        ];
    }
}
