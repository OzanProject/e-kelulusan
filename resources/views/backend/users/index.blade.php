@extends('backend.layouts.app')

@section('title', 'Manajemen Pengguna')
@section('page_title', 'Manajemen Pengguna')

@section('content')

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show py-2">
        <i class="bi bi-check-circle-fill me-1"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif
@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show py-2">
        <i class="bi bi-exclamation-triangle-fill me-1"></i> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="card shadow-sm border-0">
    <div class="card-header bg-white border-bottom py-2 px-3">
        <div class="d-flex align-items-center justify-content-between">
            <h5 class="mb-0 fw-bold text-primary">
                <i class="bi bi-person-gear me-1"></i> Daftar Admin & Petugas
            </h5>
            <a href="{{ route('admin.users.create') }}" class="btn btn-sm btn-primary">
                <i class="bi bi-person-plus-fill"></i> Tambah Pengguna
            </a>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th width="50" class="text-center">#</th>
                        <th>Nama Pengguna</th>
                        <th>Email</th>
                        <th class="text-center">Role</th>
                        <th class="text-center">Tgl Terdaftar</th>
                        <th width="120" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $index => $user)
                    <tr>
                        <td class="text-center text-muted">{{ $users->firstItem() + $index }}</td>
                        <td class="fw-bold">{{ $user->name }} @if($user->id === auth()->id()) <span class="badge bg-info text-dark ms-1">Saya</span> @endif</td>
                        <td>{{ $user->email }}</td>
                        <td class="text-center">
                            @if($user->role === 'admin')
                                <span class="badge bg-danger">Administrator</span>
                            @else
                                <span class="badge bg-warning text-dark">Petugas</span>
                            @endif
                        </td>
                        <td class="text-center text-muted small">{{ $user->created_at->format('d/m/Y') }}</td>
                        <td class="text-center">
                            <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-xs btn-warning">
                                <i class="bi bi-pencil-fill"></i>
                            </a>
                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus pengguna ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-xs btn-danger" @if($user->id === auth()->id()) disabled @endif>
                                    <i class="bi bi-trash-fill"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer bg-white border-top py-2 px-3 text-end">
        {{ $users->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
