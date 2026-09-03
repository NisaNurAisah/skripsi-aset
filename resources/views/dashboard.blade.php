@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
<h3 class="mb-4 fw-bold">DASHBOARD</h3>

<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card stat-card p-3 text-center">
            <div class="text-muted">Total Inventaris</div>
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
    <div class="col-md-12">
        <div class="card stat-card p-3">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="fw-bold mb-0">Ringkasan Aset Desa</h6>
                <a href="/data-aset-desa" class="btn btn-sm btn-outline-success">Lihat Semua</a>
            </div>
            <div class="row g-3">
                <div class="col-md-4">
                    <div class="border rounded p-3 text-center h-100">
                        <div class="text-muted">Total Aset Desa</div>
                        <div class="fs-3 fw-bold">{{ $totalAsetDesa }}</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="border rounded p-3 text-center h-100">
                        <div class="text-muted">Total Nilai Perolehan</div>
                        <div class="fs-5 fw-bold text-success">Rp {{ number_format($totalNilaiAsetDesa, 0, ',', '.') }}</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="border rounded p-3 h-100">
                        <div class="text-muted mb-2">Jenis Aset</div>
                        @forelse($asetDesaPerJenis as $j)
                        <div class="d-flex justify-content-between small">
                            <span>{{ $j->jenis_aset }}</span>
                            <span class="fw-bold">{{ $j->jumlah }}</span>
                        </div>
                        @empty
                        <div class="text-muted small">Belum ada data.</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-12">
        <div class="card stat-card p-3">
            <h6 class="fw-bold mb-3">Distribusi Kondisi Inventaris</h6>
            <div style="height: 250px;">
                <canvas id="chartKondisi"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="card stat-card p-3">
    <h6 class="fw-bold mb-3">Aktivitas Klasifikasi Terbaru</h6>
    <table class="table table-striped">
        <thead>
            <tr><th>Waktu</th><th>Inventaris</th><th>Hasil Klasifikasi</th></tr>
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
</script>
@endsection