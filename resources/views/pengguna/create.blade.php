@extends('layouts.app')
@section('title', 'Tambah Pengguna')

@section('content')
<h3 class="fw-bold mb-4">Tambah Data Pengguna</h3>

<div class="card stat-card p-4" style="max-width:500px;">
    <form action="/data-pengguna" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">Nama Pengguna</label>
            <input type="text" name="nama_pengguna" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Username</label>
            <input type="text" name="username" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Role</label>
            <select name="role" class="form-select" required>
                <option value="Admin">Admin</option>
                <option value="Kepala Desa">Kepala Desa</option>
            </select>
        </div>
        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="/data-pengguna" class="btn btn-outline-secondary">Batal</a>
    </form>
</div>
@endsection