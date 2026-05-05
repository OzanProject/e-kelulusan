<?php

namespace App\Imports;

use App\Models\Subject;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;

class SubjectsImport implements ToModel, WithHeadingRow, SkipsEmptyRows
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // Skip if required fields are missing
        if (!isset($row['kode']) || !isset($row['nama'])) {
            return null;
        }

        $kode = strtoupper(trim($row['kode']));

        return Subject::updateOrCreate(
            ['kode' => $kode],
            [
                'nama'   => $row['nama'],
                'urutan' => $row['urutan'] ?? 0,
                'aktif'  => true,
            ]
        );
    }
}
