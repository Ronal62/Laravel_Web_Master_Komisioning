<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Data Absensi</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 10px;
            color: #333;
            padding: 20px;
        }

        .header-container {
            border-bottom: 3px solid #2c3e50;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }

        .company-header {
            text-align: center;
            margin-bottom: 10px;
        }

        .company-name {
            font-size: 20px;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 3px;
        }

        .company-subtitle {
            font-size: 11px;
            color: #7f8c8d;
        }

        .report-title {
            text-align: center;
            margin-top: 15px;
            margin-bottom: 5px;
        }

        .report-title h2 {
            font-size: 16px;
            font-weight: bold;
            color: #2c3e50;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .report-info {
            text-align: center;
            margin-bottom: 20px;
        }

        .report-info p {
            font-size: 10px;
            color: #7f8c8d;
            margin: 3px 0;
        }

        .period-badge {
            display: inline-block;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 5px 15px;
            border-radius: 15px;
            font-size: 10px;
            font-weight: bold;
            margin: 5px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        table thead {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        table thead th {
            color: white;
            padding: 10px 8px;
            text-align: left;
            font-weight: 600;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border: none;
        }

        table tbody td {
            padding: 8px;
            border-bottom: 1px solid #ecf0f1;
            font-size: 9px;
        }

        table tbody tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        table tbody tr:hover {
            background-color: #e8eaf6;
        }

        .no-data {
            text-align: center;
            padding: 40px 20px;
            color: #95a5a6;
        }

        .no-data-icon {
            font-size: 48px;
            margin-bottom: 10px;
        }

        .footer-container {
            margin-top: 25px;
            padding-top: 15px;
            border-top: 2px solid #ecf0f1;
        }

        .footer-stats {
            display: table;
            width: 100%;
            margin-bottom: 15px;
        }

        .stat-box {
            display: table-cell;
            width: 33.33%;
            text-align: center;
            padding: 10px;
        }

        .stat-value {
            font-size: 18px;
            font-weight: bold;
            color: #667eea;
            margin-bottom: 3px;
        }

        .stat-label {
            font-size: 9px;
            color: #7f8c8d;
            text-transform: uppercase;
        }

        .footer-info {
            text-align: center;
            font-size: 8px;
            color: #95a5a6;
            margin-top: 10px;
        }

        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 10px;
            font-size: 8px;
            font-weight: bold;
        }

        .badge-in {
            background-color: #d4edda;
            color: #155724;
        }

        .badge-out {
            background-color: #f8d7da;
            color: #721c24;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }
    </style>
</head>

<body>
    <div class="header-container">
        <div class="company-header">
            <div class="company-name">SISTEM ABSENSI PEGAWAI</div>
            <div class="company-subtitle">Laporan Data Kehadiran Karyawan</div>
        </div>
    </div>

    <div class="report-title">
        <h2>Laporan Data Absensi</h2>
    </div>

    <div class="report-info">
        <span class="period-badge">{{ $periodText ?? 'Semua Data' }}</span>
        <p>Dicetak pada: {{ $exportDate ?? date('d-m-Y H:i:s') }}</p>
    </div>

    @if(isset($data) && $data->count() > 0)
    <table>
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 12%;">Tanggal</th>
                <th style="width: 10%;">Hari</th>
                <th style="width: 10%;">Waktu</th>
                <th style="width: 25%;">Nama Pegawai</th>
                <th style="width: 13%;">Jenis Absen</th>
                <th style="width: 25%;">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $index => $item)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $item['tgl_absen'] }}</td>
                <td>{{ $item['hari'] }}</td>
                <td>{{ $item['waktu'] }}</td>
                <td><strong>{{ $item['nama_absen'] }}</strong></td>
                <td>
                    @if($item['jenis_absen'] == 'Clock In')
                    <span class="badge badge-in">Clock In</span>
                    @else
                    <span class="badge badge-out">Clock Out</span>
                    @endif
                </td>
                <td>{{ $item['ket_absen'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer-container">
        <div class="footer-stats">
            <div class="stat-box">
                <div class="stat-value">{{ $totalRecords }}</div>
                <div class="stat-label">Total Record</div>
            </div>
            <div class="stat-box">
                <div class="stat-value">{{ $data->where('jenis_absen', 'Clock In')->count() }}</div>
                <div class="stat-label">Clock In</div>
            </div>
            <div class="stat-box">
                <div class="stat-value">{{ $data->where('jenis_absen', 'Clock Out')->count() }}</div>
                <div class="stat-label">Clock Out</div>
            </div>
        </div>

        <div class="footer-info">
            <p>Dokumen ini digenerate secara otomatis oleh sistem | {{ $exportDate }}</p>
            <p>© {{ date('Y') }} Sistem Absensi Pegawai - All Rights Reserved</p>
        </div>
    </div>
    @else
    <div class="no-data">
        <div class="no-data-icon">📋</div>
        <h3>Tidak Ada Data</h3>
        <p>Tidak ada data absensi untuk periode yang dipilih</p>
    </div>
    @endif
</body>

</html>
