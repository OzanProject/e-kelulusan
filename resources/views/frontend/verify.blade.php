<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi SKL - {{ $student->nama_lengkap }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet">
    <style>
        body { font-family: 'Public Sans', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 flex items-center justify-center min-h-screen p-6">
    <div class="max-w-md w-full bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
        <div class="bg-green-600 p-6 text-center text-white">
            <span class="material-symbols-outlined text-6xl mb-2">verified</span>
            <h1 class="text-xl font-bold">SKL Terverifikasi</h1>
            <p class="text-sm opacity-90">Dokumen ini asli dan terdaftar di sistem</p>
        </div>
        
        <div class="p-6 space-y-4">
            <div class="border-b pb-2">
                <p class="text-xs text-gray-500 uppercase font-bold tracking-wider">Nama Siswa</p>
                <p class="text-lg font-semibold text-gray-800">{{ $student->nama_lengkap }}</p>
            </div>
            <div class="border-b pb-2">
                <p class="text-xs text-gray-500 uppercase font-bold tracking-wider">NISN / No. Peserta</p>
                <p class="text-md font-semibold text-gray-800">{{ $student->nisn }} / {{ $student->nomor_peserta }}</p>
            </div>
            <div class="border-b pb-2">
                <p class="text-xs text-gray-500 uppercase font-bold tracking-wider">Status Kelulusan</p>
                <p class="text-md font-bold text-green-600 uppercase">{{ $student->status_kelulusan }}</p>
            </div>
            <div class="pt-2">
                <p class="text-xs text-gray-500 uppercase font-bold tracking-wider">Sekolah Penerbit</p>
                <p class="text-md font-semibold text-gray-800">{{ $setting->school_name }}</p>
            </div>
        </div>
        
        <div class="p-6 bg-gray-50 border-t text-center">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-green-600 font-bold hover:underline">
                <span class="material-symbols-outlined text-sm">home</span>
                Kembali ke Beranda
            </a>
        </div>
    </div>
</body>
</html>
