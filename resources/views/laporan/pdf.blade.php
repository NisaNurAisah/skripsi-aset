<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Inventaris</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        h2, h4 { text-align: center; margin: 2px 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #333; padding: 6px; text-align: left; }
        th { background-color: #eee; }
        .summary { display: flex; justify-content: space-around; margin-top: 15px; text-align: center; }
        .summary div { border: 1px solid #333; padding: 8px; width: 22%; }
    </style>
</head>
<body>
    <h2>LAPORAN HASIL INVENTARISASI ASET DESA</h2>
    <h4>Desa Hegarmanah, Kecamatan Sukaluyu, Kabupaten Cianjur</h4>
    <p style="text-align:center;">Periode: {{ $periode }} | Dicetak: {{ now()->format('d/m/Y H:i') }}</p>

    <div class="summary">
        <div><strong>Total Aset</strong><br>{{ $summary['total'] }}</div>
        <div><strong>Baik</strong><br>{{ $summary['baik'] }}</div>
        <div><strong>Rusak Ringan</strong><br>{{ $summary['rusak_ringan'] }}</div>
        <div><strong>Rusak Berat</strong><br>{{ $summary['rusak_berat'] }}</div>
    </div>

    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>Kode</th>
                <th>Nama Aset</th>
                <th>Kategori</th>
                <th>Lokasi</th>
                <th>Jumlah</th>
                <th>Tahun Perolehan</th>
                <th>Kondisi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($dataAset as $i => $aset)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $aset->kode_aset }}</td>
                <td>{{ $aset->nama_aset }}</td>
                <td>{{ $aset->kategori->jenis_kategori ?? '-' }}</td>
                <td>{{ $aset->lokasi->nama_lokasi ?? '-' }}</td>
                <td>{{ $aset->jumlah_aset }}</td>
                <td>{{ \Carbon\Carbon::parse($aset->tahun_perolehan)->format('Y') }}</td>
                <td>{{ $aset->kondisi_aset ?? 'Belum diketahui' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>