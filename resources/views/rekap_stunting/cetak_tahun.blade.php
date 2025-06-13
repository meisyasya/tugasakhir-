<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Rekap Stunting Tahunan</title>
    <style>
        @page {
            margin: 20mm 15mm;
        }

        body {
            font-family: "Times New Roman", Times, serif;
            font-size: 12pt;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            page-break-inside: auto;
        }

        th, td {
            border: 1px solid #333;
            padding: 6px;
            text-align: center;
        }

        h2, h4 {
            text-align: center;
            margin: 0;
        }

        .footer {
            position: fixed;
            bottom: -30px;
            left: 0;
            right: 0;
            text-align: right;
            font-size: 10pt;
            font-style: italic;
        }

        .pagenum:before {
            content: counter(page);
        }
    </style>
</head>
<body>
    <h2>REKAP BALITA STUNTING</h2>
    <h2>DESA BULUPAYUNG</h2>
    <h4>Tahun: {{ $tahun }}</h4>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Balita</th>
                <th>Nama Ibu</th>
                <th>Tanggal</th>
                <th>Usia (bln)</th>
                <th>BB</th>
                <th>TB</th>
                <th>Status Stunting</th>
                <th>Catatan Bidan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($rekaps as $i => $rekap)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $rekap->balita->nama }}</td>
                <td>{{ $rekap->balita->nama_ibu }}</td>
                <td>{{ \Carbon\Carbon::parse($rekap->tanggal)->format('d-m-Y') }}</td>
                <td>{{ $rekap->usia }}</td>
                <td>{{ $rekap->bb }}</td>
                <td>{{ $rekap->tb }}</td>
                <td>{{ $rekap->status_stunting }}</td>
                <td>{{ $rekap->catatan_bidan ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Halaman <span class="pagenum"></span>
    </div>
</body>
</html>
