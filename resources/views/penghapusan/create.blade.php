@extends('layouts.app')
@section('title', 'Tambah Penghapusan')

@section('content')
<h3 class="fw-bold mb-4">Tambah Data Penghapusan</h3>

<div class="card stat-card p-4" style="max-width:600px;">
    <form action="/penghapusan" method="POST" class="row g-3">
        @csrf
        <div class="col-md-12">
            <label class="form-label">Aset</label>
            <select name="id_aset" class="form-select" required>
                @foreach($dataAset as $a)
                    <option value="{{ $a->id_aset }}">{{ $a->nama_aset }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-6">
            <label class="form-label">Tanggal Penghapusan</label>
            <input type="date" name="tanggal_penghapusan" class="form-control" required>
        </div>
        <div class="col-md-12">
            <label class="form-label">Alasan Penghapusan</label>
            <textarea name="alasan_penghapusan" class="form-control" required></textarea>
        </div>
        <div class="col-md-12">
            <button type="submit" class="btn btn-success">Simpan</button>
            <a href="/penghapusan" class="btn btn-outline-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection