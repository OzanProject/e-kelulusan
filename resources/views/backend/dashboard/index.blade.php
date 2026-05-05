@extends('backend.layouts.app')

@section('title', 'Dashboard')
@section('page_title', 'Dashboard Ringkasan')

@section('content')
<div class="row">
    {{-- Total Siswa --}}
    <div class="col-lg-3 col-6">
        <div class="small-box text-bg-primary">
            <div class="inner">
                <h3>{{ $totalSiswa }}</h3>
                <p>Total Siswa</p>
            </div>
            <div class="small-box-icon">
                <i class="bi bi-people-fill"></i>
            </div>
            <a href="{{ route('admin.students.index') }}" class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                More info <i class="bi bi-link-45deg"></i>
            </a>
        </div>
    </div>

    {{-- Lulus --}}
    <div class="col-lg-3 col-6">
        <div class="small-box text-bg-success">
            <div class="inner">
                <h3>{{ $lulus }}</h3>
                <p>Lulus</p>
            </div>
            <div class="small-box-icon">
                <i class="bi bi-patch-check-fill"></i>
            </div>
            <a href="{{ route('admin.students.index', ['status' => 'lulus']) }}" class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                More info <i class="bi bi-link-45deg"></i>
            </a>
        </div>
    </div>

    {{-- Tidak Lulus --}}
    <div class="col-lg-3 col-6">
        <div class="small-box text-bg-danger">
            <div class="inner">
                <h3>{{ $tidakLulus }}</h3>
                <p>Tidak Lulus</p>
            </div>
            <div class="small-box-icon">
                <i class="bi bi-x-circle-fill"></i>
            </div>
            <a href="{{ route('admin.students.index', ['status' => 'tidak_lulus']) }}" class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                More info <i class="bi bi-link-45deg"></i>
            </a>
        </div>
    </div>

    {{-- Mapel --}}
    <div class="col-lg-3 col-6">
        <div class="small-box text-bg-warning">
            <div class="inner">
                <h3>{{ $totalMapel }}</h3>
                <p>Mata Pelajaran</p>
            </div>
            <div class="small-box-icon">
                <i class="bi bi-journal-bookmark-fill"></i>
            </div>
            <a href="{{ route('admin.subjects.index') }}" class="small-box-footer link-dark link-underline-opacity-0 link-underline-opacity-50-hover">
                More info <i class="bi bi-link-45deg"></i>
            </a>
        </div>
    </div>
</div>

<div class="row mt-4">
    {{-- Left: Charts / Status --}}
    <div class="col-lg-7">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-white border-bottom py-3">
                <h5 class="card-title mb-0 fw-bold"><i class="bi bi-graph-up me-1 text-primary"></i> Analitik Kelulusan</h5>
            </div>
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-6 text-center">
                        {{-- Circular progress for access --}}
                        <div class="position-relative d-inline-block">
                            <svg width="150" height="150" viewBox="0 0 36 36">
                                <path d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="#eee" stroke-width="3" />
                                <path d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="#0d6efd" stroke-width="3" stroke-dasharray="{{ $persentaseAkses }}, 100" />
                            </svg>
                            <div class="position-absolute top-50 start-50 translate-middle text-center">
                                <h2 class="mb-0 fw-bold">{{ $persentaseAkses }}%</h2>
                                <small class="text-muted d-block" style="font-size: 0.7rem;">Siswa Akses</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="small fw-bold text-muted d-block">Siswa Lulus</label>
                            <div class="progress" style="height: 10px;">
                                <div class="progress-bar bg-success" style="width: {{ $totalSiswa > 0 ? ($lulus/$totalSiswa)*100 : 0 }}%"></div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="small fw-bold text-muted d-block">Siswa Tidak Lulus</label>
                            <div class="progress" style="height: 10px;">
                                <div class="progress-bar bg-danger" style="width: {{ $totalSiswa > 0 ? ($tidakLulus/$totalSiswa)*100 : 0 }}%"></div>
                            </div>
                        </div>
                        <div class="mb-0">
                            <label class="small fw-bold text-muted d-block">Status Ditunda</label>
                            <div class="progress" style="height: 10px;">
                                <div class="progress-bar bg-warning" style="width: {{ $totalSiswa > 0 ? ($ditunda/$totalSiswa)*100 : 0 }}%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Right: Recent Activity --}}
    <div class="col-lg-5">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-white border-bottom py-3">
                <h5 class="card-title mb-0 fw-bold"><i class="bi bi-clock-history me-1 text-info"></i> Aktivitas Akses Terakhir</h5>
            </div>
            <div class="card-body p-0">
                <div class="list-group list-group-flush">
                    @forelse($recentLogs as $log)
                    <div class="list-group-item py-3">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="rounded-circle bg-light d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                    <i class="bi bi-person text-primary"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-0 fw-bold">{{ $log->student->nama_lengkap ?? 'Unknown' }}</h6>
                                <small class="text-muted">Mengakses portal via IP {{ $log->ip_address }}</small>
                            </div>
                            <div class="text-end">
                                <small class="text-muted d-block">{{ $log->created_at->diffForHumans() }}</small>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="p-4 text-center text-muted">
                        Belum ada aktivitas tercatat.
                    </div>
                    @endforelse
                </div>
            </div>
            <div class="card-footer bg-white border-top text-center py-2">
                <a href="{{ route('admin.reports.logs') }}" class="small text-decoration-none fw-bold">Lihat Semua Laporan <i class="bi bi-arrow-right"></i></a>
            </div>
        </div>
    </div>
</div>

{{-- Quick Actions --}}
<div class="row mt-4">
    <div class="col-12">
        <div class="card shadow-sm border-0 bg-light">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <h6 class="mb-0 fw-bold me-4 text-muted"><i class="bi bi-lightning-fill text-warning"></i> Quick Actions:</h6>
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.students.create') }}" class="btn btn-sm btn-white border shadow-sm"><i class="bi bi-plus-lg me-1"></i> Tambah Siswa</a>
                        <a href="{{ route('admin.subjects.index') }}" class="btn btn-sm btn-white border shadow-sm"><i class="bi bi-journal-plus me-1"></i> Tambah Mapel</a>
                        <a href="{{ route('admin.announcements.index') }}" class="btn btn-sm btn-white border shadow-sm"><i class="bi bi-clock me-1"></i> Atur Waktu</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
