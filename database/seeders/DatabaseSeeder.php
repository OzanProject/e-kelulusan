<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,    // Akun admin
            SubjectSeeder::class, // Master mata pelajaran
            SettingSeeder::class, // Pengaturan sekolah default
            StudentSeeder::class, // Data siswa dummy
        ]);
    }
}
