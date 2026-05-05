<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class SubjectsTemplateExport implements FromCollection, WithHeadings, WithTitle, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return collect([
            [
                'kode' => 'PAI',
                'nama' => 'Pendidikan Agama & Budi Pekerti',
                'urutan' => 1
            ],
            [
                'kode' => 'PKN',
                'nama' => 'Pendidikan Pancasila & Kewarganegaraan',
                'urutan' => 2
            ],
            [
                'kode' => 'IND',
                'nama' => 'Bahasa Indonesia',
                'urutan' => 3
            ]
        ]);
    }

    public function headings(): array
    {
        return [
            'kode',
            'nama',
            'urutan'
        ];
    }

    public function title(): string
    {
        return 'Template Import Mapel';
    }
}
