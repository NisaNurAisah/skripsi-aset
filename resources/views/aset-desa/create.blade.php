@extends('layouts.app')
@section('title', 'Tambah Aset Desa')

@section('content')
<h3 class="fw-bold mb-4 text-center">Tambah Data Aset</h3>

<div class="card stat-card p-4 mx-auto" style="max-width:600px;">
    <form action="/data-aset-desa" method="POST" class="row g-3" enctype="multipart/form-data">
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
            <label class="form-label">Jenis Aset</label>
            <select name="jenis_aset" class="form-select" required>
                <option value="Tanah">Tanah</option>
                <option value="Jalan dan Irigasi">Jalan dan Irigasi</option>
                <option value="Bangunan">Bangunan</option>
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
            <label class="form-label">Nilai Perolehan (Rp)</label>
            <input type="number" name="nilai_perolehan" step="0.01" class="form-control" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">Jumlah Aset</label>
            <input type="number" name="jumlah_aset" value="1" class="form-control" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">Kondisi Aset</label>
            <select name="kondisi_aset" class="form-select">
                <option value="">Belum diketahui</option>
                <option value="Baik">Baik</option>
                <option value="Rusak Ringan">Rusak Ringan</option>
                <option value="Rusak Berat">Rusak Berat</option>
            </select>
        </div>
        <div class="col-md-12">
            <label class="form-label">Foto Aset</label>
            <input type="file" name="gambar_aset" class="form-control" accept="image/*">
        </div>
        <div class="col-md-12">
            <button type="submit" class="btn btn-success">Simpan</button>
            <a href="/data-aset-desa" class="btn btn-outline-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection