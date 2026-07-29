@extends('layouts.app')
@section('title', 'Data Pengguna')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="fw-bold">Kelola Data Pengguna</h3>
    <a href="/data-pengguna/create" class="btn btn-success"><i class="bi bi-plus-lg"></i> Tambah Pengguna</a>
</div>

<div class="card stat-card p-3">
    <table class="table table-striped align-middle">
        <thead>
            <tr><th>No.</th><th>Nama</th><th>Username</th><th>Role</th><th>Status</th><th>Aksi</th></tr>
        </thead>
        <tbody>
            @forelse($pengguna as $p)
            <tr>
                  <td>{{ $loop->iteration }}</td>
                <td>{{ $p->nama_pengguna }}</td>
                <td>{{ $p->username }}</td>
                <td><span class="badge bg-{{ $p->role == 'Admin' ? 'primary' : 'secondary' }}">{{ $p->role }}</span></td>
                <td>{{ $p->status }}</td>
                <td>
                    <form action="/data-pengguna/{{ $p->id_pengguna }}" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Yakin hapus?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="5" class="text-center text-muted">Belum ada data pengguna.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection