<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{ $judul }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 10px; }
        h2, h4 { text-align: center; margin: 2px 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #333; padding: 4px; text-align: left; }
        th { background-color: #eee; }
    </style>
</head>
<body>
    @php
        // Kolom tambahan yang relevan untuk masing-masing jenis aset
        // (harus konsisten dengan field-group di form create/edit)
        $showNup      = !$filterJenis || in_array($filterJenis, ['Tanah','Sawah','Jalan dan Irigasi','Bangunan','Kendaraan']);
        $showUkuran   = !$filterJenis || in_array($filterJenis, ['Tanah','Sawah','Jalan dan Irigasi','Bangunan']);
        $showTipe     = !$filterJenis || in_array($filterJenis, ['Jalan dan Irigasi','Bangunan']);
        $showAtasHak  = !$filterJenis || in_array($filterJenis, ['Tanah','Sawah']);
        $showMerk     = !$filterJenis || $filterJenis === 'Kendaraan';
        $showNomorId  = !$filterJenis || $filterJenis === 'Kendaraan';
        $showKondisi  = !$filterJenis || $filterJenis === 'Kendaraan';

        $labelUkuran = $filterJenis === 'Jalan dan Irigasi' ? 'Ukuran' : 'Luas';
        $labelTipe   = $filterJenis === 'Bangunan' ? 'Tipe Bangunan' : 'Type';

        $colCount = 6 // No, Kode, Nama, Jenis, Cara Perolehan, Tahun
            + ($showNup ? 1 : 0) + ($showUkuran ? 1 : 0) + ($showTipe ? 1 : 0)
            + ($showAtasHak ? 1 : 0) + ($showMerk ? 1 : 0) + ($showNomorId ? 1 : 0)
            + ($showKondisi ? 1 : 0) + 1; // +1 untuk Nilai Perolehan
    @endphp

    <h2>{{ $judul }}</h2>
    <h4>Kecamatan Sukaluyu, Kabupaten Cianjur</h4>
    <p style="text-align:center;">Dicetak: {{ now()->format('d/m/Y H:i') }}</p>

    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>Kode</th>
                <th>Nama Aset</th>
                <th>Jenis Aset</th>
                @if($showNup)<th>NUP</th>@endif
                @if($showUkuran)<th>{{ $labelUkuran }}</th>@endif
                @if($showTipe)<th>{{ $labelTipe }}</th>@endif
                @if($showAtasHak)<th>Atas Hak / Bukti Kepemilikan</th>@endif
                @if($showMerk)<th>Merk/Type</th>@endif
                @if($showNomorId)<th>Nomor Identitas</th>@endif
                @if($showKondisi)<th>Kondisi</th>@endif
                <th>Cara Perolehan</th>
                <th>Tahun Perolehan</th>
                <th>Nilai Perolehan (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @forelse($asetDesa as $i => $aset)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $aset->kode_aset }}</td>
                <td>{{ $aset->nama_aset }}</td>
                <td>{{ $aset->jenis_aset }}</td>
                @if($showNup)<td>{{ $aset->nup ?? '-' }}</td>@endif
                @if($showUkuran)<td>{{ $aset->ukuran_luas ?? '-' }}</td>@endif
                @if($showTipe)<td>{{ $aset->tipe ?? '-' }}</td>@endif
                @if($showAtasHak)<td>{{ $aset->atas_hak ?? '-' }}</td>@endif
                @if($showMerk)<td>{{ $aset->merk_type ?? '-' }}</td>@endif
                @if($showNomorId)<td>{{ $aset->nomor_identitas ?? '-' }}</td>@endif
                @if($showKondisi)<td>{{ $aset->kondisi_aset ?? 'Belum diketahui' }}</td>@endif
                <td>{{ $aset->cara_perolehan ?? '-' }}</td>
                <td>{{ \Carbon\Carbon::parse($aset->tahun_perolehan)->format('Y') }}</td>
                <td>{{ number_format($aset->nilai_perolehan, 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr><td colspan="{{ $colCount }}" style="text-align:center;">Tidak ada data.</td></tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>