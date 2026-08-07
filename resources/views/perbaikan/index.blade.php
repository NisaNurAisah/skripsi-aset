@extends('layouts.app')
@section('title', 'Perbaikan Aset')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="fw-bold">Perbaikan Inventaris</h3>
    @if(session('role') == 'Admin')
    <a href="/perbaikan/create" class="btn btn-success"><i class="bi bi-plus-lg"></i> Tambah Perbaikan</a>
    @endif
</div>

<div class="card stat-card p-3">
    <table class="table table-striped align-middle">
        <thead>
            <tr>
                <th>No.</th>
                <th>Inventaris</th>
                <th>Deskripsi Kerusakan</th>
                <th>Tanggal</th>
                <th>Biaya</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($perbaikan as $p)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $p->aset->nama_aset ?? '-' }}</td>
                <td>{{ $p->deskripsi_kerusakan }}</td>
                <td>{{ $p->tanggal_perbaikan }}</td>
                <td>{{ $p->biaya_perbaikan ? 'Rp ' . number_format($p->biaya_perbaikan, 0, ',', '.') : '-' }}</td>
                <td>
                    <span class="badge bg-{{ $p->status == 'Disetujui' ? 'success' : ($p->status == 'Ditolak' ? 'danger' : 'warning') }}">
                        {{ $p->status }}
                    </span>
                </td>
                <td>
                    @if(session('role') == 'Kepala Desa' && $p->status == 'Diajukan')
                        <form action="/perbaikan/{{ $p->id_perbaikan }}/approve" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Setujui perbaikan ini?')">Setujui</button>
                        </form>
                        <form action="/perbaikan/{{ $p->id_perbaikan }}/reject" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Tolak perbaikan ini?')">Tolak</button>
                        </form>
                    @elseif(session('role') == 'Admin')
                        <form action="/perbaikan/{{ $p->id_perbaikan }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Yakin hapus?')">Hapus</button>
                        </form>
                    @else
                        <span class="text-muted">-</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr><td colspan="7" class="text-center text-muted">Belum ada data perbaikan.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection