@extends('layouts.app')
@section('title', 'Edit Aset Desa')

@section('content')
<h3 class="fw-bold mb-4 text-center">Edit Data Aset</h3>

<div class="card stat-card p-4 mx-auto" style="max-width:600px;">
    <form action="/data-aset-desa/{{ $aset->id_aset_desa }}" method="POST" class="row g-3" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="col-md-6">
            <label class="form-label">Kode Aset</label>
            <input type="text" name="kode_aset" value="{{ $aset->kode_aset }}" class="form-control" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">Nama Aset</label>
            <input type="text" name="nama_aset" value="{{ $aset->nama_aset }}" class="form-control" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">Jenis Aset</label>
            <select name="jenis_aset" class="form-select" required>
               @foreach(['Tanah','Jalan dan Irigasi','Bangunan','Sawah'] as $j)
                    <option value="{{ $j }}" {{ $aset->jenis_aset == $j ? 'selected' : '' }}>{{ $j }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-6">
            <label class="form-label">Cara Perolehan</label>
            <select name="cara_perolehan" class="form-select">
                <option value="">- Pilih -</option>
                @foreach(['Pembelian','Hibah','Bantuan Pemerintah','Swadaya Masyarakat','Lainnya'] as $c)
                    <option value="{{ $c }}" {{ $aset->cara_perolehan == $c ? 'selected' : '' }}>{{ $c }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-6">
            <label class="form-label">Lokasi</label>
            <select name="id_lokasi" class="form-select" required>
                @foreach($lokasi as $l)
                    <option value="{{ $l->id_lokasi }}" {{ $aset->id_lokasi == $l->id_lokasi ? 'selected' : '' }}>{{ $l->nama_lokasi }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-6">
            <label class="form-label">Tahun Perolehan</label>
            <input type="date" name="tahun_perolehan" value="{{ $aset->tahun_perolehan }}" class="form-control" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">Nilai Perolehan (Rp)</label>
            <input type="number" name="nilai_perolehan" value="{{ $aset->nilai_perolehan }}" step="0.01" class="form-control" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">Jumlah Aset</label>
            <input type="number" name="jumlah_aset" value="{{ $aset->jumlah_aset }}" class="form-control" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">Kondisi Aset</label>
            <select name="kondisi_aset" class="form-select">
                <option value="">Belum diketahui</option>
                @foreach(['Baik','Rusak Ringan','Rusak Berat'] as $k)
                    <option value="{{ $k }}" {{ $aset->kondisi_aset == $k ? 'selected' : '' }}>{{ $k }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-12">
            <label class="form-label">Foto Aset</label>
            @if($aset->gambar_aset)
                <div class="mb-2"><img src="/storage/{{ $aset->gambar_aset }}" style="height:80px; border-radius:6px;"></div>
            @endif
            <input type="file" name="gambar_aset" class="form-control" accept="image/*">
        </div>
        <div class="col-md-12">
            <button type="submit" class="btn btn-success">Update</button>
            <a href="/data-aset-desa" class="btn btn-outline-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection