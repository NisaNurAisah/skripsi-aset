@extends('layouts.app')
@section('title', 'Tambah Pembelian')

@section('content')
<h3 class="fw-bold mb-4 text-center">Tambah Pengadaan Aset Baru</h3>

<div class="card stat-card p-4 mx-auto" style="max-width:650px;">
    <form action="/pembelian" method="POST" class="row g-3" enctype="multipart/form-data">
        @csrf
        <div class="col-md-6">
            <label class="form-label">Kode Aset</label>
            <input type="text" name="kode_aset" class="form-control" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">Nama Aset</label>
            <input type="text" name="nama_aset" class="form-control" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">Kategori</label>
            <select name="id_kategori" id="kategoriSelect" class="form-select" onchange="toggleFields()" required>
                @foreach($kategori as $k)
                    <option value="{{ $k->id_kategori }}" data-nama="{{ $k->jenis_kategori }}">{{ $k->jenis_kategori }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-6">
            <label class="form-label">Jenis Aset</label>
            <select name="jenis_aset" id="jenisAsetSelect" class="form-select" required>
                <option value="Elektronik" class="opt-bergerak">Elektronik</option>
                <option value="Furnitur" class="opt-bergerak">Furnitur</option>
                <option value="Peralatan Kantor" class="opt-bergerak">Peralatan Kantor</option>
                <option value="Perlengkapan Kantor" class="opt-bergerak">Perlengkapan Kantor</option>
                <option value="Tanah" class="opt-tidak-bergerak">Tanah</option>
                <option value="Gedung dan Bangunan" class="opt-tidak-bergerak">Gedung dan Bangunan</option>
            </select>
        </div>

        <div id="fieldIntensitas" class="col-md-6">
            <label class="form-label">Intensitas Penggunaan</label>
            <select name="intensitas_penggunaan" class="form-select">
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
            <label class="form-label">Tahun Perolehan</label>
            <input type="date" name="tahun_perolehan" class="form-control" required>
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
            <label class="form-label">Foto Aset</label>
            <input type="file" name="gambar_aset" class="form-control" accept="image/*">
        </div>

        <div class="col-md-12">
            <button type="submit" class="btn btn-success">Simpan Pengadaan</button>
            <a href="/pembelian" class="btn btn-outline-secondary">Batal</a>
        </div>
    </form>
</div>

<script>
function toggleFields() {
    const kategoriSelect = document.getElementById('kategoriSelect');
    const selectedNama = kategoriSelect.options[kategoriSelect.selectedIndex].getAttribute('data-nama');
    const jenisAsetSelect = document.getElementById('jenisAsetSelect');
    const fieldIntensitas = document.getElementById('fieldIntensitas');
    const isBergerak = selectedNama === 'Bergerak';

    fieldIntensitas.style.display = isBergerak ? 'block' : 'none';

    document.querySelectorAll('.opt-bergerak').forEach(o => o.style.display = isBergerak ? 'block' : 'none');
    document.querySelectorAll('.opt-tidak-bergerak').forEach(o => o.style.display = isBergerak ? 'none' : 'block');

    const firstVisible = jenisAsetSelect.querySelector(isBergerak ? '.opt-bergerak' : '.opt-tidak-bergerak');
    if (firstVisible) jenisAsetSelect.value = firstVisible.value;
}
document.addEventListener('DOMContentLoaded', toggleFields);
</script>
@endsection