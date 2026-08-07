<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Hasil Klasifikasi - {{ $klasifikasi->nama_aset_uji }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 11px; }
        h2, h4 { text-align: center; margin: 2px 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 12px; }
        th, td { border: 1px solid #333; padding: 4px 6px; text-align: left; }
        th { background-color: #eee; }
        .info-table td { border: none; padding: 2px 6px; }
        .badge {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 4px;
            color: #fff;
            font-weight: bold;
        }
        .badge-baik { background-color: #198754; }
        .badge-ringan { background-color: #ffc107; color: #000; }
        .badge-berat { background-color: #dc3545; }
        .tetangga-row { background-color: #d1e7dd; }
    </style>
</head>
<body>
    <h2>Hasil Klasifikasi Kondisi Inventaris</h2>
    <h4>Kecamatan Sukaluyu, Kabupaten Cianjur</h4>
    <p style="text-align:center;">Dicetak: {{ now()->format('d/m/Y H:i') }}</p>

    <table class="info-table">
        <tr>
            <td width="25%"><strong>Nama Inventaris</strong></td>
            <td width="2%">:</td>
            <td>{{ $klasifikasi->nama_aset_uji }}</td>
        </tr>
        <tr>
            <td><strong>Jenis Inventaris</strong></td>
            <td>:</td>
            <td>{{ $klasifikasi->jenis_aset_uji }}</td>
        </tr>
        <tr>
            <td><strong>Intensitas Penggunaan</strong></td>
            <td>:</td>
            <td>{{ $klasifikasi->intensitas_penggunaan_uji }}</td>
        </tr>
        <tr>
            <td><strong>Usia Inventaris</strong></td>
            <td>:</td>
            <td>{{ $klasifikasi->usia_aset_uji }} tahun</td>
        </tr>
        <tr>
            <td><strong>Tanggal Klasifikasi</strong></td>
            <td>:</td>
            <td>{{ \Carbon\Carbon::parse($klasifikasi->tanggal_klasifikasi)->format('d/m/Y') }}</td>
        </tr>
        <tr>
            <td><strong>Nilai K</strong></td>
            <td>:</td>
            <td>{{ $klasifikasi->nilai_k }}</td>
        </tr>
        <tr>
            <td><strong>Hasil Klasifikasi</strong></td>
            <td>:</td>
            <td>
                @php
                    $badgeClass = $hasil['hasil_klasifikasi'] == 'Baik' ? 'badge-baik'
                        : ($hasil['hasil_klasifikasi'] == 'Rusak Ringan' ? 'badge-ringan' : 'badge-berat');
                @endphp
                <span class="badge {{ $badgeClass }}">{{ $hasil['hasil_klasifikasi'] }}</span>
            </td>
        </tr>
    </table>

    <h4 style="text-align:left; margin-top:16px;">K Tetangga Terdekat (K={{ $klasifikasi->nilai_k }})</h4>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Jenis Inventaris Latih</th>
                <th>Jarak Euclidean</th>
                <th>Label Kondisi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($hasil['k_tetangga'] as $i => $t)
            <tr class="tetangga-row">
                <td>{{ $i + 1 }}</td>
                <td>{{ $t['nama_referensi'] }}</td>
                <td>{{ $t['jarak'] }}</td>
                <td>{{ $t['label_kondisi'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h4 style="text-align:left; margin-top:16px;">Tabel Jarak Euclidean ke Seluruh Data Latih</h4>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Jenis Inventaris Latih</th>
                <th>Jarak Euclidean</th>
                <th>Label Kondisi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($hasil['semua_jarak'] as $i => $j)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $j['nama_referensi'] }}</td>
                <td>{{ $j['jarak'] }}</td>
                <td>{{ $j['label_kondisi'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>