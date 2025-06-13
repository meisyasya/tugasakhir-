<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak Rekap Bulanan</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12pt;
            margin: 40px;
            color: #000;
        }

        h2, h3 {
            text-align: center;
            margin: 0;
        }

        .tanggal {
            text-align: right;
            margin-top: 10px;
            font-size: 12pt;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 25px;
        }

        th, td {
            border: 1px solid #000;
            padding: 8px;
            font-size: 12pt;
            text-align: center;
        }

        th {
            background-color: #f0f0f0;
        }
        .col-nama-balita {
            width: 15%; /* Adjust as needed */
        }
        .col-nama-ibu {
            width: 15%; /* Adjust as needed */
        }

        .col-posyandu {
            width: 15%; /* Adjust as needed */
        }

        .footer {
            margin-top: 40px;
            text-align: right;
            font-size: 12pt;
        }
    </style>
</head>
<body>

    <h2>DAFTAR HADIR POSYANDU BALITA</h2>
    <h3>DESA BULUPAYUNG</h3>
    <p class="tanggal"><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($tanggal)->format('d F Y') }}</p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Balita</th>
                <th>Nama Ibu</th>
                <th>Posyandu</th>
                <th>Usia (bulan)</th>
                <th>Berat Badan (kg)</th>
                <th>Tinggi Badan (cm)</th>
                <th>Lingkar Kepala (cm)</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($rekaps as $i => $rekap)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td class="col-nama-balita" >{{ $rekap->balita->nama ?? '-' }}</td>
                    <td class="col-nama-ibu" >{{ $rekap->balita->nama_ibu ?? '-' }}</td>
                    <td class="col-posyandu" >{{ $rekap->balita->posyandu ?? '-' }}</td>
                    <td>{{ $rekap->usia ?? '-' }}</td>
                    <td>{{ $rekap->bb }}</td>
                    <td>{{ $rekap->tb }}</td>
                    <td>{{ $rekap->lingkar_kepala }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8">Tidak ada data tersedia</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Mengetahui,</p>
        <p style="margin-top: 60px;">______________________</p>
        
    </div>

</body>
</html>
