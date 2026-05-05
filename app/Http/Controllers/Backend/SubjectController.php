<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use App\Imports\SubjectsImport;
use App\Exports\SubjectsTemplateExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class SubjectController extends Controller
{
    public function index(Request $request)
    {
        $perPage = (int) $request->get('per_page', 10);
        $perPage = in_array($perPage, [10, 20, 30, 50, 100]) ? $perPage : 10;

        $sortBy = $request->get('sort', 'urutan');
        $direction = $request->get('direction', 'asc');

        $allowedSort = ['nama', 'kode', 'urutan', 'created_at'];
        $sortBy = in_array($sortBy, $allowedSort) ? $sortBy : 'urutan';
        $direction = in_array($direction, ['asc', 'desc']) ? $direction : 'asc';

        $subjects = Subject::orderBy($sortBy, $direction)
            ->paginate($perPage)
            ->withQueryString();

        return view('backend.subjects.index', compact('subjects', 'perPage', 'sortBy', 'direction'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required|string|max:20|unique:subjects,kode',
            'nama' => 'required|string|max:255',
            'urutan' => 'nullable|integer|min:0',
        ]);

        Subject::create([
            'kode'   => strtoupper(trim($request->kode)),
            'nama'   => $request->nama,
            'urutan' => $request->urutan ?? 0,
            'aktif'  => true,
        ]);

        return redirect()->back()->with('success', 'Mata pelajaran berhasil ditambahkan!');
    }

    public function update(Request $request, Subject $subject)
    {
        $request->validate([
            'kode'  => 'required|string|max:20|unique:subjects,kode,' . $subject->id,
            'nama'  => 'required|string|max:255',
            'urutan'=> 'nullable|integer|min:0',
        ]);

        $subject->update([
            'kode'   => strtoupper(trim($request->kode)),
            'nama'   => $request->nama,
            'urutan' => $request->urutan ?? 0,
            'aktif'  => $request->has('aktif') ? true : false,
        ]);

        return redirect()->back()->with('success', 'Mata pelajaran berhasil diperbarui!');
    }

    public function destroy(Subject $subject)
    {
        $subject->delete();
        return redirect()->back()->with('success', 'Mata pelajaran berhasil dihapus!');
    }

    public function bulkDestroy(Request $request)
    {
        $ids = $request->ids;
        if (empty($ids) || !is_array($ids)) {
            return redirect()->back()->with('error', 'Pilih minimal satu mata pelajaran untuk dihapus.');
        }

        Subject::whereIn('id', $ids)->delete();

        return redirect()->back()->with('success', count($ids) . " mata pelajaran berhasil dihapus!");
    }

    public function import(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|mimes:xlsx,xls,csv|max:5120',
        ]);

        try {
            Excel::import(new SubjectsImport, $request->file('excel_file'));
            return redirect()->back()->with('success', 'Data mata pelajaran berhasil diimport!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal import: ' . $e->getMessage());
        }
    }

    public function template()
    {
        $filename = 'Template_Import_Mapel_' . now()->format('Ymd_His') . '.xlsx';
        return Excel::download(new SubjectsTemplateExport, $filename);
    }
}
