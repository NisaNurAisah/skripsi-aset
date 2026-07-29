@extends('layouts.app')
@section('title', 'Pembelian Inventaris')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="fw-bold">Data Pembelian Inventaris</h3>
    <a href="/pembelian/create" class="btn btn-success"><i class="bi bi-plus-lg"></i> Tambah Pembelian</a>
</div>

<div class="card stat-card p-3">
    <table class="table table-striped align-middle">
        <thead>
            <tr>
                <th>No.</th>
                <th>Aset</th>
                <th>Tanggal</th>
                <th>Jumlah</th>
                <th>Total Harga</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pembelian as $p)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $p->aset->nama_aset ?? '-' }}</td>
                <td>{{ $p->tanggal_pembelian }}</td>
                <td>{{ $p->jumlah_pembelian }}</td>
                <td>Rp {{ number_format($p->total_harga, 0, ',', '.') }}</td>
                <td>
                    <form action="/pembelian/{{ $p->id_pembelian }}" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Yakin hapus?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" class="text-center text-muted">Belum ada data pembelian.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection