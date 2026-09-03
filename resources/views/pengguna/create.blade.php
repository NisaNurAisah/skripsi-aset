@extends('layouts.app')
@section('title', 'Tambah Pengguna')

@section('content')
<h3 class="fw-bold mb-4 text-center">Tambah Data Pengguna</h3>

<div class="card stat-card p-4 mx-auto" style="max-width:500px;">
    <form action="/data-pengguna" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">Nama Pengguna</label>
            <input type="text" name="nama_pengguna" class="form-control @error('nama_pengguna') is-invalid @enderror" value="{{ old('nama_pengguna') }}">
            @error('nama_pengguna')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Username</label>
            <input type="text" name="username" class="form-control @error('username') is-invalid @enderror" value="{{ old('username') }}">
            @error('username')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
            <small class="text-muted">Minimal 6 karakter</small>
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Role</label>
            <select name="role" class="form-select @error('role') is-invalid @enderror">
                <option value="">-- Pilih Role --</option>
                <option value="Admin" {{ old('role') == 'Admin' ? 'selected' : '' }}>Admin</option>
                <option value="Kepala Desa" {{ old('role') == 'Kepala Desa' ? 'selected' : '' }}>Kepala Desa</option>
            </select>
            @error('role')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="/data-pengguna" class="btn btn-outline-secondary">Batal</a>
    </form>
</div>
@endsection