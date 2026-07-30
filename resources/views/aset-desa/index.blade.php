@extends('layouts.app')
@section('title', 'Data Aset Desa')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="fw-bold">{{ request('jenis_aset') ? 'Data Aset ' . request('jenis_aset') : 'Data Aset' }}</h3>
    <div>
        <a href="/data-aset-desa/download-pdf?{{ http_build_query(request()->only('search','jenis_aset')) }}" class="btn btn-outline-success"><i class="bi bi-file-earmark-pdf"></i> Cetak PDF</a>
        <a href="/data-aset-desa/create" class="btn btn-success"><i class="bi bi-plus-lg"></i> Tambah Aset</a>
    </div>
</div>

<div class="card stat-card p-3 mb-3">
    <form action="/data-aset-desa" method="GET" class="row g-2 align-items-end">
        <div class="col-md-10">
            <label class="form-label mb-1">Cari</label>
            <input type="text" name="search" class="form-control" placeholder="Cari nama atau kode aset..." value="{{ request('search') }}">
        </div>
        @if(request('jenis_aset'))
            <input type="hidden" name="jenis_aset" value="{{ request('jenis_aset') }}">
        @endif
        <div class="col-md-2">
            <button type="submit" class="btn btn-success w-100">Filter</button>
        </div>
    </form>
    @if(request('search') || request('jenis_aset'))
        <a href="/data-aset-desa" class="btn btn-sm btn-outline-secondary mt-2">Reset Filter</a>
    @endif
</div>

<div class="card stat-card p-3">
    <table class="table table-striped align-middle">
        <thead>
            <tr>
                <th>No.</th>
                <th>Kode</th>
                <th>Nama Aset</th>
                <th>Jenis Aset</th>
                <th>Cara Perolehan</th>
                <th>Lokasi</th>
                <th>Jumlah</th>
                <th>Tahun Perolehan</th>
                <th>Kondisi</th>
                <th>Foto</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($asetDesa as $aset)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $aset->kode_aset }}</td>
                <td>{{ $aset->nama_aset }}</td>
                <td>{{ $aset->jenis_aset }}</td>
                <td>{{ $aset->cara_perolehan ?? '-' }}</td>
                <td>{{ $aset->lokasi->nama_lokasi ?? '-' }}</td>
                <td>{{ $aset->jumlah_aset }}</td>
                <td>{{ \Carbon\Carbon::parse($aset->tahun_perolehan)->format('Y') }}</td>
                <td>
                    @if($aset->kondisi_aset)
                        <span class="badge bg-{{ $aset->kondisi_aset == 'Baik' ? 'success' : ($aset->kondisi_aset == 'Rusak Ringan' ? 'warning' : 'danger') }}">
                            {{ $aset->kondisi_aset }}
                        </span>
                    @else
                        <span class="badge bg-secondary">Belum diketahui</span>
                    @endif
                </td>
                <td>
                    @if($aset->gambar_aset)
                        <img src="/storage/{{ $aset->gambar_aset }}" style="height:50px; width:50px; object-fit:cover; border-radius:6px;">
                    @else
                        <span class="text-muted small">-</span>
                    @endif
                </td>
                <td>
                    <a href="/data-aset-desa/{{ $aset->id_aset_desa }}/edit" class="btn btn-sm btn-outline-primary">Edit</a>
                    <form action="/data-aset-desa/{{ $aset->id_aset_desa }}" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Yakin hapus?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="11" class="text-center text-muted">Belum ada data aset desa.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection