@extends('layouts.app')
@section('title', 'Hasil Klasifikasi')

@section('content')
<h3 class="fw-bold mb-4">Hasil Klasifikasi: {{ $klasifikasi->nama_aset_uji }}</h3>

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card stat-card p-3 text-center">
            <div class="text-muted">Jenis Aset</div>
            <div class="fs-5 fw-bold">{{ $klasifikasi->jenis_aset_uji }}</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card stat-card p-3 text-center">
            <div class="text-muted">Nilai K</div>
            <div class="fs-5 fw-bold">{{ $klasifikasi->nilai_k }}</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card stat-card p-3 text-center">
            <div class="text-muted">Hasil Klasifikasi</div>
            <div class="fs-5 fw-bold">
                <span class="badge bg-{{ $hasil['hasil_klasifikasi'] == 'Baik' ? 'success' : ($hasil['hasil_klasifikasi'] == 'Rusak Ringan' ? 'warning' : 'danger') }}">
                    {{ $hasil['hasil_klasifikasi'] }}
                </span>
            </div>
        </div>
    </div>
</div>

<div class="card stat-card p-3 mb-4">
    <h6 class="fw-bold mb-3">Tabel Jarak Euclidean ke Semua Data Latih</h6>
    <table class="table table-sm table-striped">
        <thead><tr><th>Jenis Aset Latih</th><th>Jarak Euclidean</th><th>Label Kondisi</th></tr></thead>
        <tbody>
            @foreach($hasil['semua_jarak'] as $j)
            <tr>
                <td>{{ $j['nama_referensi'] }}</td>
                <td>{{ $j['jarak'] }}</td>
                <td>{{ $j['label_kondisi'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="card stat-card p-3 mb-4">
    <h6 class="fw-bold mb-3">K Tetangga Terdekat (K={{ $klasifikasi->nilai_k }})</h6>
    <table class="table table-sm table-bordered">
        <thead class="table-success"><tr><th>Jenis Aset Latih</th><th>Jarak</th><th>Label Kondisi</th></tr></thead>
        <tbody>
            @foreach($hasil['k_tetangga'] as $t)
            <tr>
                <td>{{ $t['nama_referensi'] }}</td>
                <td>{{ $t['jarak'] }}</td>
                <td>{{ $t['label_kondisi'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<a href="/klasifikasi" class="btn btn-outline-secondary">Kembali</a>
@endsection