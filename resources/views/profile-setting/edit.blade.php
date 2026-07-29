@extends('layouts.app')
@section('title', 'Profil Saya')

@section('content')
<h3 class="fw-bold mb-4">Profil Saya</h3>

<div class="row g-4">
    <div class="col-md-6">
        <div class="card stat-card p-4">
            <h6 class="fw-bold mb-3">Informasi Akun</h6>
            @if($errors->any() && old('nama_pengguna'))
                <div class="alert alert-danger">{{ $errors->first() }}</div>
            @endif
            <form action="/profile" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label class="form-label">Nama Pengguna</label>
                    <input type="text" name="nama_pengguna" class="form-control" value="{{ $pengguna->nama_pengguna }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <input type="text" name="username" class="form-control" value="{{ $pengguna->username }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Role</label>
                    <input type="text" class="form-control" value="{{ $pengguna->role }}" disabled>
                </div>
                <button type="submit" class="btn btn-success">Simpan Perubahan</button>
            </form>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card stat-card p-4">
            <h6 class="fw-bold mb-3">Ganti Password</h6>
            @if($errors->any() && old('password_lama') !== null)
                <div class="alert alert-danger">{{ $errors->first() }}</div>
            @endif
            <form action="/profile/password" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label class="form-label">Password Lama</label>
                    <input type="password" name="password_lama" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Password Baru</label>
                    <input type="password" name="password_baru" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Konfirmasi Password Baru</label>
                    <input type="password" name="password_baru_confirmation" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-success">Ubah Password</button>
            </form>
        </div>
    </div>
</div>
@endsection