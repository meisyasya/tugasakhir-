<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan PMT Stunting Desa Bulupayung</title>
    <style>
        body {
            font-family: "Times New Roman", Times, serif;
            font-size: 11px;
            margin: 40px;
            color: #000;
        }

        .header {
            text-align: center;
            margin-bottom: 25px;
        }

        .kabupaten-text, .kecamatan-text {
            font-size: 14px;
            font-weight: bold;
            margin: 0;
        }

        .desa-text {
            font-size: 18px;
            font-weight: bold;
            margin: 3px 0;
        }

        .alamat-text {
            font-size: 10px;
            margin-bottom: 8px;
        }

        .line-full {
            border-bottom: 2px solid #000;
            margin: 8px auto 15px;
            width: 100%;
        }

        .laporan-title {
            font-size: 13px;
            font-weight: bold;
            margin: 2px 0;
            text-transform: uppercase;
        }

        .section-title {
            background-color: #4A90E2;
            color: white;
            padding: 8px 15px;
            margin: 30px 0 15px;
            font-size: 13px;
            font-weight: bold;
            border-radius: 4px;
        }

        .info-row {
            margin-bottom: 6px;
        }

        .info-row strong {
            display: inline-block;
            width: 120px;
            font-weight: normal;
        }

        .info-row .value {
            font-weight: bold;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .data-table th, .data-table td {
            border: 1px solid #aaa;
            padding: 6px;
            text-align: left;
            vertical-align: top;
        }

        .data-table th {
            background-color: #e7eaf0;
            font-size: 11px;
        }

        .data-table td {
            font-size: 10.5px;
        }

        .data-table img {
            max-width: 80px;
            height: auto;
            display: block;
            margin: 0 auto;
            border-radius: 4px;
        }

        .no-col {
            width: 30px;
            text-align: center;
        }

        .footer {
            text-align: center;
            margin-top: 50px;
            font-size: 9px;
            color: #777;
            border-top: 1px solid #eee;
            padding-top: 10px;
        }
    </style>
</head>
<body>

    <div class="header">
        <p class="kabupaten-text">PEMERINTAH KABUPATEN CILACAP</p>
        <p class="kecamatan-text">KECAMATAN KESUGIHAN</p>
        <p class="desa-text">DESA BULUPAYUNG</p>
        <p class="alamat-text">Jl. Tambangan No.32 RT 004 RW 002</p>
        <div class="line-full"></div>
        <p class="laporan-title">Laporan Monitoring dan Evaluasi</p>
        <p class="laporan-title">Pemberian Makanan Tambahan</p>
        <p class="laporan-title">Desa Bulupayung</p>
    </div>

    <div>
        <div class="section-title">Informasi Balita</div>
        <div class="info-row"><strong>Nama</strong> <span class="value">: {{ $laporanData->balita->nama ?? '-' }}</span></div>
        <div class="info-row"><strong>NIK</strong> <span class="value">: {{ $laporanData->balita->nik ?? '-' }}</span></div>
        <div class="info-row"><strong>Tanggal Lahir</strong> <span class="value">: {{ \Carbon\Carbon::parse($laporanData->balita->tanggal_lahir)->format('d-m-Y') ?? '-' }}</span></div>
        <div class="info-row"><strong>Jenis Kelamin</strong> <span class="value">: {{ $laporanData->balita->jenis_kelamin ?? '-' }}</span></div>
        <div class="info-row"><strong>Nama Ibu</strong> <span class="value">: {{ $laporanData->balita->nama_ibu ?? '-' }}</span></div>
        <div class="info-row"><strong>Alamat</strong> <span class="value">: {{ $laporanData->balita->alamat_lengkap ?? '-' }}</span></div>
    </div>

    <div class="table-container">
        <div class="section-title">Distribusi PMT</div>
        <table class="data-table">
            <thead>
                <tr>
                    <th class="no-col">No</th>
                    <th>Tanggal Distribusi</th>
                    <th>Foto Bukti</th>
                    <th>Keterangan</th>
                    <th>Nama Kader</th>
                </tr>
            </thead>
            <tbody>
                @php
                    \Carbon\Carbon::setLocale('id');
                    setlocale(LC_TIME, 'id_ID.utf8');
                @endphp

                @forelse($laporanData->distribusipmt as $index => $distribusi)
                <tr>
                    <td class="no-col">{{ $index + 1 }}</td>
                    <td>{{ \Carbon\Carbon::parse($distribusi->tanggal_distribusi)->translatedFormat('l, d F Y') ?? '-' }}</td>
                    <td>
                        @if($distribusi->foto_bukti)
                            <img src="data:image/jpeg;base64,{{ base64_encode(file_get_contents(public_path('storage/' . $distribusi->foto_bukti))) }}" alt="Foto Bukti">
                        @else
                            Tidak Ada Foto
                        @endif
                    </td>
                    <td>{{ $distribusi->keterangan ?? '-' }}</td>
                    <td>{{ $distribusi->nama_kader ?? '-' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align: center;">Tidak ada data distribusi PMT.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="footer">
        <p>Laporan ini dihasilkan secara otomatis oleh Sistem </p>
        <p>&copy; {{ date('Y') }} Desa Bulupayung</p>
        <p>Tanggal Cetak: {{ \Carbon\Carbon::now()->format('d F Y, H:i:s') }} WIB</p>
    </div>

</body>
</html>
