<!DOCTYPE html>
<html>
<head>
    <title>Cetak Rekap Stunting Bulan</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 14px; }
        table { border-collapse: collapse; width: 100%; margin-top: 20px; }
        th, td { border: 1px solid #333; padding: 8px; text-align: center; }
        h2, h4 { text-align: center; margin: 0; }
    </style>
</head>
<body>
    <h2>Rekap Stunting Bulanan</h2>
    <h4>Bulan: {{ \Carbon\Carbon::parse($tanggal)->translatedFormat('F Y') }}</h4>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Balita</th>
                <th>Nama Ibu</th>
                <th>Tanggal</th>
                <th>Usia (bln)</th>
                <th>BB (kg)</th>
                <th>TB (cm)</th>
                <th>Status Stunting</th>
                <th>Catatan Bidan</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($rekaps as $i => $rekap)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $rekap->balita->nama ?? '-' }}</td>
                    <td>{{ $rekap->balita->nama_ibu ?? '-' }}</td>
                    <td>{{ \Carbon\Carbon::parse($rekap->tanggal)->format('d-m-Y') }}</td>
                    <td>{{ $rekap->usia }}</td>
                    <td>{{ $rekap->bb }}</td>
                    <td>{{ $rekap->tb }}</td>
                    <td>{{ $rekap->status_stunting }}</td>
                    <td>{{ $rekap->catatan_bidan ?? '-' }}</td>
                </tr>
            @empty
                <tr><td colspan="9">Tidak ada data.</td></tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
