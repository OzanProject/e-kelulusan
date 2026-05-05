@extends('auth.layouts.auth')

@section('title', 'Register')
@section('body_class', 'register-page')
@section('box_class', 'register-box')
@section('card_class', 'register-card-body')

@section('content')
<h5 class="fw-bold text-center mb-4">Daftar Akun Admin Baru</h5>

<form action="{{ route('register.post') }}" method="post">
    @csrf
    <div class="mb-3">
        <label class="form-label small fw-bold text-muted">Nama Lengkap</label>
        <div class="input-group">
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Nama lengkap anda" value="{{ old('name') }}" required autofocus />
            <span class="input-group-text bg-light text-muted">
                <i class="bi bi-person"></i>
            </span>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="mb-3">
        <label class="form-label small fw-bold text-muted">Alamat Email</label>
        <div class="input-group">
            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="email@contoh.com" value="{{ old('email') }}" required />
            <span class="input-group-text bg-light text-muted">
                <i class="bi bi-envelope"></i>
            </span>
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="mb-3">
        <label class="form-label small fw-bold text-muted">Kata Sandi Baru</label>
        <div class="input-group">
            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Minimal 8 karakter" required />
            <span class="input-group-text bg-light text-muted">
                <i class="bi bi-lock"></i>
            </span>
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="mb-4">
        <label class="form-label small fw-bold text-muted">Konfirmasi Sandi</label>
        <div class="input-group">
            <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi password" required />
            <span class="input-group-text bg-light text-muted">
                <i class="bi bi-shield-lock"></i>
            </span>
        </div>
    </div>

    <div class="d-grid mb-3">
        <button type="submit" class="btn btn-primary py-2 fw-bold shadow-sm">
            Daftar Sekarang <i class="bi bi-check-circle-fill ms-1"></i>
        </button>
    </div>
</form>

<hr class="text-muted">

<div class="text-center">
    <p class="small text-muted mb-0">Sudah punya akun? <a href="{{ route('login') }}" class="fw-bold text-decoration-none">Masuk di sini</a></p>
</div>
@endsection
