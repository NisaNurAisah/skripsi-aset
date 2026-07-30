@extends('layouts.app')
@section('title', 'Data Aset Desa')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="fw-bold">{{ request('jenis_aset') ? 'Data Aset ' . request('jenis_aset') : 'Data Aset' }}</h3>
    <div>
        <a href="/data-aset-desa/download-pdf?{{ http_build_query(request()->only('search','jenis_aset')) }}" class="btn btn-outline-success"><i class="bi bi-file-earmark-pdf"></i> Cetak PDF</a>
        <a href="/data-aset-desa/create" class="btn btn-success"><i class="bi bi-plus-lg"></i> Tambah Aset</a>
    </div>
</div>

<div class="card stat-card p-3 mb-3">
    <form action="/data-aset-desa" method="GET" class="row g-2 align-items-end">
        <div class="col-md-6">
            <label class="form-label mb-1">Cari</label>
            <input type="text" name="search" class="form-control" placeholder="Cari nama atau kode aset..." value="{{ request('search') }}">
        </div>
        <div class="col-md-4">
            <label class="form-label mb-1">Jenis Aset</label>
            <select name="jenis_aset" class="form-select">
                <option value="">- Semua Jenis -</option>
                @foreach($jenisAsetList as $j)
                    <option value="{{ $j }}" {{ request('jenis_aset') == $j ? 'selected' : '' }}>{{ $j }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-success w-100">Filter</button>
        </div>
    </form>
    @if(request('search') || request('jenis_aset'))
        <a href="/data-aset-desa" class="btn btn-sm btn-outline-secondary mt-2">Reset Filter</a>
    @endif
</div>

<div class="card stat-card p-3">
    <table class="table table-striped align-middle">
        <thead>
            <tr>
                <th>No.</th>
                <th>Kode</th>
                <th>Nama Aset</th>
                <th>Jenis Aset</th>
                <th>Cara Perolehan</th>
                <th>Tahun Perolehan</th>
                <th>Foto</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($asetDesa as $aset)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $aset->kode_aset }}</td>
                <td>{{ $aset->nama_aset }}</td>
                <td>{{ $aset->jenis_aset }}</td>
                <td>{{ $aset->cara_perolehan ?? '-' }}</td>
                <td>{{ \Carbon\Carbon::parse($aset->tahun_perolehan)->format('Y') }}</td>
                <td>
                    @if($aset->gambar_aset)
                        <img src="/storage/{{ $aset->gambar_aset }}" style="height:50px; width:50px; object-fit:cover; border-radius:6px;">
                    @else
                        <span class="text-muted small">-</span>
                    @endif
                </td>
                <td>
                    <a href="/data-aset-desa/{{ $aset->id_aset_desa }}/edit" class="btn btn-sm btn-outline-primary">Edit</a>
                    <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#detailModal{{ $aset->id_aset_desa }}">Detail</button>
                    <form action="/data-aset-desa/{{ $aset->id_aset_desa }}" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Yakin hapus?')">Hapus</button>
                    </form>
                </td>
            </tr>

            <div class="modal fade" id="detailModal{{ $aset->id_aset_desa }}" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Detail Aset - {{ $aset->nama_aset }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <table class="table table-sm table-borderless mb-0">
                                <tr><th style="width:180px">Kode Aset</th><td>{{ $aset->kode_aset }}</td></tr>
                                <tr><th>Jenis Aset</th><td>{{ $aset->jenis_aset }}</td></tr>
                                <tr><th>NUP</th><td>{{ $aset->nup ?? '-' }}</td></tr>
                                @if(in_array($aset->jenis_aset, ['Tanah','Sawah','Jalan dan Irigasi','Bangunan']))
                                <tr><th>{{ $aset->jenis_aset == 'Jalan dan Irigasi' ? 'Ukuran' : 'Luas' }}</th><td>{{ $aset->ukuran_luas ?? '-' }}</td></tr>
                                @endif
                                @if(in_array($aset->jenis_aset, ['Jalan dan Irigasi','Bangunan']))
                                <tr><th>{{ $aset->jenis_aset == 'Bangunan' ? 'Tipe Bangunan' : 'Type' }}</th><td>{{ $aset->tipe ?? '-' }}</td></tr>
                                @endif
                                @if(in_array($aset->jenis_aset, ['Tanah','Sawah']))
                                <tr><th>Atas Hak/Bukti Kepemilikan</th><td>{{ $aset->atas_hak ?? '-' }}</td></tr>
                                @endif
                                @if($aset->jenis_aset == 'Kendaraan')
                                <tr><th>Merk/Type</th><td>{{ $aset->merk_type ?? '-' }}</td></tr>
                                <tr><th>Nomor Identitas</th><td>{{ $aset->nomor_identitas ?? '-' }}</td></tr>
                                <tr><th>Kondisi</th><td>{{ $aset->kondisi_aset ?? 'Belum diketahui' }}</td></tr>
                                @endif
                                <tr><th>Cara Perolehan</th><td>{{ $aset->cara_perolehan ?? '-' }}</td></tr>
                                <tr><th>Tahun Perolehan</th><td>{{ \Carbon\Carbon::parse($aset->tahun_perolehan)->format('Y') }}</td></tr>
                                <tr><th>Nilai Perolehan</th><td>Rp {{ number_format($aset->nilai_perolehan, 0, ',', '.') }}</td></tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <tr><td colspan="8" class="text-center text-muted">Belum ada data aset desa.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection