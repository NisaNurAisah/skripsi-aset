@extends('layouts.app')
@section('title', 'Data Latih KNN')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="fw-bold">Data Latih KNN</h3>
    <div>
        <form action="/data-latih/reset-generate" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-outline-danger" onclick="return confirm('PERHATIAN: Ini akan MENGHAPUS SEMUA data latih yang ada saat ini (termasuk yang diinput manual), lalu generate ulang dari awal berdasarkan Data Aset yang sudah punya kondisi. Yakin lanjut?')">
                <i class="bi bi-arrow-repeat"></i> Reset &amp; Generate Ulang
            </button>
        </form>
        <form action="/data-latih/generate-otomatis" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-outline-success" onclick="return confirm('Generate data latih otomatis dari semua Data Aset yang sudah punya kondisi? Aset yang sudah ada di Data Latih tidak akan diduplikasi.')">
                <i class="bi bi-magic"></i> Generate Otomatis
            </button>
        </form>
        <a href="/data-latih/create" class="btn btn-success"><i class="bi bi-plus-lg"></i> Tambah Data Latih</a>
    </div>

    <a href="/data-latih/download-pdf{{ request('search') ? '?search=' . request('search') : '' }}" class="btn btn-outline-secondary">
    <i class="bi bi-file-earmark-pdf"></i> Download PDF
</a>
</div>

<div class="card stat-card p-3 mb-3">
    <form action="/data-latih" method="GET">
        <input type="text" name="search" class="form-control" placeholder="Cari jenis inventaris... " value="{{ request('search') }}">
    </form>
</div>

<div class="card stat-card p-3">
    <table class="table table-striped align-middle">
        <thead>
            <tr>
                <th>No.</th>
                <th>Jenis Inventaris</th>
                <th>Intensitas Penggunaan</th>
                <th>Usia Inventaris (tahun)</th>
                <th>Label Kondisi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($dataLatih as $d)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $d->jenis_aset }}</td>
                <td>{{ $d->intensitas_penggunaan }}</td>
                <td>{{ $d->usia_aset }}</td>
                <td>
                    <span class="badge bg-{{ $d->label_kondisi == 'Baik' ? 'success' : ($d->label_kondisi == 'Rusak Ringan' ? 'warning' : 'danger') }}">
                        {{ $d->label_kondisi }}
                    </span>
                </td>
                <td>
                    <a href="/data-latih/{{ $d->id_data_latih }}/edit" class="btn btn-sm btn-outline-primary">Edit</a>
                    <form action="/data-latih/{{ $d->id_data_latih }}" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Yakin hapus?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" class="text-center text-muted">Belum ada data latih.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection