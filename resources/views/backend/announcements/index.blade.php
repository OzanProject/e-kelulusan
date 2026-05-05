@extends('backend.layouts.app')

@section('title', 'Waktu Pengumuman')
@section('page_title', 'Kontrol Waktu Pengumuman')

@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="card card-outline card-warning">
            <div class="card-header">
                <h3 class="card-title">Jadwal Pengumuman</h3>
            </div>
            <div class="card-body">
                <form>
                    <div class="mb-3">
                        <label class="form-label">Tanggal & Jam</label>
                        <input type="datetime-local" class="form-control">
                        <small class="text-muted">Tentukan kapan siswa bisa mulai melihat hasil kelulusan.</small>
                    </div>
                    <button type="button" class="btn btn-primary">Simpan Jadwal</button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card card-outline card-danger">
            <div class="card-header">
                <h3 class="card-title">Akses Darurat (Switch)</h3>
            </div>
            <div class="card-body">
                <p>Gunakan tombol ini untuk memaksa buka atau tutup akses pengumuman tanpa mengabaikan jadwal timer.</p>
                <div class="form-check form-switch mb-3">
                    <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault">
                    <label class="form-check-label" for="flexSwitchCheckDefault">Buka Akses Pengumuman Sekarang</label>
                </div>
                <button type="button" class="btn btn-danger">Simpan Status</button>
            </div>
        </div>
    </div>
</div>
@endsection
