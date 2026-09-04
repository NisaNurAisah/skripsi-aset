@extends('layouts.app')
@section('title', 'Data Inventaris')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="fw-bold">Data Inventaris</h3>
    <div>
        <a href="/data-inventaris/download-pdf?{{ http_build_query(request()->all()) }}" class="btn btn-outline-success"><i class="bi bi-file-earmark-pdf"></i> Unduh PDF</a>
        <a href="/data-inventaris/create" class="btn btn-success"><i class="bi bi-plus-lg"></i> Tambah Inventaris</a>
    </div>
</div>

<div class="card stat-card p-3 mb-3">
    <form action="/data-inventaris" method="GET" class="row g-2 align-items-end">
        <div class="col-md-6">
            <label class="form-label mb-1">Cari</label>
            <input type="text" name="search" class="form-control" placeholder="Cari nama atau kode inventaris..." value="{{ request('search') }}">
        </div>
        <div class="col-md-4">
            <label class="form-label mb-1">Kondisi</label>
            <select name="kondisi_inventaris" class="form-select">
                <option value="">Semua Kondisi</option>
                <option value="Baik" {{ request('kondisi_inventaris') == 'Baik' ? 'selected' : '' }}>Baik</option>
                <option value="Rusak Ringan" {{ request('kondisi_inventaris') == 'Rusak Ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                <option value="Rusak Berat" {{ request('kondisi_inventaris') == 'Rusak Berat' ? 'selected' : '' }}>Rusak Berat</option>
            </select>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-success w-100">Filter</button>
        </div>
    </form>
    @if(request('search') || request('kondisi_inventaris'))
        <a href="/data-inventaris" class="btn btn-sm btn-outline-secondary mt-2">Reset Filter</a>
    @endif
</div>

<div class="card stat-card p-3">
    <div class="table-responsive">
        <table class="table table-striped align-middle">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Nama Inventaris</th>
                    <th>Jenis Inventaris</th>
                    <th>Merk</th>
                    <th>Lokasi</th>
                    <th>Jumlah</th>
                    <th>Tahun Perolehan</th>
                    <th>Nilai Perolehan</th>
                    <th>Intensitas</th>
                    <th>Kondisi</th>
                    <th>Foto</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($dataInventaris as $inventaris)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $inventaris->nama_inventaris }}</td>
                    <td>{{ $inventaris->jenis_inventaris }}</td>
                    <td>{{ $inventaris->merk ?? '-' }}</td>
                    <td>{{ $inventaris->lokasi->nama_lokasi ?? '-' }}</td>
                    <td>{{ $inventaris->jumlah_inventaris }}</td>
                    <td>{{ \Carbon\Carbon::parse($inventaris->tahun_perolehan)->format('Y') }}</td>
                    <td>Rp {{ number_format($inventaris->nilai_perolehan, 0, ',', '.') }}</td>
                    <td>{{ $inventaris->intensitas_penggunaan ?? '-' }}</td>
                    <td>
                        @if($inventaris->kondisi_inventaris)
                            <span class="badge bg-{{ $inventaris->kondisi_inventaris == 'Baik' ? 'success' : ($inventaris->kondisi_inventaris == 'Rusak Ringan' ? 'warning' : 'danger') }}">
                                {{ $inventaris->kondisi_inventaris }}
                            </span>
                        @else
                            <span class="badge bg-secondary">Belum diketahui</span>
                        @endif
                    </td>
                    <td>
                        @if($inventaris->gambar_inventaris)
                            <img src="/storage/{{ $inventaris->gambar_inventaris }}" style="height:50px; width:50px; object-fit:cover; border-radius:6px;">
                        @else
                            <span class="text-muted small">-</span>
                        @endif
                    </td>
                    <td>
                        <a href="/data-inventaris/{{ $inventaris->id_inventaris }}/edit" class="btn btn-sm btn-outline-primary">Edit</a>
                        <form action="/data-inventaris/{{ $inventaris->id_inventaris }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Yakin hapus?')">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="13" class="text-center text-muted">Belum ada data inventaris.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection