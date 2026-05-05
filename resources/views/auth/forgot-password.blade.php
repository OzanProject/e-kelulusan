@extends('auth.layouts.auth')

@section('title', 'Lupa Password')
@section('body_class', 'login-page')
@section('box_class', 'login-box')
@section('card_class', 'login-card-body')

@section('content')
<h5 class="fw-bold text-center mb-4">Lupa Kata Sandi?</h5>
<p class="small text-muted text-center mb-4">Masukkan email anda dan kami akan mengirimkan instruksi pemulihan kata sandi.</p>

<form action="#" method="post">
    @csrf
    <div class="mb-4">
        <label class="form-label small fw-bold text-muted">Alamat Email</label>
        <div class="input-group">
            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="email@contoh.com" required autofocus />
            <span class="input-group-text bg-light text-muted">
                <i class="bi bi-envelope"></i>
            </span>
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="d-grid mb-3">
        <button type="submit" class="btn btn-primary py-2 fw-bold shadow-sm">
            Kirim Link Pemulihan <i class="bi bi-send ms-1"></i>
        </button>
    </div>
</form>

<hr class="text-muted">

<div class="text-center">
    <p class="small text-muted mb-0">Ingat password anda? <a href="{{ route('login') }}" class="fw-bold text-decoration-none">Kembali Login</a></p>
</div>
@endsection
