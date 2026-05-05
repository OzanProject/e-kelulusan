<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\AccessLog;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function logs(Request $request)
    {
        $perPage = (int) $request->get('per_page', 20);
        $perPage = in_array($perPage, [20, 50, 100]) ? $perPage : 20;

        $logs = AccessLog::with('student')
            ->latest()
            ->paginate($perPage)
            ->withQueryString();

        return view('backend.reports.logs', compact('logs', 'perPage'));
    }

    public function clearLogs()
    {
        AccessLog::truncate();
        return redirect()->back()->with('success', 'Semua log akses berhasil dibersihkan!');
    }
}
