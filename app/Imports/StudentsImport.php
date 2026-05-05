<?php

namespace App\Imports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class StudentsImport implements ToModel, WithStartRow
{
    public function startRow(): int
    {
        return 5;
    }

    public function model(array $row)
    {
        $nama_lengkap = $row[1] ?? null;
        $nisn = $row[2] ?? null;
        $nomor_peserta = $row[3] ?? null;
        
        if (!$nisn || !$nama_lengkap) {
            return null;
        }

        $nilai_ujian = [
            'PAI' => $row[4] ?? null,
            'PKN' => $row[5] ?? null,
            'IND' => $row[6] ?? null,
            'MTK' => $row[7] ?? null,
            'IPA' => $row[8] ?? null,
            'IPS' => $row[9] ?? null,
            'ING' => $row[10] ?? null,
            'PJK' => $row[11] ?? null,
            'INF' => $row[12] ?? null,
            'SBD' => $row[13] ?? null,
            'SND' => $row[14] ?? null,
            'TTL' => $row[15] ?? null,
            'Sakit' => $row[16] ?? 0,
            'Izin' => $row[17] ?? 0,
            'Alpa' => $row[18] ?? 0,
            'Pramuka' => $row[19] ?? '-',
        ];

        $status = strtolower($row[20] ?? 'lulus');
        if (!in_array($status, ['lulus', 'tidak_lulus', 'ditunda'])) {
            $status = 'lulus';
        }

        return Student::updateOrCreate(
            ['nisn' => $nisn],
            [
                'nomor_peserta' => $nomor_peserta,
                'nama_lengkap' => $nama_lengkap,
                'status_kelulusan' => $status,
                'nilai_ujian' => $nilai_ujian
            ]
        );
    }
}
