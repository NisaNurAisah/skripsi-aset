@extends('layouts.app')
@section('title', 'Tambah Perbaikan')

@section('content')
<h3 class="fw-bold mb-4 text-center">Tambah Data Perbaikan</h3>

<div class="card stat-card p-4 mx-auto" style="max-width:600px;">
    <form action="/perbaikan" method="POST" class="row g-3">
        @csrf
        <div class="col-md-12">
            <label class="form-label">Nama Inventaris</label>
            <select name="id_aset" class="form-select" required>
                @foreach($dataAset as $a)
                    <option value="{{ $a->id_aset }}">{{ $a->nama_aset }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-12">
            <label class="form-label">Deskripsi Kerusakan</label>
            <textarea name="deskripsi_kerusakan" class="form-control" required></textarea>
        </div>
        <div class="col-md-6">
            <label class="form-label">Tanggal Perbaikan</label>
            <input type="date" name="tanggal_perbaikan" class="form-control" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">Biaya Perbaikan (Rp)</label>
            <input type="number" name="biaya_perbaikan" step="0.01" class="form-control">
        </div>
        <div class="col-md-12">
            <button type="submit" class="btn btn-success">Simpan</button>
            <a href="/perbaikan" class="btn btn-outline-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection