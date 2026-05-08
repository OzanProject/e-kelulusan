<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;
use App\Models\Student;
use App\Models\Subject;

class FrontendController extends Controller
{
    public function index()
    {
        $setting = Setting::first() ?? new Setting();
        
        // Ambil waktu sekarang
        $now = now();
        $isOpened = false;

        if ($setting->announcement_status) {
            if ($setting->announcement_date && $now->greaterThanOrEqualTo($setting->announcement_date)) {
                $isOpened = true;
            }
        }

        return view('frontend.index', compact('setting', 'isOpened', 'now'));
    }

    public function cek(Request $request)
    {
        $setting = Setting::first() ?? new Setting();
        $now = now();

        // Validasi akses (takutnya ditembak via API/Postman saat masih tutup)
        if (!$setting->announcement_status || ($setting->announcement_date && $now->lessThan($setting->announcement_date))) {
            return redirect()->route('home')->with('error', 'Pengumuman kelulusan belum dibuka.');
        }

        $request->validate([
            'nomor_peserta' => 'required|string',
        ], [
            'nomor_peserta.required' => 'Masukkan NISN atau Nomor Peserta.'
        ]);

        $input = $request->nomor_peserta;

        // Cari siswa berdasarkan NISN ATAU Nomor Peserta
        $student = Student::where('nisn', $input)
                          ->orWhere('nomor_peserta', $input)
                          ->first();

        if (!$student) {
            return redirect()->route('home')
                             ->withInput()
                             ->with('error', 'Data tidak ditemukan! Pastikan NISN atau Nomor Peserta sudah benar.');
        }

        // Catat ke access_logs jika siswa berhasil menemukan datanya
        $student->accessLogs()->create([
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        $subjects = Subject::aktif();

        return view('frontend.result', compact('student', 'setting', 'subjects'));
    }

    public function pengumuman()
    {
        $setting = Setting::first() ?? new Setting();
        return view('frontend.pengumuman', compact('setting'));
    }

    public function contact()
    {
        $setting = Setting::first() ?? new Setting();
        return view('frontend.contact', compact('setting'));
    }

    public function downloadSkl($id)
    {
        $student = Student::findOrFail($id);
        $setting = Setting::first() ?? new Setting();
        $subjects = Subject::aktif();

        if ($student->status_kelulusan !== 'lulus') {
            abort(403, 'SKL hanya tersedia untuk siswa yang lulus.');
        }

        $kop_base64 = $setting->kop_surat ? $this->imageToBase64(public_path('storage/' . $setting->kop_surat)) : null;
        $stamp_base64 = $setting->stamp ? $this->imageToBase64(public_path('storage/' . $setting->stamp)) : null;
        
        // Generate QR Code for Verification (SVG to avoid Imagick dependency)
        $verifyUrl = route('verify.skl', $student->nomor_peserta);
        $qrcode = base64_encode(\SimpleSoftwareIO\QrCode\Facades\QrCode::format('svg')
                        ->size(150)->errorCorrection('H')
                        ->generate($verifyUrl));
        $qrcode_base64 = 'data:image/svg+xml;base64,' . $qrcode;
        $signature_base64 = $setting->signature ? $this->imageToBase64(public_path('storage/' . $setting->signature)) : null;

        // Parse SKL Number
        $skl_number_format = $setting->skl_number_format ?? '[YEAR]/SKL/[NIS]';
        $skl_number = str_replace(
            ['[YEAR]', '[NIS]'],
            [date('Y'), $student->nomor_peserta],
            $skl_number_format
        );

        // Set locale for date translation
        \Carbon\Carbon::setLocale('id');
        $skl_date = \Carbon\Carbon::now()->translatedFormat('d F Y');

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('frontend.pdf.skl', compact(
            'student', 'setting', 'subjects', 'kop_base64', 'stamp_base64', 'qrcode_base64', 'signature_base64', 'skl_number', 'skl_date'
        ));

        // Set locale for date translation
        \Carbon\Carbon::setLocale('id');
        $date = \Carbon\Carbon::now()->translatedFormat('d F Y');
        $pdf->getDomPDF()->set_option('isHtml5ParserEnabled', true);
        $pdf->getDomPDF()->set_option('isRemoteEnabled', true);

        $safeName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $student->nama_lengkap);
        return $pdf->download('SKL_' . $student->nomor_peserta . '_' . $safeName . '.pdf');
    }

    public function verify($nomor_peserta)
    {
        $student = Student::where('nomor_peserta', $nomor_peserta)->firstOrFail();
        $setting = Setting::first() ?? new Setting();
        return view('frontend.verify', compact('student', 'setting'));
    }

    private function imageToBase64($path)
    {
        if (is_file($path)) {
            $type = pathinfo($path, PATHINFO_EXTENSION);
            $data = file_get_contents($path);
            return 'data:image/' . $type . ';base64,' . base64_encode($data);
        }
        return null;
    }
}
