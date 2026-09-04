<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Data Inventaris</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        h2, h4 { text-align: center; margin: 2px 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #333; padding: 6px; text-align: left; }
        th { background-color: #eee; }
    </style>
</head>
<body>
    <h2>DATA INVENTARIS DESA HEGARMANAH</h2>
    <h4>Kecamatan Sukaluyu, Kabupaten Cianjur</h4>
    <p style="text-align:center;">Dicetak: {{ now()->format('d/m/Y H:i') }}</p>

    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>Nama Inventaris</th>
                <th>Jenis Inventaris</th>
                <th>Merk</th>
                <th>Lokasi</th>
                <th>Jumlah</th>
                <th>Tahun Perolehan</th>
                <th>Kondisi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($dataInventaris as $i => $inventaris)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $inventaris->nama_inventaris }}</td>
                <td>{{ $inventaris->jenis_inventaris }}</td>
                <td>{{ $inventaris->merk ?? '-' }}</td>
                <td>{{ $inventaris->lokasi->nama_lokasi ?? '-' }}</td>
                <td>{{ $inventaris->jumlah_inventaris }}</td>
                <td>{{ \Carbon\Carbon::parse($inventaris->tahun_perolehan)->format('Y') }}</td>
                <td>{{ $inventaris->kondisi_inventaris ?? 'Belum diketahui' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>