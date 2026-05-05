<?php

namespace App\Exports;

use App\Models\Student;
use App\Models\Subject;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class StudentsExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Student::all();
    }

    public function headings(): array
    {
        $subjects = Subject::aktif();
        $headings = ['Nama Lengkap', 'NISN', 'Nomor Peserta', 'Status Kelulusan'];

        foreach ($subjects as $subject) {
            $headings[] = $subject->nama;
        }

        $headings[] = 'Total Nilai';
        $headings[] = 'Sakit';
        $headings[] = 'Izin';
        $headings[] = 'Alpa';
        $headings[] = 'Pramuka';

        return $headings;
    }

    public function map($student): array
    {
        $subjects = Subject::aktif();
        $data = [
            $student->nama_lengkap,
            $student->nisn,
            $student->nomor_peserta,
            strtoupper($student->status_kelulusan),
        ];

        foreach ($subjects as $subject) {
            $data[] = $student->nilai_ujian[$subject->kode] ?? 0;
        }

        $data[] = $student->nilai_ujian['TTL'] ?? 0;
        $data[] = $student->nilai_ujian['Sakit'] ?? 0;
        $data[] = $student->nilai_ujian['Izin'] ?? 0;
        $data[] = $student->nilai_ujian['Alpa'] ?? 0;
        $data[] = $student->nilai_ujian['Pramuka'] ?? '-';

        return $data;
    }
}
