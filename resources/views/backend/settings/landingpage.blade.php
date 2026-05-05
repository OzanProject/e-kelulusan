@extends('backend.layouts.app')

@section('title', 'Konten Landing Page')
@section('page_title', 'Pengaturan Halaman Utama (Siswa)')

@section('content')

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show py-2">
        <i class="bi bi-check-circle-fill me-1"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<form action="{{ route('admin.landingpage.update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    
    <div class="row">
        {{-- Hero Section & Pesan Kepsek --}}
        <div class="col-md-7">
            
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white border-bottom">
                    <h5 class="card-title mb-0 fw-bold text-primary"><i class="bi bi-layout-text-window me-1"></i> Header (Hero Section)</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Judul Utama <span class="text-danger">*</span></label>
                        <input type="text" name="hero_title" class="form-control" value="{{ old('hero_title', $setting->hero_title ?? 'Selamat & Sukses! Pengumuman Kelulusan Angkatan '.date('Y')) }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Deskripsi Singkat</label>
                        <textarea name="hero_description" class="form-control" rows="3">{{ old('hero_description', $setting->hero_description ?? 'Akses hasil kelulusan, jadwal pengambilan dokumen, dan informasi purna studi melalui portal ini.') }}</textarea>
                    </div>
                    
                    {{-- Hero Background Image --}}
                    <div class="mb-3">
                        <label class="form-label fw-bold"><i class="bi bi-image me-1"></i>Foto / Gambar Latar Hero</label>
                        @if($setting->hero_background)
                            <div class="mb-2 position-relative">
                                <img src="{{ asset('storage/' . $setting->hero_background) }}" 
                                     class="img-fluid rounded border shadow-sm w-100" 
                                     style="max-height: 180px; object-fit: cover;" 
                                     alt="Hero Background">
                                <span class="badge bg-success position-absolute top-0 end-0 m-2">
                                    <i class="bi bi-check-circle me-1"></i>Gambar Aktif
                                </span>
                            </div>
                        @else
                            <div class="mb-2 rounded border bg-light d-flex align-items-center justify-content-center" style="height: 100px;">
                                <span class="text-muted small"><i class="bi bi-image text-secondary me-1"></i>Belum ada gambar latar, menggunakan gambar default.</span>
                            </div>
                        @endif
                        <input type="file" name="hero_background" class="form-control" accept="image/jpeg,image/png,image/jpg,image/webp">
                        <div class="form-text text-muted">Format: JPG, PNG, WEBP. Maks. 5MB. Disarankan ukuran minimal 1920×450px (landscape).</div>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white border-bottom">
                    <h5 class="card-title mb-0 fw-bold text-success"><i class="bi bi-chat-quote me-1"></i> Pesan Kepala Sekolah</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold">Foto Kepala Sekolah</label>
                            @if($setting->principal_photo)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $setting->principal_photo) }}" class="img-fluid border rounded" style="max-height: 150px; object-fit: cover;" alt="Foto Kepsek">
                                </div>
                            @endif
                            <input type="file" name="principal_photo" class="form-control" accept="image/jpeg,image/png,image/jpg">
                        </div>
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Nama Kepala Sekolah</label>
                                <input type="text" class="form-control bg-light" value="{{ $setting->principal_name }}" disabled>
                                <div class="form-text text-muted small">Ubah di menu <a href="{{ route('admin.settings.index') }}">Identitas & SKL</a></div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Isi Pesan</label>
                                <textarea name="principal_message" class="form-control" rows="4">{{ old('principal_message', $setting->principal_message ?? '"Selamat kepada seluruh siswa kelas akhir yang telah menyelesaikan masa studi. Pengumuman ini merupakan awal dari perjalanan panjang kalian menuju kesuksesan. Jadilah lulusan yang berintegritas, inovatif, dan membawa nama baik almamater di manapun berada."') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white border-bottom">
                    <h5 class="card-title mb-0 fw-bold text-info"><i class="bi bi-telephone-inbound me-1"></i> Pusat Bantuan & Sosial Media</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Waktu Layanan Helpdesk</label>
                            <input type="text" name="helpdesk_time" class="form-control" value="{{ old('helpdesk_time', $setting->helpdesk_time ?? 'Senin - Jumat, 08:00 - 15:00 WIB') }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Email Panitia</label>
                            <input type="email" name="email_panitia" class="form-control" value="{{ old('email_panitia', $setting->email_panitia ?? 'info@sekolah.sch.id') }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Telepon TU</label>
                            <input type="text" name="phone" class="form-control" value="{{ old('phone', $setting->phone ?? '(021) 12345678') }}">
                        </div>
                    </div>

                    <hr>
                    <h6 class="fw-bold mb-3">Link Sosial Media Sekolah (Footer)</h6>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-facebook text-primary"></i></span>
                                <input type="url" name="facebook" class="form-control" placeholder="URL Facebook" value="{{ old('facebook', $setting->facebook) }}">
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-instagram text-danger"></i></span>
                                <input type="url" name="instagram" class="form-control" placeholder="URL Instagram" value="{{ old('instagram', $setting->instagram) }}">
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-youtube text-danger"></i></span>
                                <input type="url" name="youtube" class="form-control" placeholder="URL YouTube" value="{{ old('youtube', $setting->youtube) }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        {{-- Kolom Kanan: Agenda Lanjutan --}}
        <div class="col-md-5">
            <div class="card shadow-sm border-0 mb-4 sticky-top" style="top: 20px;">
                <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0 fw-bold text-warning"><i class="bi bi-calendar-event me-1"></i> Agenda Lanjutan</h5>
                    <button type="button" class="btn btn-sm btn-outline-warning" id="add-agenda">
                        <i class="bi bi-plus-circle me-1"></i> Tambah Agenda
                    </button>
                </div>
                <div class="card-body bg-light">
                    
                    <div class="alert alert-info py-2 small mb-3">
                        Agenda 1 (Pengumuman Online) sudah otomatis diatur dari menu <b>Waktu Pengumuman</b>.
                    </div>

                    <div id="agenda-container">
                        @php
                            $agendas = old('agendas', is_array($setting->agendas) ? $setting->agendas : []);
                        @endphp

                        @foreach($agendas as $index => $agenda)
                            <div class="card border-0 shadow-sm mb-3 agenda-item">
                                <div class="card-body p-3">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <h6 class="fw-bold mb-0">Agenda Tambahan</h6>
                                        <button type="button" class="btn btn-link text-danger p-0 remove-agenda">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label small fw-bold">Judul Agenda</label>
                                        <input type="text" name="agendas[{{ $index }}][title]" class="form-control form-control-sm" value="{{ $agenda['title'] ?? '' }}" required>
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label small fw-bold">Waktu Pelaksanaan</label>
                                        <input type="text" name="agendas[{{ $index }}][date]" class="form-control form-control-sm" value="{{ $agenda['date'] ?? '' }}" required>
                                    </div>
                                    <div class="mb-0">
                                        <label class="form-label small fw-bold">Deskripsi Singkat</label>
                                        <textarea name="agendas[{{ $index }}][desc]" class="form-control form-control-sm" rows="3">{{ $agenda['desc'] ?? '' }}</textarea>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                </div>
                <div class="card-footer bg-white border-top text-end p-3">
                    <button type="submit" class="btn btn-primary btn-lg w-100 shadow-sm">
                        <i class="bi bi-save me-1"></i> Simpan Semua Perubahan
                    </button>
                </div>
            </div>
        </div>

    </div>
</form>

<template id="agenda-template">
    <div class="card border-0 shadow-sm mb-3 agenda-item">
        <div class="card-body p-3">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h6 class="fw-bold mb-0">Agenda Tambahan</h6>
                <button type="button" class="btn btn-link text-danger p-0 remove-agenda">
                    <i class="bi bi-trash"></i>
                </button>
            </div>
            <div class="mb-2">
                <label class="form-label small fw-bold">Judul Agenda</label>
                <input type="text" name="agendas[INDEX][title]" class="form-control form-control-sm" placeholder="Contoh: Pengembalian Buku" required>
            </div>
            <div class="mb-2">
                <label class="form-label small fw-bold">Waktu Pelaksanaan</label>
                <input type="text" name="agendas[INDEX][date]" class="form-control form-control-sm" placeholder="Contoh: 10 Mei 2024" required>
            </div>
            <div class="mb-0">
                <label class="form-label small fw-bold">Deskripsi Singkat</label>
                <textarea name="agendas[INDEX][desc]" class="form-control form-control-sm" rows="3" placeholder="Jelaskan detail agenda..."></textarea>
            </div>
        </div>
    </div>
</template>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const container = document.getElementById('agenda-container');
        const addButton = document.getElementById('add-agenda');
        const template = document.getElementById('agenda-template').innerHTML;
        let index = container.querySelectorAll('.agenda-item').length;

        addButton.addEventListener('click', function() {
            const html = template.replace(/INDEX/g, index++);
            container.insertAdjacentHTML('beforeend', html);
        });

        container.addEventListener('click', function(e) {
            if (e.target.closest('.remove-agenda')) {
                e.target.closest('.agenda-item').remove();
            }
        });
    });
</script>
@endpush

@endsection
