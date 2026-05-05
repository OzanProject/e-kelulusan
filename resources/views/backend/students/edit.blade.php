@extends('backend.layouts.app')

@section('title', 'Edit Siswa')
@section('page_title', 'Edit Data Siswa')

@section('content')
<form action="{{ route('admin.students.update', $student->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="row">

        {{-- Identitas Siswa --}}
        <div class="col-md-5">
            <div class="card card-outline card-warning shadow-sm">
                <div class="card-header"><h3 class="card-title">Identitas Siswa</h3></div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">NISN <span class="text-danger">*</span></label>
                        <input type="text" name="nisn" class="form-control @error('nisn') is-invalid @enderror" value="{{ old('nisn', $student->nisn) }}" required>
                        @error('nisn')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">NIS (Nomor Peserta) <span class="text-danger">*</span></label>
                        <input type="text" name="nomor_peserta" class="form-control @error('nomor_peserta') is-invalid @enderror" value="{{ old('nomor_peserta', $student->nomor_peserta) }}" required>
                        @error('nomor_peserta')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" name="nama_lengkap" class="form-control @error('nama_lengkap') is-invalid @enderror" value="{{ old('nama_lengkap', $student->nama_lengkap) }}" required>
                        @error('nama_lengkap')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Status Kelulusan <span class="text-danger">*</span></label>
                        <select name="status_kelulusan" class="form-select @error('status_kelulusan') is-invalid @enderror" required>
                            <option value="lulus" {{ old('status_kelulusan', $student->status_kelulusan) == 'lulus' ? 'selected' : '' }}>Lulus</option>
                            <option value="tidak_lulus" {{ old('status_kelulusan', $student->status_kelulusan) == 'tidak_lulus' ? 'selected' : '' }}>Tidak Lulus</option>
                            <option value="ditunda" {{ old('status_kelulusan', $student->status_kelulusan) == 'ditunda' ? 'selected' : '' }}>Ditunda</option>
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
                            <input type="number" name="sakit" class="form-control" value="{{ old('sakit', $student->nilai_ujian['Sakit'] ?? 0) }}" min="0">
                        </div>
                        <div class="col-4">
                            <label class="form-label fw-bold">Izin</label>
                            <input type="number" name="izin" class="form-control" value="{{ old('izin', $student->nilai_ujian['Izin'] ?? 0) }}" min="0">
                        </div>
                        <div class="col-4">
                            <label class="form-label fw-bold">Alpa</label>
                            <input type="number" name="alpa" class="form-control" value="{{ old('alpa', $student->nilai_ujian['Alpa'] ?? 0) }}" min="0">
                        </div>
                    </div>
                    <div class="mt-3">
                        <label class="form-label fw-bold">Ekskul Pramuka</label>
                        <input type="text" name="pramuka" class="form-control" value="{{ old('pramuka', $student->nilai_ujian['Pramuka'] ?? 'B') }}">
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
                        <small><i class="bi bi-info-circle"></i> Nilai total (TTL) akan dihitung ulang otomatis saat disimpan.</small>
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
                            @php
                                $fieldKey    = 'nilai_' . preg_replace('/[^a-z0-9]/', '_', strtolower($s->kode));
                                $savedValue  = $student->nilai_ujian[$s->kode] ?? null;
                            @endphp
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">{{ $s->kode }} — {{ $s->nama }}</label>
                                <input type="number" name="{{ $fieldKey }}" class="form-control"
                                       value="{{ old($fieldKey, is_numeric($savedValue) ? $savedValue : '') }}"
                                       min="0" max="100" placeholder="0–100">
                            </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="d-flex gap-2">
        <button type="submit" class="btn btn-warning"><i class="bi bi-save"></i> Update Data</button>
        <a href="{{ route('admin.students.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Batal</a>
    </div>
</form>
@endsection
