@extends('layouts.app')
@section('title', 'Tambah Pembelian')

@section('content')
<h3 class="fw-bold mb-4 text-center">Tambah Pengadaan Inventaris Baru</h3>

<div class="card stat-card p-4 mx-auto" style="max-width:650px;">
    <form action="/pembelian" method="POST" class="row g-3" enctype="multipart/form-data">
        @csrf
        <div class="col-md-6">
            <label class="form-label">Nama Inventaris</label>
            <input type="text" name="nama_aset" class="form-control" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">Jenis Inventaris</label>
            <select name="jenis_aset" class="form-select" required>
                <option value="Elektronik">Elektronik</option>
                <option value="Furnitur">Furnitur</option>
                <option value="Peralatan Kantor">Peralatan Kantor</option>
                <option value="Perlengkapan Kantor">Perlengkapan Kantor</option>
            </select>
        </div>

        <div class="col-md-6">
            <label class="form-label">Intensitas Penggunaan</label>
            <select name="intensitas_penggunaan" class="form-select" required>
                <option value="Rendah">Rendah</option>
                <option value="Sedang">Sedang</option>
                <option value="Tinggi">Tinggi</option>
            </select>
        </div>
        <div class="col-md-6">
            <label class="form-label">Lokasi</label>
            <select name="id_lokasi" class="form-select" required>
                @foreach($lokasi as $l)
                    <option value="{{ $l->id_lokasi }}">{{ $l->nama_lokasi }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-6">
            <label class="form-label">Tanggal Pembelian</label>
            <input type="date" name="tanggal_pembelian" class="form-control" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">Jumlah Dibeli</label>
            <input type="number" name="jumlah_pembelian" min="1" class="form-control" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">Total Harga (Rp)</label>
            <input type="number" name="total_harga" step="0.01" class="form-control" required>
            <small class="text-muted">Nilai perolehan per unit akan dihitung otomatis (Total Harga ÷ Jumlah)</small>
        </div>

        <div class="col-md-12">
            <label class="form-label">Foto Inventaris</label>
            <input type="file" name="gambar_aset" class="form-control" accept="image/*">
        </div>

        <div class="col-md-12">
            <button type="submit" class="btn btn-success">Simpan Pengadaan</button>
            <a href="/pembelian" class="btn btn-outline-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection