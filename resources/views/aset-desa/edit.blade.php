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
            <select name="jenis_aset" id="jenis_aset" class="form-select" required>
               @foreach(['Tanah','Jalan dan Irigasi','Bangunan','Sawah','Kendaraan'] as $j)
                    <option value="{{ $j }}" {{ $aset->jenis_aset == $j ? 'selected' : '' }}>{{ $j }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-6">
            <label class="form-label">Cara Perolehan</label>
            <select name="cara_perolehan" class="form-select">
                <option value="">- Pilih -</option>
                @foreach(['Pembelian','Hibah','Bantuan Pemerintah','Swadaya Masyarakat','Dana Desa','DBH','Banprov','Pemekaran','Lainnya'] as $c)
                    <option value="{{ $c }}" {{ $aset->cara_perolehan == $c ? 'selected' : '' }}>{{ $c }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-6">
            <label class="form-label">Tahun Perolehan</label>
            <input type="number" name="tahun_perolehan" value="{{ \Carbon\Carbon::parse($aset->tahun_perolehan)->format('Y') }}" class="form-control" min="1900" max="{{ date('Y') }}" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">Nilai Perolehan (Rp)</label>
            <input type="number" name="nilai_perolehan" value="{{ $aset->nilai_perolehan }}" step="0.01" class="form-control" required>
        </div>

        <div class="col-md-12"><hr class="my-1"><small class="text-muted">Detail Tambahan (sesuai jenis aset)</small></div>

        <div class="col-md-6 field-group" data-show="Tanah,Sawah,Jalan dan Irigasi,Bangunan,Kendaraan">
            <label class="form-label">NUP</label>
            <input type="text" name="nup" value="{{ $aset->nup }}" class="form-control" placeholder="Nomor Urut Pendaftaran">
        </div>
        <div class="col-md-6 field-group" data-show="Tanah,Sawah,Jalan dan Irigasi,Bangunan">
            <label class="form-label" id="label-ukuran">Luas / Ukuran</label>
            <input type="text" name="ukuran_luas" value="{{ $aset->ukuran_luas }}" class="form-control" placeholder="cth: 4,5 Ha / 10 m x 8 m">
        </div>
        <div class="col-md-6 field-group" data-show="Jalan dan Irigasi,Bangunan">
            <label class="form-label" id="label-tipe">Type / Tipe</label>
            <input type="text" name="tipe" value="{{ $aset->tipe }}" class="form-control" placeholder="cth: Rabat Beton / Permanen">
        </div>
        <div class="col-md-6 field-group" data-show="Tanah,Sawah">
            <label class="form-label">Atas Hak / Bukti Kepemilikan</label>
            <input type="text" name="atas_hak" value="{{ $aset->atas_hak }}" class="form-control" placeholder="cth: SPPT">
        </div>
        <div class="col-md-6 field-group" data-show="Kendaraan">
            <label class="form-label">Merk/Type Kendaraan</label>
            <input type="text" name="merk_type" value="{{ $aset->merk_type }}" class="form-control" placeholder="cth: Honda Win">
        </div>
        <div class="col-md-6 field-group" data-show="Kendaraan">
            <label class="form-label">Nomor Identitas (Plat)</label>
            <input type="text" name="nomor_identitas" value="{{ $aset->nomor_identitas }}" class="form-control" placeholder="cth: F 9943 WD">
        </div>
        <div class="col-md-6 field-group" data-show="Kendaraan">
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

<script>
    function toggleFieldGroups() {
        var jenis = document.getElementById('jenis_aset').value;
        document.querySelectorAll('.field-group').forEach(function(group) {
            var allowed = group.getAttribute('data-show').split(',');
            group.style.display = allowed.includes(jenis) ? '' : 'none';
        });
        var labelUkuran = document.getElementById('label-ukuran');
        if (labelUkuran) {
            labelUkuran.innerText = (jenis === 'Jalan dan Irigasi') ? 'Ukuran' : 'Luas (M2/Ha)';
        }
        var labelTipe = document.getElementById('label-tipe');
        if (labelTipe) {
            labelTipe.innerText = (jenis === 'Bangunan') ? 'Tipe Bangunan' : 'Type';
        }
    }
    document.getElementById('jenis_aset').addEventListener('change', toggleFieldGroups);
    document.addEventListener('DOMContentLoaded', toggleFieldGroups);
</script>
@endsection