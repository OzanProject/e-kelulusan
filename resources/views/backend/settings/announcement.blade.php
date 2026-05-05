@extends('backend.layouts.app')

@section('title', 'Waktu Pengumuman')
@section('page_title', 'Kontrol Waktu & Konten Pengumuman')

@section('content')

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show py-2">
        <i class="bi bi-check-circle-fill me-1"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<form action="{{ route('admin.announcements.update') }}" method="POST">
    @csrf
    <div class="row">
        {{-- Pengaturan Waktu --}}
        <div class="col-md-5">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white border-bottom">
                    <h5 class="card-title mb-0 fw-bold text-primary"><i class="bi bi-clock-history me-1"></i> Jadwal Buka Portal</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Tanggal Pengumuman</label>
                        <input type="date" name="announcement_date" class="form-control" value="{{ $setting->announcement_date ? $setting->announcement_date->format('Y-m-d') : '' }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Jam Pengumuman</label>
                        <input type="time" name="announcement_time" class="form-control" value="{{ $setting->announcement_date ? $setting->announcement_date->format('H:i') : '' }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Status Portal</label>
                        <select name="announcement_status" class="form-select" required>
                            <option value="1" {{ $setting->announcement_status ? 'selected' : '' }}>AKTIF (Buka Sesuai Jadwal)</option>
                            <option value="0" {{ !$setting->announcement_status ? 'selected' : '' }}>NON-AKTIF (Tutup Total)</option>
                        </select>
                        <div class="form-text">Jika NON-AKTIF, siswa tidak bisa cek kelulusan meskipun sudah lewat tanggalnya.</div>
                    </div>
                </div>
                <div class="card-footer bg-light">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-save me-1"></i> Simpan Pengaturan
                    </button>
                </div>
            </div>
        </div>

        {{-- Pengaturan Teks Halaman Depan --}}
        <div class="col-md-7">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white border-bottom">
                    <h5 class="card-title mb-0 fw-bold text-success"><i class="bi bi-pencil-square me-1"></i> Teks Halaman Depan & Hasil</h5>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <h6 class="fw-bold border-bottom pb-2 mb-3">Bagian Form Pencarian</h6>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Judul Form</label>
                            <input type="text" name="search_title" class="form-control" value="{{ old('search_title', $setting->search_title ?? 'Masukkan NISN / Nomor Peserta Anda') }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Deskripsi Form</label>
                            <textarea name="search_description" class="form-control" rows="2">{{ old('search_description', $setting->search_description ?? 'Silakan gunakan Nomor Induk Siswa Nasional atau Nomor Peserta yang terdaftar pada sistem.') }}</textarea>
                        </div>
                    </div>

                    <hr>

                    <div class="mb-4">
                        <h6 class="fw-bold border-bottom pb-2 mb-3">Halaman Pengumuman</h6>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Isi Halaman Pengumuman</label>
                            <textarea name="announcement_content" class="form-control" rows="5" placeholder="Tuliskan isi pengumuman resmi di sini...">{{ old('announcement_content', $setting->announcement_content ?? 'Selamat kepada seluruh siswa kelas XII yang telah menempuh ujian akhir. Hasil kelulusan dapat dicek secara mandiri melalui portal ini.') }}</textarea>
                            <div class="form-text">Teks ini akan muncul di halaman <code>/pengumuman</code>.</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
