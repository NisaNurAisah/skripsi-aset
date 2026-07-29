@extends('layouts.app')
@section('title', 'Riwayat Lengkap Klasifikasi')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold mb-0">Riwayat Lengkap Klasifikasi</h3>
    <a href="/klasifikasi" class="btn btn-outline-secondary">Kembali</a>
</div>

<div class="card stat-card p-3 mb-3">
    <form action="/klasifikasi/riwayat-lengkap" method="GET" class="row g-2 align-items-end">
        <div class="col-md-4">
            <label class="form-label mb-1">Periode</label>
            <select name="periode" class="form-select">
                <option value="">Semua Periode</option>
                @foreach($periodeTersedia as $p)
                    <option value="{{ $p }}" {{ request('periode') == $p ? 'selected' : '' }}>{{ \Carbon\Carbon::parse($p . '-01')->translatedFormat('F Y') }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <label class="form-label mb-1">Urutkan</label>
            <select name="sort" class="form-select">
                <option value="terbaru" {{ request('sort') == 'terbaru' ? 'selected' : '' }}>Terbaru ke Terlama</option>
                <option value="terlama" {{ request('sort') == 'terlama' ? 'selected' : '' }}>Terlama ke Terbaru</option>
            </select>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-success w-100">Terapkan</button>
        </div>
        <div class="col-md-2">
            <a href="/klasifikasi/riwayat-lengkap" class="btn btn-outline-secondary w-100">Reset</a>
        </div>
    </form>
</div>

<div class="card stat-card p-3">
    <table class="table table-striped align-middle">
        <thead>
            <tr>
                <th>No.</th>
                <th>Tanggal</th>
                <th>Nama Aset</th>
                <th>Jenis Aset</th>
                <th>Usia</th>
                <th>Intensitas</th>
                <th>Hasil</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($riwayat as $r)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $r->tanggal_klasifikasi }}</td>
                <td>{{ $r->nama_aset_uji }}</td>
                <td>{{ $r->jenis_aset_uji }}</td>
                <td>{{ $r->usia_aset_uji }} tahun</td>
                <td>{{ $r->intensitas_penggunaan_uji }}</td>
                <td>
                    <span class="badge bg-{{ $r->hasil_klasifikasi == 'Baik' ? 'success' : ($r->hasil_klasifikasi == 'Rusak Ringan' ? 'warning' : 'danger') }}">
                        {{ $r->hasil_klasifikasi }}
                    </span>
                </td>
                <td>
                    <a href="/klasifikasi/{{ $r->id_klasifikasi }}/pdf" class="btn btn-sm btn-outline-success">
                        <i class="bi bi-file-earmark-pdf"></i> PDF
                    </a>
                </td>
            </tr>
            @empty
            <tr><td colspan="8" class="text-center text-muted">Tidak ada data sesuai filter.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection