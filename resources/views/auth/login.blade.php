@extends('auth.layouts.auth')

@section('title', 'Login')
@section('body_class', 'login-page')
@section('box_class', 'login-box')
@section('card_class', 'login-card-body')

@section('content')
<h5 class="fw-bold text-center mb-4">Masuk ke Panel Kontrol</h5>

<form action="{{ route('login.post') }}" method="post">
    @csrf
    <div class="mb-3">
        <label class="form-label small fw-bold text-muted">Email Pengguna</label>
        <div class="input-group">
            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Masukkan email anda" value="{{ old('email') }}" required autofocus />
            <span class="input-group-text bg-light text-muted">
                <i class="bi bi-envelope"></i>
            </span>
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="mb-4">
        <label class="form-label small fw-bold text-muted">Kata Sandi</label>
        <div class="input-group">
            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Masukkan password anda" required />
            <span class="input-group-text bg-light text-muted">
                <i class="bi bi-lock"></i>
            </span>
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="row align-items-center mb-4">
        <div class="col-7">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="remember" id="remember" />
                <label class="form-check-label small text-muted" for="remember"> Ingat Sesi Saya </label>
            </div>
        </div>
        <div class="col-5 text-end">
            <a href="{{ route('password.request') }}" class="small text-decoration-none">Lupa Password?</a>
        </div>
    </div>

    <div class="d-grid mb-3">
        <button type="submit" class="btn btn-primary py-2 fw-bold shadow-sm">
            Masuk Sekarang <i class="bi bi-arrow-right-short ms-1"></i>
        </button>
    </div>
</form>

<hr class="text-muted">

<div class="text-center">
    <p class="small text-muted mb-0">Belum punya akun? <a href="{{ route('register') }}" class="fw-bold text-decoration-none">Daftar Akun Baru</a></p>
</div>
@endsection
