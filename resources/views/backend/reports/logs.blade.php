@extends('backend.layouts.app')

@section('title', 'Log Akses Siswa')
@section('page_title', 'Laporan Log Akses Siswa')

@section('content')

{{-- Flash --}}
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show py-2">
        <i class="bi bi-check-circle-fill me-1"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="card shadow-sm border-0">
    <div class="card-header bg-white border-bottom py-2 px-3">
        <div class="d-flex flex-wrap align-items-center gap-2">
            <h5 class="mb-0 fw-bold text-dark me-auto">
                <i class="bi bi-journal-text me-1 text-primary"></i> Riwayat Akses Siswa
            </h5>

            {{-- Per-page --}}
            <form method="GET" action="{{ route('admin.reports.logs') }}" class="d-flex align-items-center gap-2">
                <span class="text-muted small">Tampilkan</span>
                <select name="per_page" class="form-select form-select-sm" style="width:70px" onchange="this.form.submit()">
                    @foreach([20, 50, 100] as $opt)
                        <option value="{{ $opt }}" {{ $perPage == $opt ? 'selected' : '' }}>{{ $opt }}</option>
                    @endforeach
                </select>
            </form>

            <div class="vr mx-1"></div>

            <form action="{{ route('admin.reports.logs.clear') }}" method="POST" onsubmit="return confirm('Hapus semua riwayat log akses? Tindakan ini tidak dapat dibatalkan.')">
                @csrf
                <button type="submit" class="btn btn-sm btn-outline-danger">
                    <i class="bi bi-trash"></i> Bersihkan Log
                </button>
            </form>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover table-striped align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th width="50" class="text-center">#</th>
                        <th width="200">Waktu Akses</th>
                        <th>Nama Siswa</th>
                        <th width="150">NISN</th>
                        <th width="150">IP Address</th>
                        <th>User Agent / Perangkat</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logs as $index => $log)
                    <tr>
                        <td class="text-center text-muted">{{ $logs->firstItem() + $index }}</td>
                        <td class="fw-bold">{{ $log->created_at->format('d/m/Y H:i:s') }}</td>
                        <td>
                            @if($log->student)
                                <a href="{{ route('admin.students.edit', $log->student_id) }}" class="text-decoration-none fw-semibold">
                                    {{ $log->student->nama_lengkap }}
                                </a>
                            @else
                                <span class="text-muted italic">Siswa Terhapus (ID: {{ $log->student_id }})</span>
                            @endif
                        </td>
                        <td class="text-muted">{{ $log->student->nisn ?? '-' }}</td>
                        <td><code class="text-primary">{{ $log->ip_address }}</code></td>
                        <td>
                            <small class="text-muted d-inline-block text-truncate" style="max-width: 300px;" title="{{ $log->user_agent }}">
                                {{ $log->user_agent }}
                            </small>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-5">
                            <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                            Belum ada riwayat akses tercatat.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer bg-white border-top py-2 px-3">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
            <div class="text-muted small">
                Menampilkan <strong>{{ $logs->firstItem() ?? 0 }}</strong>–<strong>{{ $logs->lastItem() ?? 0 }}</strong>
                dari <strong>{{ $logs->total() }}</strong> catatan
            </div>
            <div>{{ $logs->links('pagination::bootstrap-5') }}</div>
        </div>
    </div>
</div>
@endsection
