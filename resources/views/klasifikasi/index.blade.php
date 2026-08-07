@extends('layouts.app')
@section('title', 'Klasifikasi Kondisi Aset')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold mb-0">Klasifikasi Kondisi Inventaris</h3>
    <a href="/klasifikasi/riwayat-lengkap" class="btn btn-outline-success"><i class="bi bi-clock-history"></i> Riwayat Lengkap</a>
</div>

@if (session('error'))
    <div class="alert alert-warning">
        <i class="bi bi-exclamation-triangle-fill"></i> {{ session('error') }}
    </div>
@endif

<div class="card stat-card p-4 mb-4">
    <h6 class="fw-bold mb-3">Input Data Inventaris</h6>
    <form action="/klasifikasi" method="POST" class="row g-3">
        @csrf
        <div class="col-md-4">
            <label class="form-label">Nama Inventaris</label>
            <input type="text" name="nama_aset_uji" class="form-control" placeholder="" value="{{ old('nama_aset_uji') }}" required>
        </div>
        <div class="col-md-4">
            <label class="form-label">Jenis Inventaris</label>
            <select name="jenis_aset_uji" class="form-select" required>
                <option value="Elektronik">Elektronik</option>
                <option value="Furnitur">Furnitur</option>
                <option value="Peralatan Kantor">Peralatan Kantor</option>
                <option value="Perlengkapan Kantor">Perlengkapan Kantor</option>
            </select>
        </div>
        <div class="col-md-4">
            <label class="form-label">Tahun Perolehan</label>
            <input type="number" name="tahun_perolehan_uji" class="form-control" placeholder="" min="2000" max="{{ date('Y') }}" required>
        </div>
        <div class="col-md-4">
            <label class="form-label">Intensitas Penggunaan</label>
            <select name="intensitas_penggunaan_uji" class="form-select" required>
                <option value="Rendah">Rendah</option>
                <option value="Sedang">Sedang</option>
                <option value="Tinggi">Tinggi</option>
            </select>
        </div>
        <div class="col-md-12">
            <button type="submit" class="btn btn-success">Klasifikasikan</button>
        </div>
    </form>
</div>

<div class="card stat-card p-3">
    <h6 class="fw-bold mb-3">Riwayat Klasifikasi (30 Hari Terakhir)</h6>
    <table class="table table-striped align-middle">
        <thead>
            <tr>
                <th>No.</th>
                <th>Tanggal</th>
                <th>Nama Inventaris</th>
                <th>Jenis Inventaris</th>
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
            <tr><td colspan="8" class="text-center text-muted">Belum ada riwayat klasifikasi.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection