<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Data Latih KNN</title>
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
    <h2>DATA LATIH K-NEAREST NEIGHBOR</h2>
    <h4>Sistem Informasi Pengelolaan Inventaris Desa Hegarmanah</h4>
    <p style="text-align:center;">Dicetak: {{ now()->format('d/m/Y H:i') }}</p>

    <div class="summary">
        <div><strong>Total Data Latih</strong><br>{{ $summary['total'] }}</div>
        <div><strong>Baik</strong><br>{{ $summary['baik'] }}</div>
        <div><strong>Rusak Ringan</strong><br>{{ $summary['rusak_ringan'] }}</div>
        <div><strong>Rusak Berat</strong><br>{{ $summary['rusak_berat'] }}</div>
    </div>

    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>Jenis Inventaris (X1)</th>
                <th>Intensitas Penggunaan (X2)</th>
                <th>Usia Inventaris/tahun (X3)</th>
                <th>Label Kondisi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($dataLatih as $i => $d)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $d->jenis_aset }}</td>
                <td>{{ $d->intensitas_penggunaan }}</td>
                <td>{{ $d->usia_aset }}</td>
                <td>{{ $d->label_kondisi }}</td>
            </tr>
            @empty
            <tr><td colspan="5" style="text-align:center;">Belum ada data latih.</td></tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>