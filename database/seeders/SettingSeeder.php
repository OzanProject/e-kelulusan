<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        Setting::truncate();

        Setting::create([
            'school_name'         => 'SMP Negeri 1 Contoh',
            'principal_name'      => 'Budi Santoso, S.Pd., M.Si.',
            'principal_nip'       => '198001012005011003',
            'announcement_date'   => now()->addDays(7),
            'announcement_status' => false,
            'skl_template'        => 'Berdasarkan hasil rapat pleno dewan guru dan mengacu pada kriteria kenaikan kelas yang telah ditetapkan, siswa yang bersangkutan dinyatakan:',
        ]);
    }
}
