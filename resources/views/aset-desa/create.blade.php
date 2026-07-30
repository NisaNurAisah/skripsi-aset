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
            <select name="jenis_aset" id="jenis_aset" class="form-select" required>
                <option value="Tanah" {{ request('jenis_aset') == 'Tanah' ? 'selected' : '' }}>Tanah</option>
                <option value="Jalan dan Irigasi" {{ request('jenis_aset') == 'Jalan dan Irigasi' ? 'selected' : '' }}>Jalan dan Irigasi</option>
                <option value="Bangunan" {{ request('jenis_aset') == 'Bangunan' ? 'selected' : '' }}>Bangunan</option>
                <option value="Sawah" {{ request('jenis_aset') == 'Sawah' ? 'selected' : '' }}>Sawah</option>
                <option value="Kendaraan" {{ request('jenis_aset') == 'Kendaraan' ? 'selected' : '' }}>Kendaraan</option>
            </select>
        </div>
        <div class="col-md-6">
            <label class="form-label">Cara Perolehan</label>
            <select name="cara_perolehan" class="form-select">
                <option value="">- Pilih -</option>
                <option value="Pembelian">Pembelian</option>
                <option value="Hibah">Hibah</option>
                <option value="Bantuan Pemerintah">Bantuan Pemerintah</option>
                <option value="Swadaya Masyarakat">Swadaya Masyarakat</option>
                <option value="Dana Desa">Dana Desa</option>
                <option value="DBH">DBH</option>
                <option value="Banprov">Banprov</option>
                <option value="Pemekaran">Pemekaran</option>
                <option value="Lainnya">Lainnya</option>
            </select>
        </div>
        <div class="col-md-6">
            <label class="form-label">Tahun Perolehan</label>
            <input type="number" name="tahun_perolehan" class="form-control" placeholder="Contoh: 2020" min="1900" max="{{ date('Y') }}" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">Nilai Perolehan (Rp)</label>
            <input type="number" name="nilai_perolehan" step="0.01" class="form-control" required>
        </div>

        <div class="col-md-12"><hr class="my-1"><small class="text-muted">Detail Tambahan (sesuai jenis aset)</small></div>

        <div class="col-md-6 field-group" data-show="Tanah,Sawah,Jalan dan Irigasi,Bangunan,Kendaraan">
            <label class="form-label">NUP</label>
            <input type="text" name="nup" class="form-control" placeholder="Nomor Urut Pendaftaran">
        </div>
        <div class="col-md-6 field-group" data-show="Tanah,Sawah,Jalan dan Irigasi,Bangunan">
            <label class="form-label" id="label-ukuran">Luas / Ukuran</label>
            <input type="text" name="ukuran_luas" class="form-control" placeholder="cth: 4,5 Ha / 10 m x 8 m">
        </div>
        <div class="col-md-6 field-group" data-show="Jalan dan Irigasi,Bangunan">
            <label class="form-label" id="label-tipe">Type / Tipe</label>
            <input type="text" name="tipe" class="form-control" placeholder="cth: Rabat Beton / Permanen">
        </div>
        <div class="col-md-6 field-group" data-show="Tanah,Sawah">
            <label class="form-label">Atas Hak / Bukti Kepemilikan</label>
            <input type="text" name="atas_hak" class="form-control" placeholder="cth: SPPT">
        </div>
        <div class="col-md-6 field-group" data-show="Kendaraan">
            <label class="form-label">Merk/Type Kendaraan</label>
            <input type="text" name="merk_type" class="form-control" placeholder="cth: Honda Win">
        </div>
        <div class="col-md-6 field-group" data-show="Kendaraan">
            <label class="form-label">Nomor Identitas (Plat)</label>
            <input type="text" name="nomor_identitas" class="form-control" placeholder="cth: F 9943 WD">
        </div>
        <div class="col-md-6 field-group" data-show="Kendaraan">
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