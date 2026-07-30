@extends('layouts.app')
@section('title', 'Laporan Aset Desa')

@section('content')
<h3 class="fw-bold mb-4">Laporan Aset Desa</h3>

<div class="card stat-card p-3 mb-4">
    <form action="/laporan-aset" method="GET" class="row g-3 align-items-end">
        <div class="col-md-4">
            <label class="form-label">Periode (Tahun)</label>
            <select name="periode" class="form-select">
                <option value="">Semua Periode</option>
                @foreach($tahunTersedia as $tahun)
                    <option value="{{ $tahun }}" {{ request('periode') == $tahun ? 'selected' : '' }}>{{ $tahun }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <label class="form-label">Jenis Aset</label>
            <select name="jenis_aset" class="form-select">
                <option value="">Semua Jenis</option>
                <option value="Tanah" {{ request('jenis_aset') == 'Tanah' ? 'selected' : '' }}>Tanah</option>
                <option value="Bangunan" {{ request('jenis_aset') == 'Bangunan' ? 'selected' : '' }}>Bangunan</option>
                <option value="Jalan dan Irigasi" {{ request('jenis_aset') == 'Jalan dan Irigasi' ? 'selected' : '' }}>Jalan dan Irigasi</option>
                <option value="Sawah" {{ request('jenis_aset') == 'Sawah' ? 'selected' : '' }}>Sawah</option>
            </select>
        </div>
        <div class="col-md-4">
            <label class="form-label">Kondisi</label>
            <select name="kondisi_aset" class="form-select">
                <option value="">Semua Kondisi</option>
                <option value="Baik" {{ request('kondisi_aset') == 'Baik' ? 'selected' : '' }}>Baik</option>
                <option value="Rusak Ringan" {{ request('kondisi_aset') == 'Rusak Ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                <option value="Rusak Berat" {{ request('kondisi_aset') == 'Rusak Berat' ? 'selected' : '' }}>Rusak Berat</option>
            </select>
        </div>
        <div class="col-md-12">
            <button type="submit" class="btn btn-success">Terapkan Filter</button>
            <a href="/laporan-aset" class="btn btn-outline-secondary">Reset</a>
        </div>
    </form>
</div>

<div class="card stat-card p-3">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="fw-bold mb-0">Detail Laporan Aset Desa Hegarmanah</h5>
        <span class="text-muted">Periode: {{ request('periode') ?? 'Semua Periode' }}</span>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th>No.</th>
                    <th>Kode</th>
                    <th>Nama Aset</th>
                    <th>Jenis Aset</th>
                    <th>Lokasi</th>
                    <th>Jumlah</th>
                    <th>Tahun Perolehan</th>
                    <th>Kondisi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($asetDesa as $aset)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $aset->kode_aset }}</td>
                    <td>{{ $aset->nama_aset }}</td>
                    <td>{{ $aset->jenis_aset }}</td>
                    <td>{{ $aset->lokasi->nama_lokasi ?? '-' }}</td>
                    <td>{{ $aset->jumlah_aset }}</td>
                    <td>{{ \Carbon\Carbon::parse($aset->tahun_perolehan)->format('Y') }}</td>
                    <td>{{ $aset->kondisi_aset ?? 'Belum diketahui' }}</td>
                </tr>
                @empty
                <tr><td colspan="8" class="text-center text-muted">Tidak ada data sesuai filter.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">
    <a href="/laporan-aset/download-pdf?{{ http_build_query(request()->all()) }}" class="btn btn-success">
        <i class="bi bi-file-earmark-pdf"></i> Unduh PDF
    </a>
</div>
@endsection