<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Setting;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class StudentController extends Controller
{
    /** Ambil semua mapel aktif dari DB */
    private function getMapel()
    {
        return Subject::aktif();
    }

    /** Buat field name aman dari kode mapel (lowercase + hanya huruf/angka) */
    private function fieldKey(string $kode): string
    {
        return 'nilai_' . preg_replace('/[^a-z0-9]/', '_', strtolower($kode));
    }

    /** Bangun array nilai_ujian dari request */
    private function buildNilai(Request $request): array
    {
        $nilai = [];
        foreach ($this->getMapel() as $s) {
            $raw = $request->input($this->fieldKey($s->kode));
            // Simpan null jika kosong, bukan string kosong
            $nilai[$s->kode] = ($raw !== null && $raw !== '') ? (int) $raw : null;
        }
        // TTL = jumlah nilai yang numeric saja
        $nilai['TTL'] = array_sum(array_filter($nilai, fn($v) => is_numeric($v)));
        $nilai['Sakit'] = (int) $request->input('sakit', 0);
        $nilai['Izin'] = (int) $request->input('izin', 0);
        $nilai['Alpa'] = (int) $request->input('alpa', 0);
        $nilai['Pramuka'] = $request->input('pramuka') ?: '-';
        return $nilai;
    }

    // ──────────────────────────────────────────────
    // INDEX
    // ──────────────────────────────────────────────
    public function index(Request $request)
    {
        $perPage = (int) $request->get('per_page', 10);
        $perPage = in_array($perPage, [10, 20, 30, 50, 100]) ? $perPage : 10;

        $sortBy = $request->get('sort', 'nama_lengkap');
        $direction = $request->get('direction', 'asc');

        // Validasi sort field
        $allowedSort = ['nama_lengkap', 'nisn', 'nomor_peserta', 'created_at'];
        $sortBy = in_array($sortBy, $allowedSort) ? $sortBy : 'nama_lengkap';
        $direction = in_array($direction, ['asc', 'desc']) ? $direction : 'asc';

        $students = Student::orderBy($sortBy, $direction)->paginate($perPage)->withQueryString();
        $subjects = $this->getMapel();

        return view('backend.students.index', compact('students', 'subjects', 'perPage', 'sortBy', 'direction'));
    }

    // ──────────────────────────────────────────────
    // CREATE
    // ──────────────────────────────────────────────
    public function create()
    {
        $mapel = $this->getMapel();
        return view('backend.students.create', compact('mapel'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nisn' => 'required|string|max:20|unique:students,nisn',
            'nomor_peserta' => 'required|string|max:50|unique:students,nomor_peserta',
            'nama_lengkap' => 'required|string|max:255',
            'status_kelulusan' => 'required|in:lulus,tidak_lulus,ditunda',
        ], [
            'nisn.unique' => 'NISN sudah terdaftar di sistem.',
            'nomor_peserta.unique' => 'NIS/Nomor Peserta sudah terdaftar.',
            'nisn.required' => 'NISN wajib diisi.',
            'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
        ]);

        Student::create([
            'nisn' => $request->nisn,
            'nomor_peserta' => $request->nomor_peserta,
            'nama_lengkap' => $request->nama_lengkap,
            'status_kelulusan' => $request->status_kelulusan,
            'nilai_ujian' => $this->buildNilai($request),
        ]);

        return redirect()->route('admin.students.index')
            ->with('success', "Data siswa {$request->nama_lengkap} berhasil ditambahkan!");
    }

    // ──────────────────────────────────────────────
    // EDIT
    // ──────────────────────────────────────────────
    public function edit(Student $student)
    {
        $mapel = $this->getMapel();
        return view('backend.students.edit', compact('student', 'mapel'));
    }

    public function update(Request $request, Student $student)
    {
        $request->validate([
            'nisn' => 'required|string|max:20|unique:students,nisn,' . $student->id,
            'nomor_peserta' => 'required|string|max:50|unique:students,nomor_peserta,' . $student->id,
            'nama_lengkap' => 'required|string|max:255',
            'status_kelulusan' => 'required|in:lulus,tidak_lulus,ditunda',
        ], [
            'nisn.unique' => 'NISN sudah digunakan siswa lain.',
            'nomor_peserta.unique' => 'NIS/Nomor Peserta sudah digunakan siswa lain.',
        ]);

        $student->update([
            'nisn' => $request->nisn,
            'nomor_peserta' => $request->nomor_peserta,
            'nama_lengkap' => $request->nama_lengkap,
            'status_kelulusan' => $request->status_kelulusan,
            'nilai_ujian' => $this->buildNilai($request),
        ]);

        return redirect()->route('admin.students.index')
            ->with('success', "Data siswa {$student->nama_lengkap} berhasil diperbarui!");
    }

    // ──────────────────────────────────────────────
    // DELETE
    // ──────────────────────────────────────────────
    public function destroy(Student $student)
    {
        $nama = $student->nama_lengkap;
        $student->accessLogs()->delete();
        $student->delete();

        return redirect()->route('admin.students.index')
            ->with('success', "Data siswa {$nama} beserta log aksesnya berhasil dihapus!");
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->ids;
        if (empty($ids) || !is_array($ids)) {
            return redirect()->back()->with('error', 'Pilih minimal satu siswa.');
        }

        \App\Models\AccessLog::whereIn('student_id', $ids)->delete();
        Student::whereIn('id', $ids)->delete();

        return redirect()->route('admin.students.index')
            ->with('success', count($ids) . " data siswa berhasil dihapus secara masal!");
    }

    // ──────────────────────────────────────────────
    // PRINT SKL (PDF)
    // ──────────────────────────────────────────────
    private function preparePdfData($student, $setting)
    {
        $subjects = $this->getMapel();
        
        $kop_base64 = null;
        if ($setting->kop_surat && is_file(storage_path('app/public/' . $setting->kop_surat))) {
            $path = storage_path('app/public/' . $setting->kop_surat);
            $type = pathinfo($path, PATHINFO_EXTENSION);
            $data = file_get_contents($path);
            $kop_base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
        }

        $signature_base64 = null;
        if ($setting->signature && is_file(storage_path('app/public/' . $setting->signature))) {
            $path = storage_path('app/public/' . $setting->signature);
            $type = pathinfo($path, PATHINFO_EXTENSION);
            $data = file_get_contents($path);
            $signature_base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
        }

        $stamp_base64 = null;
        if ($setting->stamp && is_file(storage_path('app/public/' . $setting->stamp))) {
            $path = storage_path('app/public/' . $setting->stamp);
            $type = pathinfo($path, PATHINFO_EXTENSION);
            $data = file_get_contents($path);
            $stamp_base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
        }

        $skl_number_format = $setting->skl_number_format ?? '[YEAR]/SKL/[NIS]';
        $skl_number = str_replace(['[YEAR]', '[NIS]'], [date('Y'), $student->nomor_peserta], $skl_number_format);
        
        \Illuminate\Support\Carbon::setLocale('id');
        $skl_date = \Illuminate\Support\Carbon::now()->translatedFormat('d F Y');

        $verifyUrl = route('verify.skl', $student->nomor_peserta);
        $qrcode_base64 = base64_encode(\SimpleSoftwareIO\QrCode\Facades\QrCode::format('svg')->size(100)->errorCorrection('H')->generate($verifyUrl));
        $qrcode_base64 = 'data:image/svg+xml;base64,' . $qrcode_base64;

        return compact('student', 'setting', 'subjects', 'kop_base64', 'signature_base64', 'stamp_base64', 'skl_number', 'skl_date', 'qrcode_base64');
    }

    public function printPdf($id)
    {
        $student = Student::findOrFail($id);
        $setting = Setting::first() ?? new Setting();
        $data = $this->preparePdfData($student, $setting);

        $pdf = Pdf::loadView('backend.students.pdf_skl', $data)
                  ->setPaper('a4', 'portrait');

        return $pdf->stream("SKL_{$student->nisn}.pdf");
    }

    public function bulkPrintPdf(Request $request)
    {
        $ids = $request->ids;
        if (empty($ids) || !is_array($ids)) {
            return redirect()->back()->with('error', 'Pilih minimal satu siswa untuk dicetak.');
        }

        $students = Student::whereIn('id', $ids)->get();
        $setting = Setting::first() ?? new Setting();
        
        $preparedStudents = [];
        foreach ($students as $student) {
            $preparedStudents[] = $this->preparePdfData($student, $setting);
        }

        $pdf = Pdf::loadView('backend.students.pdf_bulk_skl', [
            'studentsData' => $preparedStudents,
            'setting' => $setting
        ])->setPaper('a4', 'portrait');

        return $pdf->stream("SKL_Masal_" . now()->format('Ymd_His') . ".pdf");
    }

    // ──────────────────────────────────────────────
    // EXPORT EXCEL
    // ──────────────────────────────────────────────
    public function exportExcel()
    {
        $filename = 'Data_Kelulusan_Siswa_' . now()->format('Ymd_His') . '.xlsx';
        return Excel::download(new \App\Exports\StudentsExport, $filename);
    }

    // ──────────────────────────────────────────────
    // IMPORT EXCEL
    // ──────────────────────────────────────────────
    public function import(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|mimes:xlsx,xls,csv|max:5120',
        ]);

        try {
            Excel::import(new \App\Imports\StudentsImport, $request->file('excel_file'));
            return redirect()->back()->with('success', 'Data siswa berhasil diimport!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal import: ' . $e->getMessage());
        }
    }

    // ──────────────────────────────────────────────
    // DOWNLOAD TEMPLATE
    // ──────────────────────────────────────────────
    public function template()
    {
        $filename = 'Template_Kelulusan_Import_Siswa_' . now()->format('Ymd_His') . '.xlsx';
        return Excel::download(new \App\Exports\StudentsTemplateExport, $filename);
    }
}
