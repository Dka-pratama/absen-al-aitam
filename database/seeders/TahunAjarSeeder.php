<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TahunAjar;
use App\Models\Semester;

class TahunAjarSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['tahun' => '2024/2025', 'status' => 'non-aktif'],
            ['tahun' => '2025/2026', 'status' => 'aktif'],
            ['tahun' => '2026/2027', 'status' => 'non-aktif'],
        ];

        foreach ($data as $item) {
            $ta = TahunAjar::create($item);

            Semester::create([
                'tahun_ajar_id' => $ta->id,
                'name' => 'ganjil',
                'status' => $item['status'] === 'aktif' ? 'aktif' : 'non-aktif',
            ]);

            Semester::create([
                'tahun_ajar_id' => $ta->id,
                'name' => 'genap',
                'status' => 'non-aktif',
            ]);
        }
    }
}
