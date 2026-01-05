// Perbaikan pada excel/bydatepenyulangan_excel.blade.php
// Catatan: Blade ini dirancang untuk export HTML sebagai XLS (cara sederhana tanpa library seperti Maatwebsite\Excel).
// Saya asumsikan konten dari singlepenyulangan_excel.blade.php mirip, jadi saya lengkapi placeholder dengan struktur
tabel umum.
// Jika singlepenyulangan_excel.blade.php memiliki konten spesifik, sesuaikan saja. Saya buat lengkap berdasarkan data
yang ada.
// Tambahkan style inline untuk kompatibilitas Excel.

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Penyulangan By Date - {{ $fromDate ?? 'All' }} to {{ $toDate ?? 'All' }}</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        font-size: 10pt;
    }

    table {
        border-collapse: collapse;
        width: 100%;
    }

    th,
    td {
        border: 1px solid black;
        padding: 5px;
        text-align: left;
    }

    .no-border {
        border: none;
    }

    .header-title {
        text-align: center;
        font-size: 14pt;
        font-weight: bold;
    }

    /* Tambahkan style lain jika diperlukan dari singlepenyulangan_excel.blade.php */
    </style>
</head>

<body>
    <h1 class="header-title">Penyulangan Report By Date: {{ $fromDate ?? 'All' }} - {{ $toDate ?? 'All' }}</h1>

    @foreach($data as $index => $item)
    <div style="page-break-after: always;">
        @php $row = $item['row']; @endphp
        @php $pelaksanaMs = $item['pelaksanaMs']; @endphp
        @php $pelaksanaRtu = $item['pelaksanaRtu']; @endphp
        @php $statusData = $item['statusData']; @endphp
        @php $controlData = $item['controlData']; @endphp
        @php $meteringData = $item['meteringData']; @endphp

        {{-- ===== HEADER SECTION ===== --}}
        <table class="no-border" style="margin-bottom: 10px;">
            <tr>
                <td colspan="2"><strong>ID Penyulangan:</strong> {{ $row->id_peny ?? '-' }}</td>
            </tr>
            <tr>
                <td><strong>Tanggal Komisioning:</strong> {{ $row->tgl_kom ?? '-' }}</td>
                <td><strong>Nama Penyulangan:</strong> {{ $row->nama_peny ?? '-' }}</td>
            </tr>
            <!-- Tambahkan field header lain jika diperlukan -->
        </table>

        {{-- ===== TITLE ===== --}}
        <table class="no-border" style="margin-bottom: 10px;">
            <tr>
                <td colspan="2" style="text-align: center; font-weight: bold;">Detail Penyulangan</td>
            </tr>
        </table>

        {{-- ===== DEVICE INFO ===== --}}
        <table style="margin-bottom: 15px;">
            <thead>
                <tr>
                    <th>RTU GI</th>
                    <th>Media Komunikasi</th>
                    <th>Komunikasi KP</th>
                    <th>RTU Address</th>
                    <th>Last Update</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $row->nama_rtugi ?? '-' }}</td>
                    <td>{{ $row->nama_medkom ?? '-' }}</td>
                    <td>{{ $row->jenis_komkp ?? '-' }}</td>
                    <td>{{ $row->rtu_addrs ?? '-' }}</td>
                    <td>{{ $row->lastupdate ?? '-' }}</td>
                </tr>
            </tbody>
        </table>

        {{-- ===== STATUS TABLE ===== --}}
        <table style="margin-bottom: 15px;">
            <thead>
                <tr>
                    <th>Status</th>
                    <th>Value</th>
                    <!-- Tambahkan kolom status lain berdasarkan $statusData -->
                </tr>
            </thead>
            <tbody>
                <!-- Loop atau tampilkan $statusData, misal: -->
                <tr>
                    <td>CB</td>
                    <td>{{ $statusData['s_cb'] ?? '-' }}</td>
                </tr>
                <!-- Tambahkan row lain untuk s_lr, s_ocr, dll. sesuai parseStatusDataPeny -->
            </tbody>
        </table>

        {{-- ===== CONTROL TABLE ===== --}}
        <table style="margin-bottom: 15px;">
            <thead>
                <tr>
                    <th>Control</th>
                    <th>Value</th>
                    <!-- Tambahkan kolom control lain -->
                </tr>
            </thead>
            <tbody>
                <!-- Contoh dari $controlData -->
                <tr>
                    <td>CB</td>
                    <td>{{ $controlData['c_cb'] ?? '-' }}</td>
                </tr>
                <!-- Tambahkan row lain -->
            </tbody>
        </table>

        {{-- ===== METERING TABLE ===== --}}
        <table style="margin-bottom: 15px;">
            <thead>
                <tr>
                    <th>Metering</th>
                    <th>Address</th>
                    <th>Scale</th>
                    <!-- Tambahkan kolom metering lain -->
                </tr>
            </thead>
            <tbody>
                <!-- Contoh dari $meteringData -->
                <tr>
                    <td>IR</td>
                    <td>{{ $meteringData['ir_address'] ?? '-' }}</td>
                    <td>{{ $meteringData['ir_scale'] ?? '-' }}</td>
                </tr>
                <!-- Tambahkan row lain untuk is, it, ifr, dll. -->
            </tbody>
        </table>

        {{-- ===== ADDITIONAL INFO SECTION ===== --}}
        <table style="margin-bottom: 15px;">
            <thead>
                <tr>
                    <th>Keterangan</th>
                    <th>Value</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Catatan</td>
                    <td>{{ $row->catatanpeny ?? '-' }}</td>
                </tr>
                <tr>
                    <td>Ket FTS</td>
                    <td>{{ $row->ketfts ?? '-' }}</td>
                </tr>
                <!-- Tambahkan ketftc, ketftm, dll. -->
            </tbody>
        </table>

        {{-- ===== PELAKSANA SECTION ===== --}}
        <table style="margin-bottom: 15px;">
            <thead>
                <tr>
                    <th>Pelaksana MS (PIC Master)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pelaksanaMs as $ms)
                <tr>
                    <td>{{ $ms->nama ?? '-' }}
                        <!-- Sesuaikan field dari tb_picmaster -->
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <table style="margin-bottom: 15px;">
            <thead>
                <tr>
                    <th>Pelaksana RTU (Field Engineer)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pelaksanaRtu as $rtu)
                <tr>
                    <td>{{ $rtu->nama ?? '-' }}
                        <!-- Sesuaikan field dari tb_pelaksana_rtu -->
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{-- ===== FOOTER ===== --}}
        <table class="no-border">
            <tr>
                <td colspan="2" style="text-align: center; font-style: italic;">Generated on
                    {{ now()->format('d-m-Y H:i:s') }}</td>
            </tr>
        </table>
    </div>
    @endforeach
</body>

</html>
