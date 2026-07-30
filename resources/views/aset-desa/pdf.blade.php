<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{ $judul }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        h2, h4 { text-align: center; margin: 2px 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #333; padding: 6px; text-align: left; }
        th { background-color: #eee; }
    </style>
</head>
<body>
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
                <th>Cara Perolehan</th>
                <th>Tahun Perolehan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($asetDesa as $i => $aset)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $aset->kode_aset }}</td>
                <td>{{ $aset->nama_aset }}</td>
                <td>{{ $aset->jenis_aset }}</td>
                <td>{{ $aset->cara_perolehan ?? '-' }}</td>
                <td>{{ \Carbon\Carbon::parse($aset->tahun_perolehan)->format('Y') }}</td>
            </tr>
            @empty
            <tr><td colspan="6" style="text-align:center;">Tidak ada data.</td></tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>