@extends('layouts.app')
@section('title', 'Edit Data Latih')

@section('content')
<h3 class="fw-bold mb-4 text-center">Edit Data Latih KNN</h3>

<div class="card stat-card p-4 mx-auto" style="max-width:600px;">
    <form action="/data-latih/{{ $data->id_data_latih }}" method="POST" class="row g-3">
        @csrf
        @method('PUT')
        <div class="col-md-6">
            <label class="form-label">Jenis Inventaris</label>
            <select name="jenis_aset" class="form-select" required>
                @foreach(['Elektronik','Furnitur','Peralatan Kantor','Perlengkapan Kantor'] as $j)
                    <option value="{{ $j }}" {{ $data->jenis_aset == $j ? 'selected' : '' }}>{{ $j }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-6">
            <label class="form-label">Intensitas Penggunaan</label>
            <select name="intensitas_penggunaan" class="form-select" required>
                @foreach(['Rendah','Sedang','Tinggi'] as $i)
                    <option value="{{ $i }}" {{ $data->intensitas_penggunaan == $i ? 'selected' : '' }}>{{ $i }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-6">
            <label class="form-label">Usia Inventaris (tahun)</label>
            <input type="number" name="usia_aset" value="{{ $data->usia_aset }}" class="form-control" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">Label Kondisi</label>
            <select name="label_kondisi" class="form-select" required>
                @foreach(['Baik','Rusak Ringan','Rusak Berat'] as $l)
                    <option value="{{ $l }}" {{ $data->label_kondisi == $l ? 'selected' : '' }}>{{ $l }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-12">
            <button type="submit" class="btn btn-success">Update</button>
            <a href="/data-latih" class="btn btn-outline-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection