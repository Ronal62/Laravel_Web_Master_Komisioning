<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <title>Form Penyulangan - {{ $row->nama_peny ?? 'Detail' }}</title>
    <style>
    @page {
        margin: 5mm;
        size: A4 landscape;
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    html,
    body {
        width: 100%;
        height: 100%;
        font-family: Arial, sans-serif;
        font-size: 7px;
        line-height: 1.1;
    }

    .checkmark {
        font-family: DejaVu Sans, sans-serif;
    }

    .page-container {
        width: 100%;
        height: 100%;
        display: table;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        border-spacing: 0;
    }

    td,
    th {
        padding: 1px 2px;
        vertical-align: middle;
    }

    .border {
        border: 0.5pt solid black;
    }

    .border-b {
        border-bottom: 0.5pt solid black;
    }

    .border-r {
        border-right: 0.5pt solid black;
    }

    .border-l {
        border-left: 0.5pt solid black;
    }

    .border-t {
        border-top: 0.5pt solid black;
    }

    .border-dotted {
        border-bottom: 0.5pt dotted black;
    }

    .text-center {
        text-align: center;
    }

    .text-left {
        text-align: left;
    }

    .font-bold {
        font-weight: bold;
    }

    .italic {
        font-style: italic;
    }

    .bg-gray {
        background-color: #d1d5db;
    }

    .bg-gray-light {
        background-color: #f3f4f6;
    }

    .bg-yellow-light {
        background-color: #fef3c7;
    }

    .align-middle {
        vertical-align: middle;
    }

    .align-bottom {
        vertical-align: bottom;
    }

    .align-top {
        vertical-align: top;
    }

    .main-table {
        width: 100%;
        table-layout: fixed;
    }

    .col-left {
        width: 60%;
        padding-right: 2px;
        vertical-align: top;
    }

    .col-right {
        width: 40%;
        padding-left: 2px;
        vertical-align: top;
    }

    .data-table {
        width: 100%;
        table-layout: fixed;
    }

    .data-table th {
        background-color: #d1d5db;
        border: 0.5pt solid black;
        font-size: 6.5px;
        padding: 2px 1px;
        font-weight: bold;
    }

    .data-table td {
        border: 0.5pt solid black;
        font-size: 6.5px;
        padding: 1px 2px;
        text-align: center;
        height: 11px;
    }

    .data-table .text-left {
        text-align: left;
        padding-left: 3px;
    }

    .compact-row td {
        height: 10px;
    }

    .sig-cell {
        height: 40px;
        vertical-align: bottom;
        text-align: center;
        padding-bottom: 3px;
    }

    .sig-line {
        border-bottom: 0.5pt solid black;
        width: 80%;
        margin: 0 auto 2px auto;
    }

    .header-table {
        width: 100%;
        margin-bottom: 6px;
    }

    .device-info {
        width: 100%;
        margin-bottom: 4px;
    }

    .device-info td {
        font-size: 7.5px;
        padding: 2px 4px;
    }

    .device-info .label {
        width: 40%;
    }

    .device-info .value {
        width: 60%;
    }
    </style>
</head>

<body>
    {{-- ===== HEADER ===== --}}
    <table class="header-table border" style="margin-bottom: 8px;">
        <tr>
            {{-- Logo & Company --}}
            <td width="48%" class="border-r" style="padding: 0;">
                <table>
                    <tr>
                        <td width="18%" class="text-center align-middle" style="padding: 8px;">
                            @php
                            $logoPath = public_path('assets/img/pln.png');
                            $logoData = '';
                            if (file_exists($logoPath)) {
                            $logoData = base64_encode(file_get_contents($logoPath));
                            }
                            @endphp

                            @if($logoData)
                            <img src="data:image/png;base64,{{ $logoData }}" style="height: 70px; width: auto;"
                                alt="PLN">
                            @else
                            <span style="font-size: 12px; color: red;">Logo</span>
                            @endif
                        </td>
                        <td width="82%" class="border-l"
                            style="padding: 10px 12px; line-height: 1.4; font-family: 'Times New Roman', Times, serif;">
                            <b style="font-size: 16px;">PT PLN (PERSERO)</b><br>
                            <b style="font-size: 16px;">DISTRIBUSI JAWA TIMUR</b><br>
                            <span style="font-size: 12px;">JL. EMBONG TRENGGULI NO. 19 - 21</span><br>
                            <span style="font-size: 12px;">SURABAYA | TLP: (031) 53406531</span>
                        </td>
                    </tr>
                </table>
            </td>

            {{-- Form Standard --}}
            <td width="17%" class="align-middle text-center border-r" style="padding: 12px;">
                <b style="font-size: 18px;">FORM<br>STANDART</b>
            </td>

            {{-- Document Info --}}
            <td width="35%" style="padding: 0;">
                <table>
                    <tr>
                        <td class="bg-gray font-bold text-center border-b border-r" width="45%"
                            style="font-size: 12px; padding: 6px;">
                            NO. DOKUMEN
                        </td>
                        <td class="border-b" style="padding: 6px 8px; font-size: 12px;">HAL : 1 - 3</td>
                    </tr>
                    <tr>
                        <td rowspan="2" class="font-bold text-center border-r" style="font-size: 20px; padding: 10px;">
                            FS.SCA.01.18
                        </td>
                        <td class="border-b" style="padding: 6px 8px; font-size: 12px;">
                            TGL : {{ $row->tgl_kom ?? date('d-m-Y') }}
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 6px 8px; font-size: 12px;">REV : 0</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    {{-- ===== TITLE ===== --}}
    <div class="text-center" style="margin-bottom: 8px;">
        <u style="font-weight: bold; font-size: 14px; letter-spacing: 1px;">TES POINT TO POINT PENYULANG</u><br>
        <span style="font-weight: bold; font-size: 11px;">FORM KOMISIONING PENYULANGAN</span>
    </div>

    {{-- ===== DEVICE INFO ===== --}}
    <table class="device-info border" style="margin-bottom: 6px;">
        <tr>
            <td width="33%" class="border-r" style="padding: 6px;">
                <table style="width: 100%;">
                    <tr>
                        <td class="label" style="font-size: 10px; padding: 2px 0;">Nama Penyulang</td>
                        <td class="value border-dotted font-bold" style="font-size: 10px; padding: 2px 0;">:
                            {{ $row->nama_peny ?? '-' }}
                        </td>
                    </tr>
                    <tr>
                        <td class="label" style="font-size: 10px; padding: 2px 0;">Gardu Induk</td>
                        <td class="value border-dotted font-bold" style="font-size: 10px; padding: 2px 0;">:
                            {{ $row->id_gi ?? '-' }}
                        </td>
                    </tr>
                    <tr>
                        <td class="label" style="font-size: 10px; padding: 2px 0;">RTU GI</td>
                        <td class="value border-dotted font-bold" style="font-size: 10px; padding: 2px 0;">:
                            {{ $row->nama_rtugi ?? $row->id_rtugi ?? '-' }}
                        </td>
                    </tr>
                </table>
            </td>
            <td width="33%" class="border-r" style="padding: 6px;">
                <table style="width: 100%;">
                    <tr>
                        <td class="label" style="font-size: 10px; padding: 2px 0;">Protocol / Address</td>
                        <td class="value border-dotted font-bold" style="font-size: 10px; padding: 2px 0;">:
                            {{ $row->rtu_addrs ?? '-' }}
                        </td>
                    </tr>
                    <tr>
                        <td class="label" style="font-size: 10px; padding: 2px 0;">Media Komunikasi</td>
                        <td class="value border-dotted font-bold" style="font-size: 10px; padding: 2px 0;">:
                            {{ $row->nama_medkom ?? '-' }}
                        </td>
                    </tr>
                    <tr>
                        <td class="label" style="font-size: 10px; padding: 2px 0;">Jenis Komisioning</td>
                        <td class="value border-dotted font-bold" style="font-size: 10px; padding: 2px 0;">:
                            {{ $row->jenis_komkp ?? '-' }}
                        </td>
                    </tr>
                </table>
            </td>
            <td width="34%" style="padding: 6px;">
                <table style="width: 100%;">
                    <tr>
                        <td class="label" style="font-size: 10px; padding: 2px 0;">Tanggal Komisioning</td>
                        <td class="value border-dotted font-bold" style="font-size: 10px; padding: 2px 0;">:
                            {{ $row->tgl_kom ?? '-' }}
                        </td>
                    </tr>
                    <tr>
                        <td class="label" style="font-size: 10px; padding: 2px 0;">Master Station</td>
                        <td class="value border-dotted font-bold" style="font-size: 10px; padding: 2px 0;">:
                            {{ $row->nama_user ?? '-' }}
                        </td>
                    </tr>
                    <tr>
                        <td class="label" style="font-size: 10px; padding: 2px 0;">Last Update</td>
                        <td class="value border-dotted font-bold" style="font-size: 10px; padding: 2px 0;">:
                            {{ $row->lastupdate ?? '-' }}
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    {{-- ===== MAIN CONTENT ===== --}}
    <table class="main-table">
        <tr>
            {{-- ========== LEFT COLUMN ========== --}}
            <td class="col-left">

                {{-- STATUS TABLE --}}
                <table class="data-table" style="margin-bottom: 4px;">
                    <thead>
                        <tr>
                            <th width="12%" style="font-size: 7.5px; padding: 3px;">ADDRESS</th>
                            <th width="8%" style="font-size: 7.5px; padding: 3px;">OBJ</th>
                            <th width="10%" style="font-size: 7.5px; padding: 3px;">STATUS</th>
                            <th width="10%" style="font-size: 7.5px; padding: 3px;">VALUE</th>
                            <th width="6%" style="font-size: 7.5px; padding: 3px;">OK</th>
                            <th width="6%" style="font-size: 7.5px; padding: 3px;">NOK</th>
                            <th width="6%" style="font-size: 7.5px; padding: 3px;">LOG</th>
                            <th width="6%" style="font-size: 7.5px; padding: 3px;">SLD</th>
                            <th width="36%" style="font-size: 7.5px; padding: 3px;">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($statusData as $index => $item)
                        {{-- Row 1 --}}
                        <tr>
                            <td style="height: 12px; font-size: 6px; padding: 2px;">{{ $item['row1']['address'] }}</td>
                            <td style="height: 12px; font-size: 6px; padding: 2px;">{{ $item['row1']['obj'] }}</td>
                            <td rowspan="2" class="font-bold" style="font-size: 8px; padding: 2px;">{{ $item['name'] }}
                            </td>
                            <td style="height: 12px; font-size: 7px; padding: 2px;">{{ $item['row1']['label'] }}</td>
                            <td style="height: 12px; padding: 2px;">
                                @if(in_array(1, $item['row1']['checks'] ?? []))
                                <span
                                    style="font-family: DejaVu Sans; font-size: 10px; color: #16a34a; font-weight: bold;">&#10004;</span>
                                @endif
                            </td>
                            <td style="height: 12px; padding: 2px;">
                                @if(in_array(2, $item['row1']['checks'] ?? []))
                                <span
                                    style="font-family: DejaVu Sans; font-size: 10px; color: #dc2626; font-weight: bold;">&#10004;</span>
                                @endif
                            </td>
                            <td style="height: 12px; padding: 2px;">
                                @if(in_array(3, $item['row1']['checks'] ?? []))
                                <span
                                    style="font-family: DejaVu Sans; font-size: 10px; color: #2563eb; font-weight: bold;">&#10004;</span>
                                @endif
                            </td>
                            <td style="height: 12px; padding: 2px;">
                                @if(in_array(4, $item['row1']['checks'] ?? []))
                                <span
                                    style="font-family: DejaVu Sans; font-size: 10px; color: #ea580c; font-weight: bold;">&#10004;</span>
                                @endif
                            </td>
                            @if($index == 0)
                            <td rowspan="{{ count($statusData) * 2 }}" class="text-left align-top"
                                style="padding: 4px; font-size: 7px;">
                                {{ $row->ketfts ?? '' }}
                            </td>
                            @endif
                        </tr>
                        {{-- Row 2 --}}
                        <tr>
                            <td style="height: 12px; font-size: 6px; padding: 2px;">{{ $item['row2']['address'] }}</td>
                            <td style="height: 12px; font-size: 6px; padding: 2px;">{{ $item['row2']['obj'] }}</td>
                            <td style="height: 12px; font-size: 7px; padding: 2px;">{{ $item['row2']['label'] }}</td>
                            <td style="height: 12px; padding: 2px;">
                                @if(in_array(1, $item['row2']['checks'] ?? []))
                                <span
                                    style="font-family: DejaVu Sans; font-size: 10px; color: #16a34a; font-weight: bold;">&#10004;</span>
                                @endif
                            </td>
                            <td style="height: 12px; padding: 2px;">
                                @if(in_array(2, $item['row2']['checks'] ?? []))
                                <span
                                    style="font-family: DejaVu Sans; font-size: 10px; color: #dc2626; font-weight: bold;">&#10004;</span>
                                @endif
                            </td>
                            <td style="height: 12px; padding: 2px;">
                                @if(in_array(3, $item['row2']['checks'] ?? []))
                                <span
                                    style="font-family: DejaVu Sans; font-size: 10px; color: #2563eb; font-weight: bold;">&#10004;</span>
                                @endif
                            </td>
                            <td style="height: 12px; padding: 2px;">
                                @if(in_array(4, $item['row2']['checks'] ?? []))
                                <span
                                    style="font-family: DejaVu Sans; font-size: 10px; color: #ea580c; font-weight: bold;">&#10004;</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                {{-- CONTROL TABLE --}}
                <table class="data-table" style="margin-bottom: 4px;">
                    <thead>
                        <tr>
                            <th width="12%" style="font-size: 7.5px; padding: 3px;">ADDRESS</th>
                            <th width="8%" style="font-size: 7.5px; padding: 3px;">OBJ</th>
                            <th width="10%" style="font-size: 7.5px; padding: 3px;">CTRL</th>
                            <th width="10%" style="font-size: 7.5px; padding: 3px;">VALUE</th>
                            <th width="6%" style="font-size: 7.5px; padding: 3px;">OK</th>
                            <th width="6%" style="font-size: 7.5px; padding: 3px;">NOK</th>
                            <th width="6%" style="font-size: 7.5px; padding: 3px;">LOG</th>
                            <th width="6%" style="font-size: 7.5px; padding: 3px;">SLD</th>
                            <th width="36%" style="font-size: 7.5px; padding: 3px;">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $controlRowCount = 0; @endphp
                        @foreach($controlData as $index => $item)
                        @if(isset($item['single']) && $item['single'])
                        @php $controlRowCount += 1; @endphp
                        @else
                        @php $controlRowCount += 2; @endphp
                        @endif
                        @endforeach

                        @foreach($controlData as $index => $item)
                        @if(isset($item['single']) && $item['single'])
                        {{-- Single Row (Reset) --}}
                        <tr>
                            <td style="height: 12px; font-size: 7px; padding: 2px;">{{ $item['row1']['address'] }}</td>
                            <td style="height: 12px; font-size: 7px; padding: 2px;">{{ $item['row1']['obj'] }}</td>
                            <td class="font-bold" style="font-size: 8px; padding: 2px;">{{ $item['name'] }}</td>
                            <td style="height: 12px; font-size: 7px; padding: 2px;">{{ $item['row1']['label'] }}</td>
                            <td style="height: 12px; padding: 2px;">
                                @if(in_array(1, $item['row1']['checks'] ?? []))
                                <span
                                    style="font-family: DejaVu Sans; font-size: 10px; color: #16a34a; font-weight: bold;">&#10004;</span>
                                @endif
                            </td>
                            <td style="height: 12px; padding: 2px;">
                                @if(in_array(2, $item['row1']['checks'] ?? []))
                                <span
                                    style="font-family: DejaVu Sans; font-size: 10px; color: #dc2626; font-weight: bold;">&#10004;</span>
                                @endif
                            </td>
                            <td style="height: 12px; padding: 2px;">
                                @if(in_array(3, $item['row1']['checks'] ?? []))
                                <span
                                    style="font-family: DejaVu Sans; font-size: 10px; color: #2563eb; font-weight: bold;">&#10004;</span>
                                @endif
                            </td>
                            <td style="height: 12px; padding: 2px;">
                                @if(in_array(4, $item['row1']['checks'] ?? []))
                                <span
                                    style="font-family: DejaVu Sans; font-size: 10px; color: #ea580c; font-weight: bold;">&#10004;</span>
                                @endif
                            </td>
                            @if($index == 0)
                            <td rowspan="{{ $controlRowCount }}" class="text-left align-top"
                                style="padding: 4px; font-size: 7px;">
                                {{ $row->ketftc ?? '' }}
                            </td>
                            @endif
                        </tr>
                        @else
                        {{-- Row 1 --}}
                        <tr>
                            <td style="height: 12px; font-size: 7px; padding: 2px;">{{ $item['row1']['address'] }}</td>
                            <td style="height: 12px; font-size: 7px; padding: 2px;">{{ $item['row1']['obj'] }}</td>
                            <td rowspan="2" class="font-bold" style="font-size: 8px; padding: 2px;">{{ $item['name'] }}
                            </td>
                            <td style="height: 12px; font-size: 7px; padding: 2px;">{{ $item['row1']['label'] }}</td>
                            <td style="height: 12px; padding: 2px;">
                                @if(in_array(1, $item['row1']['checks'] ?? []))
                                <span
                                    style="font-family: DejaVu Sans; font-size: 10px; color: #16a34a; font-weight: bold;">&#10004;</span>
                                @endif
                            </td>
                            <td style="height: 12px; padding: 2px;">
                                @if(in_array(2, $item['row1']['checks'] ?? []))
                                <span
                                    style="font-family: DejaVu Sans; font-size: 10px; color: #dc2626; font-weight: bold;">&#10004;</span>
                                @endif
                            </td>
                            <td style="height: 12px; padding: 2px;">
                                @if(in_array(3, $item['row1']['checks'] ?? []))
                                <span
                                    style="font-family: DejaVu Sans; font-size: 10px; color: #2563eb; font-weight: bold;">&#10004;</span>
                                @endif
                            </td>
                            <td style="height: 12px; padding: 2px;">
                                @if(in_array(4, $item['row1']['checks'] ?? []))
                                <span
                                    style="font-family: DejaVu Sans; font-size: 10px; color: #ea580c; font-weight: bold;">&#10004;</span>
                                @endif
                            </td>
                            @if($index == 0)
                            <td rowspan="{{ $controlRowCount }}" class="text-left align-top"
                                style="padding: 4px; font-size: 7px;">
                                {{ $row->ketftc ?? '' }}
                            </td>
                            @endif
                        </tr>
                        {{-- Row 2 --}}
                        <tr>
                            <td style="height: 12px; font-size: 7px; padding: 2px;">{{ $item['row2']['address'] ?? '' }}
                            </td>
                            <td style="height: 12px; font-size: 7px; padding: 2px;">{{ $item['row2']['obj'] ?? '' }}
                            </td>
                            <td style="height: 12px; font-size: 7px; padding: 2px;">{{ $item['row2']['label'] ?? '' }}
                            </td>
                            <td style="height: 12px; padding: 2px;">
                                @if(in_array(1, $item['row2']['checks'] ?? []))
                                <span
                                    style="font-family: DejaVu Sans; font-size: 10px; color: #16a34a; font-weight: bold;">&#10004;</span>
                                @endif
                            </td>
                            <td style="height: 12px; padding: 2px;">
                                @if(in_array(2, $item['row2']['checks'] ?? []))
                                <span
                                    style="font-family: DejaVu Sans; font-size: 10px; color: #dc2626; font-weight: bold;">&#10004;</span>
                                @endif
                            </td>
                            <td style="height: 12px; padding: 2px;">
                                @if(in_array(3, $item['row2']['checks'] ?? []))
                                <span
                                    style="font-family: DejaVu Sans; font-size: 10px; color: #2563eb; font-weight: bold;">&#10004;</span>
                                @endif
                            </td>
                            <td style="height: 12px; padding: 2px;">
                                @if(in_array(4, $item['row2']['checks'] ?? []))
                                <span
                                    style="font-family: DejaVu Sans; font-size: 10px; color: #ea580c; font-weight: bold;">&#10004;</span>
                                @endif
                            </td>
                        </tr>
                        @endif
                        @endforeach
                    </tbody>
                </table>

                {{-- METERING TABLE --}}
                <table class="data-table">
                    <thead>
                        <tr>
                            <th width="12%" style="font-size: 7.5px; padding: 3px;">ADDRESS</th>
                            <th width="8%" style="font-size: 7.5px; padding: 3px;">OBJ</th>
                            <th width="10%" style="font-size: 7.5px; padding: 3px;">METER</th>
                            <th width="9%" style="font-size: 7.5px; padding: 3px;">RTU</th>
                            <th width="9%" style="font-size: 7.5px; padding: 3px;">MS</th>
                            <th width="8%" style="font-size: 7.5px; padding: 3px;">SCALE</th>
                            <th width="8%" style="font-size: 7.5px; padding: 3px;">OK/NOK</th>
                            <th width="6%" style="font-size: 7.5px; padding: 3px;">SLD</th>
                            <th width="30%" style="font-size: 7.5px; padding: 3px;">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($meteringData as $index => $meter)
                        @php
                        $checks = $meter['checks'] ?? [];
                        $hasOk = in_array(1, $checks);
                        $hasNok = in_array(2, $checks);
                        $hasSld = in_array(5, $checks);
                        @endphp
                        <tr class="{{ $meter['isPseudo'] ? 'bg-yellow-light' : '' }}">
                            {{-- ADDRESS Column --}}
                            @if($meter['isPseudo'] ?? false)
                            <td class="bg-gray" style="height: 12px; font-size: 6px; padding: 2px;">Pseudo</td>
                            @else
                            <td style="height: 12px; font-size: 7px; padding: 2px;">{{ $meter['address'] ?? '' }}</td>
                            @endif

                            {{-- OBJ Column --}}
                            <td style="height: 12px; font-size: 7px; padding: 2px;">{{ $meter['obj'] ?? '' }}</td>

                            {{-- METER Name Column --}}
                            <td class="font-bold" style="height: 12px; font-size: 8px; padding: 2px;">
                                {{ $meter['name'] ?? '' }}
                            </td>

                            {{-- RTU Column --}}
                            <td style="height: 12px; font-size: 7px; padding: 2px;">{{ $meter['rtu'] ?? '' }}</td>

                            {{-- MS Column --}}
                            <td style="height: 12px; font-size: 7px; padding: 2px;">{{ $meter['ms'] ?? '' }}</td>

                            {{-- SCALE Column --}}
                            <td style="height: 12px; font-size: 7px; padding: 2px;">{{ $meter['scale'] ?? '' }}</td>

                            {{-- OK/NOK Column --}}
                            <td style="height: 12px; padding: 2px; text-align: center;">
                                @if($hasOk)
                                <span style="font-size: 8px; color: #16a34a; font-weight: bold;">OK</span>
                                @elseif($hasNok)
                                <span style="font-size: 8px; color: #dc2626; font-weight: bold;">NOK</span>
                                @else
                                <span style="font-size: 8px; color: #9ca3af;">-</span>
                                @endif
                            </td>

                            {{-- SLD Column --}}
                            <td style="height: 12px; padding: 2px; text-align: center;">
                                @if($hasSld)
                                <span
                                    style="font-family: DejaVu Sans; font-size: 10px; color: #ea580c; font-weight: bold;">&#10004;</span>
                                @else
                                <span style="font-size: 8px; color: #9ca3af;">-</span>
                                @endif
                            </td>

                            {{-- Ket Column --}}
                            @if($index === 0)
                            <td rowspan="{{ count($meteringData) }}" class="text-left align-top"
                                style="padding: 4px; font-size: 7px; vertical-align: top;">
                                {{ $row->ketftm ?? '' }}
                            </td>
                            @endif
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </td>

            {{-- ========== RIGHT COLUMN ========== --}}
            <td class="col-right">

                {{-- FORM DATA INFO --}}
                <table class="border" style="margin-bottom: 4px; width: 100%;">
                    <tr>
                        <td class="bg-gray font-bold border-b text-left" style="padding: 4px 6px; font-size: 9px;">
                            KETERANGAN FORM DATA
                        </td>
                    </tr>
                    <tr>
                        <td class="align-top" style="height: 60px; padding: 6px; font-size: 8px; line-height: 1.3;">
                            {{ $row->ketfd ?? '' }}
                        </td>
                    </tr>
                </table>

                {{-- PIC KOMISIONING --}}
                <table class="border" style="margin-bottom: 4px; width: 100%;">
                    <tr>
                        <td class="bg-gray font-bold border-b text-left" style="padding: 4px 6px; font-size: 9px;">
                            PIC KOMISIONING
                        </td>
                    </tr>
                    <tr>
                        <td class="align-top" style="height: 60px; padding: 6px; font-size: 8px; line-height: 1.3;">
                            {{ $row->ketpk ?? '' }}
                        </td>
                    </tr>
                </table>

                {{-- CATATAN --}}
                <table class="border" style="margin-bottom: 4px; width: 100%;">
                    <tr>
                        <td class="bg-gray font-bold border-b text-left" style="padding: 4px 6px; font-size: 9px;">
                            CATATAN
                        </td>
                    </tr>
                    <tr>
                        <td class="align-top" style="height: 80px; padding: 6px; font-size: 8px; line-height: 1.3;">
                            {{ $row->catatanpeny ?? '' }}
                        </td>
                    </tr>
                </table>

                {{-- PELAKSANA --}}
                <table class="border" style="width: 100%;">
                    <tr>
                        <td class="bg-gray font-bold border-b text-left" style="padding: 8px 10px; font-size: 11px;">
                            PELAKSANA :
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 0;">
                            <table style="width: 100%;">
                                <tr>
                                    {{-- Field Engineer --}}
                                    <td width="33%" class="border-r border-b"
                                        style="height: 100px; vertical-align: bottom; text-align: center; padding-bottom: 12px;">
                                        @if(isset($pelaksanaRtu[0]))
                                        @php
                                        $ttdPath = public_path('storage/' . $pelaksanaRtu[0]->foto_ttd);
                                        $ttdData = '';
                                        if (file_exists($ttdPath)) {
                                        $ttdData = base64_encode(file_get_contents($ttdPath));
                                        }
                                        @endphp
                                        @if($ttdData)
                                        <img src="data:image/png;base64,{{ $ttdData }}"
                                            style="height: 50px; width: auto; margin-bottom: 8px;">
                                        @endif
                                        <div style="font-size: 9px; font-weight: bold;">
                                            {{ $pelaksanaRtu[0]->nama_pelrtu ?? 'Field Eng. 01' }}
                                        </div>
                                        @else
                                        <div
                                            style="border-bottom: 1.5pt solid black; width: 80%; margin: 0 auto 8px auto;">
                                        </div>
                                        <div style="font-size: 9px; font-weight: bold;">Field Eng. 01</div>
                                        @endif
                                    </td>

                                    {{-- MS Engineer --}}
                                    <td width="33%" class="border-r border-b"
                                        style="height: 100px; vertical-align: bottom; text-align: center; padding-bottom: 12px;">
                                        @if(isset($pelaksanaMs[0]))
                                        @php
                                        $ttdPath = public_path('storage/' . $pelaksanaMs[0]->foto_ttd);
                                        $ttdData = '';
                                        if (file_exists($ttdPath)) {
                                        $ttdData = base64_encode(file_get_contents($ttdPath));
                                        }
                                        @endphp
                                        @if($ttdData)
                                        <img src="data:image/png;base64,{{ $ttdData }}"
                                            style="height: 50px; width: auto; margin-bottom: 8px;">
                                        @endif
                                        <div style="font-size: 9px; font-weight: bold;">
                                            {{ $pelaksanaMs[0]->nama_picmaster ?? 'MS Eng. 01' }}
                                        </div>
                                        @else
                                        <div
                                            style="border-bottom: 1.5pt solid black; width: 80%; margin: 0 auto 8px auto;">
                                        </div>
                                        <div style="font-size: 9px; font-weight: bold;">MS Eng. 01</div>
                                        @endif
                                    </td>

                                    {{-- Dispatcher --}}
                                    <td width="34%" class="border-b"
                                        style="height: 100px; vertical-align: bottom; text-align: center; padding-bottom: 12px;">
                                        <div
                                            style="border-bottom: 1.5pt solid black; width: 80%; margin: 0 auto 8px auto;">
                                        </div>
                                        <div style="font-size: 9px; font-weight: bold;">Dispatcher 01</div>
                                    </td>
                                </tr>
                                <tr>
                                    {{-- Field Engineer 2 --}}
                                    <td class="border-r"
                                        style="height: 100px; vertical-align: bottom; text-align: center; padding-bottom: 12px;">
                                        @if(isset($pelaksanaRtu[1]))
                                        @php
                                        $ttdPath = public_path('storage/' . $pelaksanaRtu[1]->foto_ttd);
                                        $ttdData = '';
                                        if (file_exists($ttdPath)) {
                                        $ttdData = base64_encode(file_get_contents($ttdPath));
                                        }
                                        @endphp
                                        @if($ttdData)
                                        <img src="data:image/png;base64,{{ $ttdData }}"
                                            style="height: 50px; width: auto; margin-bottom: 8px;">
                                        @endif
                                        <div style="font-size: 9px; font-weight: bold;">
                                            {{ $pelaksanaRtu[1]->nama_pelrtu ?? 'Field Eng. 02' }}
                                        </div>
                                        @else
                                        <div
                                            style="border-bottom: 1.5pt solid black; width: 80%; margin: 0 auto 8px auto;">
                                        </div>
                                        <div style="font-size: 9px; font-weight: bold;">Field Eng. 02</div>
                                        @endif
                                    </td>

                                    {{-- MS Engineer 2 --}}
                                    <td class="border-r"
                                        style="height: 100px; vertical-align: bottom; text-align: center; padding-bottom: 12px;">
                                        @if(isset($pelaksanaMs[1]))
                                        @php
                                        $ttdPath = public_path('storage/' . $pelaksanaMs[1]->foto_ttd);
                                        $ttdData = '';
                                        if (file_exists($ttdPath)) {
                                        $ttdData = base64_encode(file_get_contents($ttdPath));
                                        }
                                        @endphp
                                        @if($ttdData)
                                        <img src="data:image/png;base64,{{ $ttdData }}"
                                            style="height: 50px; width: auto; margin-bottom: 8px;">
                                        @endif
                                        <div style="font-size: 9px; font-weight: bold;">
                                            {{ $pelaksanaMs[1]->nama_picmaster ?? 'MS Eng. 02' }}
                                        </div>
                                        @else
                                        <div
                                            style="border-bottom: 1.5pt solid black; width: 80%; margin: 0 auto 8px auto;">
                                        </div>
                                        <div style="font-size: 9px; font-weight: bold;">MS Eng. 02</div>
                                        @endif
                                    </td>

                                    {{-- Dispatcher 2 --}}
                                    <td
                                        style="height: 100px; vertical-align: bottom; text-align: center; padding-bottom: 12px;">
                                        <div
                                            style="border-bottom: 1.5pt solid black; width: 80%; margin: 0 auto 8px auto;">
                                        </div>
                                        <div style="font-size: 9px; font-weight: bold;">Dispatcher 02</div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    {{-- ===== FOOTER ===== --}}
    <div class="border text-center italic" style="font-size: 8px; padding: 5px; margin-top: 6px;">
        Apabila dokumen ini didownload / dicetak maka akan menjadi "DOKUMEN TIDAK TERKENDALI"
    </div>

</body>

</html>
