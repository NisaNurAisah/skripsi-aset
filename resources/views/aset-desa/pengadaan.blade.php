@extends('layouts.app')
@section('title', 'Pengadaan Aset')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="fw-bold">Pengadaan Aset</h3>
    <a href="/pengadaan-aset/download-pdf?{{ http_build_query(request()->only('search','cara_perolehan')) }}" class="btn btn-outline-success"><i class="bi bi-file-earmark-pdf"></i> Cetak PDF</a>
</div>

<div class="card stat-card p-3 mb-3">
    <form action="/pengadaan-aset" method="GET" class="row g-2 align-items-end">
        <div class="col-md-6">
            <label class="form-label mb-1">Cari</label>
            <input type="text" name="search" class="form-control" placeholder="Cari nama atau kode aset..." value="{{ request('search') }}">
        </div>
        <div class="col-md-4">
            <label class="form-label mb-1">Cara Perolehan</label>
            <select name="cara_perolehan" class="form-select">
                <option value="">Semua</option>
                @foreach($caraPerolehanList as $c)
                    <option value="{{ $c }}" {{ request('cara_perolehan') == $c ? 'selected' : '' }}>{{ $c }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-success w-100">Filter</button>
        </div>
    </form>
    @if(request('search') || request('cara_perolehan'))
        <a href="/pengadaan-aset" class="btn btn-sm btn-outline-secondary mt-2">Reset Filter</a>
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
                <th>Tahun Perolehan</th>
                <th>Nilai Perolehan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($asetDesa as $aset)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $aset->kode_aset }}</td>
                <td>{{ $aset->nama_aset }}</td>
                <td>{{ $aset->jenis_aset }}</td>
                <td>
                    @if($aset->cara_perolehan)
                        <span class="badge bg-success">{{ $aset->cara_perolehan }}</span>
                    @else
                        <span class="badge bg-secondary">Belum diisi</span>
                    @endif
                </td>
                <td>{{ $aset->lokasi->nama_lokasi ?? '-' }}</td>
                <td>{{ \Carbon\Carbon::parse($aset->tahun_perolehan)->format('d/m/Y') }}</td>
                <td>Rp {{ number_format($aset->nilai_perolehan, 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr><td colspan="8" class="text-center text-muted">Belum ada data pengadaan aset.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection