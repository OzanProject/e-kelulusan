@extends('backend.layouts.app')

@section('title', 'Edit Profil')
@section('page_title', 'Pengaturan Profil Saya')

@section('content')
<div class="row">
    <div class="col-md-6">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show py-2">
                <i class="bi bi-check-circle-fill me-1"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="card shadow-sm border-0">
            <div class="card-header bg-white border-bottom">
                <h5 class="card-title mb-0 fw-bold text-primary"><i class="bi bi-person-gear me-1"></i> Data Akun</h5>
            </div>
            <form action="{{ route('admin.profile.update') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Lengkap</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                    </div>
                    
                    <hr class="my-4">
                    <div class="alert alert-info py-2 small">
                        <i class="bi bi-info-circle-fill me-1"></i> Kosongkan password jika tidak ingin mengubahnya.
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Password Baru</label>
                        <input type="password" name="password" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Konfirmasi Password Baru</label>
                        <input type="password" name="password_confirmation" class="form-control">
                    </div>
                </div>
                <div class="card-footer bg-light">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-1"></i> Perbarui Profil
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white border-bottom">
                <h5 class="card-title mb-0 fw-bold text-info"><i class="bi bi-shield-lock me-1"></i> Informasi Hak Akses</h5>
            </div>
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <div class="flex-shrink-0">
                        <div class="bg-light p-3 rounded">
                            <i class="bi bi-person-badge fs-2 text-primary"></i>
                        </div>
                    </div>
                    <div class="ms-3">
                        <h6 class="mb-0 fw-bold">Role Saat Ini</h6>
                        <span class="badge bg-primary text-uppercase">{{ $user->role }}</span>
                    </div>
                </div>
                <p class="text-muted small">
                    Hak akses Anda ditentukan oleh Administrator. Anda dapat mengubah nama, email, dan password Anda secara mandiri di sini.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
