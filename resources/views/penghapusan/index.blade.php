@extends('layouts.app')
@section('title', 'Penghapusan Aset')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="fw-bold">Kelola Penghapusan Aset</h3>
    @if(session('role') == 'Admin')
    <a href="/penghapusan/create" class="btn btn-success"><i class="bi bi-plus-lg"></i> Tambah Penghapusan</a>
    @endif
</div>

<div class="card stat-card p-3 mb-3">
    <form action="/penghapusan" method="GET">
        <input type="text" name="search" class="form-control" placeholder="Cari nama aset atau alasan penghapusan... (tekan Enter)" value="{{ request('search') }}">
    </form>
</div>

<div class="card stat-card p-3">
    <table class="table table-striped align-middle">
        <thead>
            <tr>
                <th>No.</th>
                <th>Aset</th>
                <th>Alasan</th>
                <th>Tanggal</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($penghapusan as $p)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $p->aset->nama_aset ?? '-' }}</td>
                <td>{{ $p->alasan_penghapusan }}</td>
                <td>{{ $p->tanggal_penghapusan }}</td>
                <td>
                    <span class="badge bg-{{ $p->status == 'Disetujui' ? 'success' : ($p->status == 'Ditolak' ? 'danger' : 'warning') }}">
                        {{ $p->status }}
                    </span>
                </td>
                <td>
                    @if(session('role') == 'Kepala Desa' && $p->status == 'Diajukan')
                        <form action="/penghapusan/{{ $p->id_penghapusan }}/approve" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Setujui penghapusan ini?')">Setujui</button>
                        </form>
                        <form action="/penghapusan/{{ $p->id_penghapusan }}/reject" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Tolak penghapusan ini?')">Tolak</button>
                        </form>
                    @elseif(session('role') == 'Admin')
                        <form action="/penghapusan/{{ $p->id_penghapusan }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Yakin hapus?')">Hapus</button>
                        </form>
                    @else
                        <span class="text-muted">-</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr><td colspan="6" class="text-center text-muted">Belum ada data penghapusan.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection