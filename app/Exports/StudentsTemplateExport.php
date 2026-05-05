<?php

namespace App\Exports;

use App\Models\Subject;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class StudentsTemplateExport implements FromView, ShouldAutoSize
{
    public function view(): View
    {
        $subjects = Subject::aktif();
        return view('backend.students.template', compact('subjects'));
    }
}
