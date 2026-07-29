@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
<h3 class="mb-4 fw-bold">DASHBOARD</h3>

<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card stat-card p-3 text-center">
            <div class="text-muted">Total Aset</div>
            <div class="fs-2 fw-bold">{{ $totalAset }}</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card p-3 text-center">
            <div class="text-muted">Kondisi Baik</div>
            <div class="fs-2 fw-bold text-success">{{ $kondisiBaik }}</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card p-3 text-center">
            <div class="text-muted">Rusak Ringan</div>
            <div class="fs-2 fw-bold text-warning">{{ $rusakRingan }}</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card p-3 text-center">
            <div class="text-muted">Rusak Berat</div>
            <div class="fs-2 fw-bold text-danger">{{ $rusakBerat }}</div>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-7">
        <div class="card stat-card p-3">
            <h6 class="fw-bold mb-3">Distribusi Kondisi Aset</h6>
            <div style="height: 250px;">
                <canvas id="chartKondisi"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-5">
        <div class="card stat-card p-3">
            <h6 class="fw-bold mb-3">Distribusi Kategori Aset</h6>
            <div style="height: 250px;">
                <canvas id="chartKategori"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="card stat-card p-3">
    <h6 class="fw-bold mb-3">Aktivitas Klasifikasi Terbaru</h6>
    <table class="table table-striped">
        <thead>
            <tr><th>Waktu</th><th>Aset</th><th>Hasil Klasifikasi</th></tr>
        </thead>
        <tbody>
            @forelse($aktivitasTerbaru as $a)
            <tr>
                <td>{{ $a->created_at->format('d/m/Y H:i') }}</td>
                <td>{{ $a->nama_aset_uji }}</td>
                <td>{{ $a->hasil_klasifikasi }}</td>
            </tr>
            @empty
            <tr><td colspan="3">Belum ada aktivitas klasifikasi.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<script>
new Chart(document.getElementById('chartKondisi'), {
    type: 'bar',
    data: {
        labels: ['Baik', 'Rusak Ringan', 'Rusak Berat'],
        datasets: [{
            label: 'Jumlah Aset',
            data: [{{ $kondisiBaik }}, {{ $rusakRingan }}, {{ $rusakBerat }}],
            backgroundColor: ['#198754', '#ffc107', '#dc3545']
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { display: false } }
    }
});

new Chart(document.getElementById('chartKategori'), {
    type: 'pie',
    data: {
        labels: [@foreach($kategoriData as $k) '{{ $k->jenis_kategori }}', @endforeach],
        datasets: [{
            data: [@foreach($kategoriData as $k) {{ $k->data_aset_count }}, @endforeach],
            backgroundColor: ['#0d6efd', '#198754', '#ffc107', '#6f42c1', '#fd7e14']
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false
    }
});
</script>
@endsection