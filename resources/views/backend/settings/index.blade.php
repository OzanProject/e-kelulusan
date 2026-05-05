@extends('backend.layouts.app')

@section('title', 'Identitas Sekolah & SKL')
@section('page_title', 'Pengaturan Identitas & Aset SKL')

@section('content')

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show py-2">
        <i class="bi bi-check-circle-fill me-1"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row">

        {{-- Kolom Kiri: Identitas & Teks SKL --}}
        <div class="col-md-7">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white border-bottom">
                    <h5 class="card-title mb-0 fw-bold text-primary"><i class="bi bi-building me-1"></i> Identitas Sekolah</h5>
                </div>
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-3 text-center mb-3 mb-md-0">
                            <label class="form-label fw-bold d-block">Logo Sekolah</label>
                            @if($setting->school_logo)
                                <img src="{{ asset('storage/' . $setting->school_logo) }}" class="img-thumbnail rounded-circle mb-2" style="width: 80px; height: 80px; object-fit: cover;" alt="Logo">
                            @else
                                <div class="bg-light border rounded-circle d-flex align-items-center justify-content-center mx-auto mb-2" style="width: 80px; height: 80px;">
                                    <i class="bi bi-building fs-1 text-muted"></i>
                                </div>
                            @endif
                            <input type="file" name="school_logo" id="school_logo" class="d-none" accept="image/*">
                            <button type="button" class="btn btn-xs btn-outline-primary" onclick="document.getElementById('school_logo').click()">Ganti Logo</button>
                        </div>
                        <div class="col-md-9">
                            <div class="row">
                                <div class="col-md-7 mb-3">
                                    <label class="form-label fw-bold">Nama Sekolah <span class="text-danger">*</span></label>
                                    <input type="text" name="school_name" class="form-control" value="{{ old('school_name', $setting->school_name) }}" required placeholder="SMA Negeri 1 Jakarta">
                                </div>
                                <div class="col-md-5 mb-3">
                                    <label class="form-label fw-bold">Kota / Kabupaten <span class="text-danger">*</span></label>
                                    <input type="text" name="school_address_city" class="form-control" value="{{ old('school_address_city', $setting->school_address_city) }}" required placeholder="Contoh: Jakarta">
                                    <div class="form-text small">Digunakan di TTD SKL.</div>
                                </div>
                            </div>
                        </div>
                    </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Nama Kepala Sekolah <span class="text-danger">*</span></label>
                                <input type="text" name="principal_name" class="form-control" value="{{ old('principal_name', $setting->principal_name) }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">NIP Kepala Sekolah</label>
                                <input type="text" name="principal_nip" class="form-control" value="{{ old('principal_nip', $setting->principal_nip) }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Email Sekolah</label>
                                <input type="email" name="contact_email" class="form-control" value="{{ old('contact_email', $setting->contact_email) }}" placeholder="email@sekolah.sch.id">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Telepon / HP Panitia</label>
                                <input type="text" name="contact_phone" class="form-control" value="{{ old('contact_phone', $setting->contact_phone) }}" placeholder="021-xxxxxxx atau 08xxxx">
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label fw-bold">Alamat Sekolah</label>
                                <textarea name="contact_address" class="form-control" rows="2" placeholder="Jl. Raya No. 123...">{{ old('contact_address', $setting->contact_address) }}</textarea>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label fw-bold">Format Nomor SKL <span class="text-danger">*</span></label>
                                <input type="text" name="skl_number_format" class="form-control" value="{{ old('skl_number_format', $setting->skl_number_format ?? '[YEAR]/SKL/[NIS]') }}" required placeholder="Contoh: 400.3.5/100/159/20.17.04/5/[YEAR]">
                                <div class="form-text">Bebas diisi apa saja. Gunakan <code>[YEAR]</code> untuk tahun dan <code>[NIS]</code> untuk NIS Siswa jika diperlukan.</div>
                            </div>
                        </div>
                </div>
            </div>

            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white border-bottom">
                    <h5 class="card-title mb-0 fw-bold text-success"><i class="bi bi-file-earmark-text me-1"></i> Pengaturan Teks SKL</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">1. Kalimat Pembuka (Opening)</label>
                        <textarea name="skl_template" class="form-control" rows="3" required>{{ old('skl_template', $setting->skl_template ?? 'Berdasarkan hasil rapat pleno dewan guru dan mengacu pada kriteria kenaikan kelas yang telah ditetapkan, siswa yang bersangkutan dinyatakan:') }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">2. Kalimat Penutup (Closing)</label>
                        <textarea name="skl_closing" class="form-control" rows="2" required>{{ old('skl_closing', $setting->skl_closing ?? 'Demikian surat keterangan ini diberikan agar dapat dipergunakan sebagaimana mestinya.') }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">3. Catatan Kaki (Footer Note)</label>
                        <textarea name="skl_footer" class="form-control" rows="2" required>{{ old('skl_footer', $setting->skl_footer ?? '* Dokumen ini diterbitkan secara elektronik. Verifikasi keaslian dapat dilakukan dengan memindai kode QR di atas.') }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        {{-- Kolom Kanan: Aset Gambar SKL --}}
        <div class="col-md-5">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white border-bottom">
                    <h5 class="card-title mb-0 fw-bold text-info"><i class="bi bi-images me-1"></i> Aset Gambar & TTD</h5>
                </div>
                <div class="card-body">
                    
                    {{-- Kop Surat --}}
                    <div class="mb-4">
                        <label class="form-label fw-bold">Kop Surat (Header)</label>
                        @if($setting->kop_surat)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $setting->kop_surat) }}" class="img-fluid border rounded" alt="Kop Surat">
                            </div>
                        @endif
                        <input type="file" name="kop_surat" class="form-control" accept="image/jpeg,image/png,image/jpg">
                    </div>

                    <hr>

                    {{-- Tipe TTD --}}
                    <div class="mb-4">
                        <label class="form-label fw-bold mb-2 d-block">Tipe Tanda Tangan SKL</label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="signature_type" id="type_qr" value="qr" {{ $setting->signature_type == 'qr' ? 'checked' : '' }}>
                            <label class="form-check-label" for="type_qr">QR Code (Digital)</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="signature_type" id="type_manual" value="manual" {{ $setting->signature_type == 'manual' ? 'checked' : '' }}>
                            <label class="form-check-label" for="type_manual">Manual (Scan TTD & Stempel)</label>
                        </div>
                    </div>

                    {{-- Scan TTD --}}
                    <div class="mb-3">
                        <label class="form-label fw-bold">Scan Tanda Tangan (PNG Transparan)</label>
                        @if($setting->signature)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $setting->signature) }}" class="img-fluid border rounded" style="max-height: 80px;" alt="TTD">
                            </div>
                        @endif
                        <input type="file" name="signature" class="form-control" accept="image/png">
                    </div>

                    {{-- Stempel --}}
                    <div class="mb-3">
                        <label class="form-label fw-bold">Scan Stempel Sekolah (PNG Transparan)</label>
                        @if($setting->stamp)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $setting->stamp) }}" class="img-fluid border rounded" style="max-height: 80px;" alt="Stempel">
                            </div>
                        @endif
                        <input type="file" name="stamp" class="form-control" accept="image/png">
                    </div>

                </div>
                <div class="card-footer bg-light text-end">
                    <button type="submit" class="btn btn-primary w-100 py-2 fw-bold">
                        <i class="bi bi-save me-1"></i> Simpan Semua Pengaturan
                    </button>
                </div>
            </div>
        </div>

    </div>
</form>
@endsection
