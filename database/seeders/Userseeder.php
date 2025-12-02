<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class Userseeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::create([
            'name' => 'Admin',
            'username' => 'admin',
            'role' => 'admin',
            'password' => Hash::make('password'),
        ]);

        $Wali = [['name' => 'Wali kelas 1', 'username' => 'wali1'],
                 ['name' => 'Wali kelas 2', 'username' => 'wali2'],
                 ['name' => 'Wali kelas 3', 'username' => 'wali3'],
                 ['name' => 'Wali kelas 4', 'username' => 'wali4'],
                 ['name' => 'Wali kelas 5', 'username' => 'wali5'],
                 ['name' => 'Wali kelas 6', 'username' => 'wali6']
                ];
        foreach ($Wali as $wali) {
            User::create([
                'name' => $wali['name'],
                'username' => $wali['username'],
                'role' => 'wali',
                'password' => Hash::make('password'),
            ]);
        }

        for ($i = 1; $i <= 50; $i++) {
            User::create([
                'name' => "siswa $i",
                'username' => "siswa$i",
                'role' => 'siswa',
                'password' => Hash::make('password'),
            ]);
        }
    }
}
