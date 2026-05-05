@extends('backend.layouts.app')

@section('title', 'Tambah Siswa')
@section('page_title', 'Tambah Data Siswa')

@section('content')
<form action="{{ route('admin.students.store') }}" method="POST">
    @csrf
    <div class="row">

        {{-- Identitas Siswa --}}
        <div class="col-md-5">
            <div class="card card-outline card-primary shadow-sm">
                <div class="card-header"><h3 class="card-title">Identitas Siswa</h3></div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">NISN <span class="text-danger">*</span></label>
                        <input type="text" name="nisn" class="form-control @error('nisn') is-invalid @enderror" value="{{ old('nisn') }}" placeholder="Masukkan NISN" required>
                        @error('nisn')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">NIS (Nomor Peserta) <span class="text-danger">*</span></label>
                        <input type="text" name="nomor_peserta" class="form-control @error('nomor_peserta') is-invalid @enderror" value="{{ old('nomor_peserta') }}" placeholder="Masukkan NIS / Nomor Peserta" required>
                        @error('nomor_peserta')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" name="nama_lengkap" class="form-control @error('nama_lengkap') is-invalid @enderror" value="{{ old('nama_lengkap') }}" placeholder="Masukkan nama lengkap" required>
                        @error('nama_lengkap')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Status Kelulusan <span class="text-danger">*</span></label>
                        <select name="status_kelulusan" class="form-select @error('status_kelulusan') is-invalid @enderror" required>
                            <option value="">-- Pilih Status --</option>
                            <option value="lulus" {{ old('status_kelulusan') == 'lulus' ? 'selected' : '' }}>Lulus</option>
                            <option value="tidak_lulus" {{ old('status_kelulusan') == 'tidak_lulus' ? 'selected' : '' }}>Tidak Lulus</option>
                            <option value="ditunda" {{ old('status_kelulusan') == 'ditunda' ? 'selected' : '' }}>Ditunda</option>
                        </select>
                        @error('status_kelulusan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>

            {{-- Ketidakhadiran & Ekskul --}}
            <div class="card card-outline card-secondary shadow-sm">
                <div class="card-header"><h3 class="card-title">Ketidakhadiran & Ekskul</h3></div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-4">
                            <label class="form-label fw-bold">Sakit</label>
                            <input type="number" name="sakit" class="form-control" value="{{ old('sakit', 0) }}" min="0">
                        </div>
                        <div class="col-4">
                            <label class="form-label fw-bold">Izin</label>
                            <input type="number" name="izin" class="form-control" value="{{ old('izin', 0) }}" min="0">
                        </div>
                        <div class="col-4">
                            <label class="form-label fw-bold">Alpa</label>
                            <input type="number" name="alpa" class="form-control" value="{{ old('alpa', 0) }}" min="0">
                        </div>
                    </div>
                    <div class="mt-3">
                        <label class="form-label fw-bold">Ekskul Pramuka</label>
                        <input type="text" name="pramuka" class="form-control" value="{{ old('pramuka', 'B') }}" placeholder="Contoh: A, B, C">
                    </div>
                </div>
            </div>
        </div>

        {{-- Nilai Mata Pelajaran --}}
        <div class="col-md-7">
            <div class="card card-outline card-success shadow-sm">
                <div class="card-header"><h3 class="card-title">Nilai Mata Pelajaran</h3></div>
                <div class="card-body">
                    <div class="alert alert-info py-2">
                        <small><i class="bi bi-info-circle"></i> Nilai total (TTL) akan dihitung otomatis saat disimpan.</small>
                    </div>
                    <div class="row">
                        @if($mapel->isEmpty())
                            <div class="col-12">
                                <div class="alert alert-warning">
                                    <i class="bi bi-exclamation-triangle"></i>
                                    Belum ada mata pelajaran yang dikonfigurasi.
                                    <a href="{{ route('admin.subjects.index') }}">Tambah sekarang →</a>
                                </div>
                            </div>
                        @else
                            @foreach($mapel as $s)
                            @php $fieldKey = 'nilai_' . preg_replace('/[^a-z0-9]/', '_', strtolower($s->kode)); @endphp
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">{{ $s->kode }} — {{ $s->nama }}</label>
                                <input type="number" name="{{ $fieldKey }}" class="form-control"
                                       value="{{ old($fieldKey) }}" min="0" max="100" placeholder="0–100">
                            </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="d-flex gap-2">
        <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Simpan Data</button>
        <a href="{{ route('admin.students.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Batal</a>
    </div>
</form>
@endsection
