<?php

namespace Database\Seeders;

use App\Models\Student;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StudentSeeder extends Seeder
{
    /**
     * Helper: hitung TTL otomatis dari array nilai.
     */
    private function ttl(array $nilai): int
    {
        return (int) array_sum(array_filter($nilai, fn($v) => is_numeric($v)));
    }

    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Student::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $students = [
            [
                'nisn'             => '0115990404',
                'nomor_peserta'    => '232407025',
                'nama_lengkap'     => 'Abdul Aziz',
                'status_kelulusan' => 'lulus',
                'nilai'            => ['PAI'=>78,'PKN'=>87,'IND'=>84,'MTK'=>80,'IPA'=>88,'IPS'=>78,'ING'=>79,'PJK'=>85,'INF'=>80,'SBD'=>83,'SND'=>80],
                'absen'            => ['Sakit'=>0,'Izin'=>0,'Alpa'=>32,'Pramuka'=>'B'],
            ],
            [
                'nisn'             => '0117338029',
                'nomor_peserta'    => '232407030',
                'nama_lengkap'     => 'Fanesya Nabila Putri Suwandi',
                'status_kelulusan' => 'lulus',
                'nilai'            => ['PAI'=>93,'PKN'=>93,'IND'=>95,'MTK'=>90,'IPA'=>91,'IPS'=>94,'ING'=>90,'PJK'=>90,'INF'=>90,'SBD'=>89,'SND'=>96],
                'absen'            => ['Sakit'=>0,'Izin'=>3,'Alpa'=>0,'Pramuka'=>'B'],
            ],
            [
                'nisn'             => '0112479615',
                'nomor_peserta'    => '232407023',
                'nama_lengkap'     => "Selpi Nursa'adah",
                'status_kelulusan' => 'lulus',
                'nilai'            => ['PAI'=>90,'PKN'=>90,'IND'=>94,'MTK'=>90,'IPA'=>89,'IPS'=>88,'ING'=>90,'PJK'=>90,'INF'=>90,'SBD'=>90,'SND'=>95],
                'absen'            => ['Sakit'=>0,'Izin'=>1,'Alpa'=>0,'Pramuka'=>'B'],
            ],
            [
                'nisn'             => '0113380270',
                'nomor_peserta'    => '232407039',
                'nama_lengkap'     => 'Nuraeni',
                'status_kelulusan' => 'lulus',
                'nilai'            => ['PAI'=>85,'PKN'=>90,'IND'=>91,'MTK'=>85,'IPA'=>85,'IPS'=>86,'ING'=>82,'PJK'=>88,'INF'=>85,'SBD'=>88,'SND'=>92],
                'absen'            => ['Sakit'=>0,'Izin'=>3,'Alpa'=>0,'Pramuka'=>'B'],
            ],
            [
                'nisn'             => '0112116275',
                'nomor_peserta'    => '232407034',
                'nama_lengkap'     => 'Lita Maulani',
                'status_kelulusan' => 'lulus',
                'nilai'            => ['PAI'=>85,'PKN'=>92,'IND'=>91,'MTK'=>85,'IPA'=>85,'IPS'=>86,'ING'=>87,'PJK'=>86,'INF'=>85,'SBD'=>87,'SND'=>90],
                'absen'            => ['Sakit'=>0,'Izin'=>1,'Alpa'=>0,'Pramuka'=>'B'],
            ],
            [
                'nisn'             => '0108012532',
                'nomor_peserta'    => '232407033',
                'nama_lengkap'     => 'Indriani',
                'status_kelulusan' => 'lulus',
                'nilai'            => ['PAI'=>88,'PKN'=>90,'IND'=>90,'MTK'=>85,'IPA'=>82,'IPS'=>87,'ING'=>82,'PJK'=>89,'INF'=>85,'SBD'=>87,'SND'=>90],
                'absen'            => ['Sakit'=>0,'Izin'=>0,'Alpa'=>0,'Pramuka'=>'B'],
            ],
            [
                'nisn'             => '0106264830',
                'nomor_peserta'    => '232407035',
                'nama_lengkap'     => 'Muhammad Riandi',
                'status_kelulusan' => 'lulus',
                'nilai'            => ['PAI'=>85,'PKN'=>91,'IND'=>93,'MTK'=>85,'IPA'=>86,'IPS'=>86,'ING'=>82,'PJK'=>90,'INF'=>85,'SBD'=>88,'SND'=>94],
                'absen'            => ['Sakit'=>5,'Izin'=>1,'Alpa'=>0,'Pramuka'=>'B'],
            ],
            [
                'nisn'             => '0099950808',
                'nomor_peserta'    => '232407032',
                'nama_lengkap'     => 'Halmin Sailin',
                'status_kelulusan' => 'tidak_lulus',
                // Sesuai Excel asli: hanya PKN=1 dan IPA=1, sisanya kosong
                'nilai'            => ['PAI'=>null,'PKN'=>1,'IND'=>null,'MTK'=>null,'IPA'=>1,'IPS'=>null,'ING'=>null,'PJK'=>null,'INF'=>null,'SBD'=>null,'SND'=>null],
                'absen'            => ['Sakit'=>0,'Izin'=>0,'Alpa'=>0,'Pramuka'=>'-'],
            ],
        ];

        foreach ($students as $data) {
            $nilai_ujian = array_merge(
                $data['nilai'],
                ['TTL' => $this->ttl($data['nilai'])],
                $data['absen']
            );
            Student::create([
                'nisn'             => $data['nisn'],
                'nomor_peserta'    => $data['nomor_peserta'],
                'nama_lengkap'     => $data['nama_lengkap'],
                'status_kelulusan' => $data['status_kelulusan'],
                'nilai_ujian'      => $nilai_ujian,
            ]);
        }
    }
}
