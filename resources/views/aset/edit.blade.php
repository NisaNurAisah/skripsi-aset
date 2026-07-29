@extends('layouts.app')
@section('title', 'Edit Inventaris')

@section('content')
<h3 class="fw-bold mb-4 text-center">Edit Data Inventaris</h3>

<div class="card stat-card p-4 mx-auto" style="max-width:600px;">
    <form action="/data-aset/{{ $aset->id_aset }}" method="POST" class="row g-3" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="col-md-6">
            <label class="form-label">Kode Inventaris</label>
            <input type="text" name="kode_aset" value="{{ $aset->kode_aset }}" class="form-control" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">Nama Inventaris</label>
            <input type="text" name="nama_aset" value="{{ $aset->nama_aset }}" class="form-control" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">Jenis Inventaris</label>
            <select name="jenis_aset" class="form-select" required>
                @foreach(['Elektronik','Furnitur','Peralatan Kantor','Perlengkapan Kantor'] as $j)
                    <option value="{{ $j }}" {{ $aset->jenis_aset == $j ? 'selected' : '' }}>{{ $j }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-6">
            <label class="form-label">Intensitas Penggunaan</label>
            <select name="intensitas_penggunaan" class="form-select">
                @foreach(['Rendah','Sedang','Tinggi'] as $i)
                    <option value="{{ $i }}" {{ $aset->intensitas_penggunaan == $i ? 'selected' : '' }}>{{ $i }}</option>
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
    <label class="form-label">Tahun Perolehan</label>
    <input type="number" name="tahun_perolehan" value="{{ \Carbon\Carbon::parse($aset->tahun_perolehan)->format('Y') }}" class="form-control" min="2000" max="{{ date('Y') }}" required>
</div>
        <div class="col-md-6">
            <label class="form-label">Jumlah Inventaris</label>
            <input type="number" name="jumlah_aset" value="{{ $aset->jumlah_aset }}" class="form-control" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">Kondisi</label>
            <select name="kondisi_aset" class="form-select">
                <option value="">Belum diketahui</option>
                @foreach(['Baik','Rusak Ringan','Rusak Berat'] as $k)
                    <option value="{{ $k }}" {{ $aset->kondisi_aset == $k ? 'selected' : '' }}>{{ $k }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-12">
            <label class="form-label">Foto Inventaris</label>
            @if($aset->gambar_aset)
                <div class="mb-2"><img src="/storage/{{ $aset->gambar_aset }}" style="height:80px; border-radius:6px;"></div>
            @endif
            <input type="file" name="gambar_aset" class="form-control" accept="image/*">
        </div>
        <div class="col-md-12">
            <button type="submit" class="btn btn-success">Update</button>
            <a href="/data-aset" class="btn btn-outline-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection