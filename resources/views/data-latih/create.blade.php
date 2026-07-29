@extends('layouts.app')
@section('title', 'Tambah Data Latih')

@section('content')
<h3 class="fw-bold mb-4 text-center">Tambah Data Latih KNN</h3>

@if($errors->any())
    <div class="alert alert-danger mx-auto" style="max-width:600px;">{{ $errors->first() }}</div>
@endif

<div class="card stat-card p-4 mx-auto" style="max-width:600px;">
    <div class="mb-3">
        <div class="btn-group w-100" role="group">
            <input type="radio" class="btn-check" name="modeToggle" id="modeAset" checked onclick="toggleMode('aset')">
            <label class="btn btn-outline-success" for="modeAset">Ambil dari Data Aset</label>

            <input type="radio" class="btn-check" name="modeToggle" id="modeManual" onclick="toggleMode('manual')">
            <label class="btn btn-outline-success" for="modeManual">Input Manual</label>
        </div>
    </div>

    <form action="/data-latih" method="POST" class="row g-3">
        @csrf
        <input type="hidden" name="mode" id="modeInput" value="aset">

        <div id="fieldAset" class="col-md-12">
            <label class="form-label">Pilih Aset</label>
            <select name="id_aset" class="form-select">
                @forelse($dataAset as $a)
                    <option value="{{ $a->id_aset }}">{{ $a->nama_aset }} ({{ $a->jenis_aset }}) — {{ $a->kondisi_aset ?? 'Belum diklasifikasi' }}</option>
                @empty
                    <option value="">Belum ada data aset bergerak</option>
                @endforelse
            </select>
            <small class="text-muted">Jenis Aset, Intensitas Penggunaan, Usia Aset, dan Label Kondisi akan otomatis diambil dari data aset ini.</small>
        </div>

        <div id="fieldManual" class="col-md-12 row g-3" style="display:none;">
            <div class="col-md-6">
                <label class="form-label">Jenis Aset</label>
                <select name="jenis_aset" class="form-select">
                    <option value="Elektronik">Elektronik</option>
                    <option value="Furnitur">Furnitur</option>
                    <option value="Peralatan Kantor">Peralatan Kantor</option>
                    <option value="Perlengkapan Kantor">Perlengkapan Kantor</option>
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label">Intensitas Penggunaan</label>
                <select name="intensitas_penggunaan" class="form-select">
                    <option value="Rendah">Rendah</option>
                    <option value="Sedang">Sedang</option>
                    <option value="Tinggi">Tinggi</option>
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label">Usia Aset (tahun)</label>
                <input type="number" name="usia_aset" class="form-control">
            </div>
            <div class="col-md-6">
                <label class="form-label">Label Kondisi</label>
                <select name="label_kondisi" class="form-select">
                    <option value="Baik">Baik</option>
                    <option value="Rusak Ringan">Rusak Ringan</option>
                    <option value="Rusak Berat">Rusak Berat</option>
                </select>
            </div>
        </div>

        <div class="col-md-12">
            <button type="submit" class="btn btn-success">Simpan</button>
            <a href="/data-latih" class="btn btn-outline-secondary">Batal</a>
        </div>
    </form>
</div>

<script>
function toggleMode(mode) {
    document.getElementById('modeInput').value = mode;
    document.getElementById('fieldAset').style.display = mode === 'aset' ? 'block' : 'none';
    document.getElementById('fieldManual').style.display = mode === 'manual' ? 'flex' : 'none';
}
</script>
@endsection