@extends('layouts.app')
@section('title', 'Laporan Inventaris')

@section('content')
<h3 class="fw-bold mb-4">Lihat Laporan Inventaris</h3>

<div class="card stat-card p-3 mb-4">
    <form action="/laporan" method="GET" class="row g-3 align-items-end">
        <div class="col-md-3">
            <label class="form-label">Periode (Tahun)</label>
            <select name="periode" class="form-select">
                <option value="">Semua Periode</option>
                @foreach($tahunTersedia as $tahun)
                    <option value="{{ $tahun }}" {{ request('periode') == $tahun ? 'selected' : '' }}>{{ $tahun }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label">Jenis Aset</label>
            <select name="jenis_aset" class="form-select">
                <option value="">Semua Jenis</option>
                <option value="Elektronik" {{ request('jenis_aset') == 'Elektronik' ? 'selected' : '' }}>Elektronik</option>
                <option value="Furnitur" {{ request('jenis_aset') == 'Furnitur' ? 'selected' : '' }}>Furnitur</option>
                <option value="Peralatan Kantor" {{ request('jenis_aset') == 'Peralatan Kantor' ? 'selected' : '' }}>Peralatan Kantor</option>
                <option value="Perlengkapan Kantor" {{ request('jenis_aset') == 'Perlengkapan Kantor' ? 'selected' : '' }}>Perlengkapan Kantor</option>
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label">Kategori</label>
            <select name="id_kategori" class="form-select">
                <option value="">Semua Kategori</option>
                @foreach($kategori as $k)
                    <option value="{{ $k->id_kategori }}" {{ request('id_kategori') == $k->id_kategori ? 'selected' : '' }}>{{ $k->jenis_kategori }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
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
            <a href="/laporan" class="btn btn-outline-secondary">Reset</a>
        </div>
    </form>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card stat-card p-3 text-center">
            <div class="text-muted">Total Aset</div>
            <div class="fs-2 fw-bold">{{ $summary['total'] }}</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card p-3 text-center">
            <div class="text-muted">Kondisi Baik</div>
            <div class="fs-2 fw-bold text-success">{{ $summary['baik'] }}</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card p-3 text-center">
            <div class="text-muted">Rusak Ringan</div>
            <div class="fs-2 fw-bold text-warning">{{ $summary['rusak_ringan'] }}</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card p-3 text-center">
            <div class="text-muted">Rusak Berat</div>
            <div class="fs-2 fw-bold text-danger">{{ $summary['rusak_berat'] }}</div>
        </div>
    </div>
</div>

<div class="card stat-card p-3">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="fw-bold mb-0">Detail Laporan Inventaris Aset Desa Hegarmanah</h5>
        <span class="text-muted">Periode: {{ request('periode') ?? 'Semua Periode' }}</span>
    </div>
    <table class="table table-bordered">
        <thead class="table-light">
            <tr>
                <th>No.</th>
                <th>Kode</th>
                <th>Nama Aset</th>
                <th>Kategori</th>
                <th>Lokasi</th>
                <th>Jumlah</th>
                <th>Tahun Perolehan</th>
                <th>Kondisi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($dataAset as $aset)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $aset->kode_aset }}</td>
                <td>{{ $aset->nama_aset }}</td>
                <td>{{ $aset->kategori->jenis_kategori ?? '-' }}</td>
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

<div class="mt-3">
    <form action="/laporan/cetak" method="POST" class="d-inline">
        @csrf
        <input type="hidden" name="periode" value="{{ request('periode') }}">
        <input type="hidden" name="jenis_aset" value="{{ request('jenis_aset') }}">
        <button type="submit" class="btn btn-outline-success"><i class="bi bi-clock-history"></i> Catat Riwayat Cetak</button>
    </form>
    <a href="/laporan/download-pdf?{{ http_build_query(request()->all()) }}" class="btn btn-success">
        <i class="bi bi-file-earmark-pdf"></i> Unduh PDF
    </a>
</div>
@endsection