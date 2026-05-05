<?php

namespace Database\Seeders;

use App\Models\Subject;
use Illuminate\Database\Seeder;

class SubjectSeeder extends Seeder
{
    public function run(): void
    {
        Subject::truncate();

        $mapel = [
            ['kode' => 'PAI', 'nama' => 'Pendidikan Agama Islam dan Budi Pekerti', 'urutan' => 1],
            ['kode' => 'PKN', 'nama' => 'Pendidikan Pancasila',                    'urutan' => 2],
            ['kode' => 'IND', 'nama' => 'Bahasa Indonesia',                         'urutan' => 3],
            ['kode' => 'MTK', 'nama' => 'Matematika (Umum)',                        'urutan' => 4],
            ['kode' => 'IPA', 'nama' => 'Ilmu Pengetahuan Alam (IPA)',              'urutan' => 5],
            ['kode' => 'IPS', 'nama' => 'Ilmu Pengetahuan Sosial (IPS)',            'urutan' => 6],
            ['kode' => 'ING', 'nama' => 'Bahasa Inggris',                           'urutan' => 7],
            ['kode' => 'PJK', 'nama' => 'Pendidikan Jasmani, Olahraga dan Kesehatan', 'urutan' => 8],
            ['kode' => 'INF', 'nama' => 'Informatika',                              'urutan' => 9],
            ['kode' => 'SBD', 'nama' => 'Seni, Budaya dan Prakarya',                'urutan' => 10],
            ['kode' => 'SND', 'nama' => 'Muatan Lokal Bahasa Daerah',               'urutan' => 11],
        ];

        foreach ($mapel as $m) {
            Subject::create(array_merge($m, ['aktif' => true]));
        }
    }
}
