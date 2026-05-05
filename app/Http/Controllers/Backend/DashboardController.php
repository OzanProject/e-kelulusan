<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\AccessLog;
use App\Models\Subject;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalSiswa = Student::count();
        $lulus = Student::where('status_kelulusan', 'lulus')->count();
        $tidakLulus = Student::where('status_kelulusan', 'tidak_lulus')->count();
        $ditunda = Student::where('status_kelulusan', 'ditunda')->count();
        
        $totalMapel = Subject::count();
        
        // Activity Data
        $recentLogs = AccessLog::with('student')->latest()->limit(5)->get();
        
        // Access percentage
        $accessedCount = AccessLog::distinct('student_id')->count('student_id');
        $persentaseAkses = $totalSiswa > 0 ? round(($accessedCount / $totalSiswa) * 100) : 0;

        return view('backend.dashboard.index', compact(
            'totalSiswa', 'lulus', 'tidakLulus', 'ditunda', 
            'totalMapel', 'recentLogs', 'persentaseAkses'
        ));
    }
}
