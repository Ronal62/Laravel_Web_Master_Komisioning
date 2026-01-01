<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <title>Form Keypoint - {{ $row->nama_keypoint ?? 'Detail' }}</title>
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

    /* Text */
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

    /* Background */
    .bg-gray {
        background-color: #d1d5db;
    }

    .bg-gray-light {
        background-color: #f3f4f6;
    }

    /* Alignment */
    .align-middle {
        vertical-align: middle;
    }

    .align-bottom {
        vertical-align: bottom;
    }

    .align-top {
        vertical-align: top;
    }

    /* Layout - Full Width */
    .main-table {
        width: 100%;
        table-layout: fixed;
    }

    .col-left {
        width: 58%;
        padding-right: 2px;
        vertical-align: top;
    }

    .col-right {
        width: 42%;
        padding-left: 2px;
        vertical-align: top;
    }

    /* Data Table */
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

    /* Compact row */
    .compact-row td {
        height: 10px;
    }

    /* Signature */
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

    /* Header specific */
    .header-table {
        width: 100%;
        margin-bottom: 6px;
    }

    /* Device info */
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
                            FS.SCA.01.17
                        </td>
                        <td class="border-b" style="padding: 6px 8px; font-size: 12px;">
                            TGL : {{ $row->tgl_komisioning ?? date('d-m-Y') }}
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
        <u style="font-weight: bold; font-size: 14px; letter-spacing: 1px;">TES POINT TO POINT LBS</u><br>
        <span style="font-weight: bold; font-size: 11px;">FORM KOMISIONING KEYPOINT</span>
    </div>

    {{-- ===== DEVICE INFO ===== --}}
    <table class="device-info border" style="margin-bottom: 6px;">
        <tr>
            <td width="33%" class="border-r" style="padding: 6px;">
                <table style="width: 100%;">
                    <tr>
                        <td class="label" style="font-size: 10px; padding: 2px 0;">Nama LBS / REC.</td>
                        <td class="value border-dotted font-bold" style="font-size: 10px; padding: 2px 0;">:
                            {{ $row->nama_keypoint ?? '-' }}
                        </td>
                    </tr>
                    <tr>
                        <td class="label" style="font-size: 10px; padding: 2px 0;">Merk LBS / REC.</td>
                        <td class="value border-dotted font-bold" style="font-size: 10px; padding: 2px 0;">:
                            {{ $row->nama_merklbs ?? '-' }}
                        </td>
                    </tr>
                    <tr>
                        <td class="label" style="font-size: 10px; padding: 2px 0;">Protocol / Address</td>
                        <td class="value border-dotted font-bold" style="font-size: 10px; padding: 2px 0;">:
                            {{ $row->alamat_rtu ?? '-' }}
                        </td>
                    </tr>
                </table>
            </td>
            <td width="33%" class="border-r" style="padding: 6px;">
                <table style="width: 100%;">
                    <tr>
                        <td class="label" style="font-size: 10px; padding: 2px 0;">Modem</td>
                        <td class="value border-dotted font-bold" style="font-size: 10px; padding: 2px 0;">:
                            {{ $row->nama_modem ?? '-' }}
                        </td>
                    </tr>
                    <tr>
                        <td class="label" style="font-size: 10px; padding: 2px 0;">IP / No. Kartu</td>
                        <td class="value border-dotted font-bold" style="font-size: 10px; padding: 2px 0;">:
                            {{ $row->ip_rtu ?? '-' }}
                        </td>
                    </tr>
                    <tr>
                        <td class="label" style="font-size: 10px; padding: 2px 0;">Koordinat</td>
                        <td class="value border-dotted font-bold" style="font-size: 10px; padding: 2px 0;">:
                            {{ $row->koordinat ?? '-' }}
                        </td>
                    </tr>
                </table>
            </td>
            <td width="34%" style="padding: 6px;">
                <table style="width: 100%;">
                    <tr>
                        <td class="label" style="font-size: 10px; padding: 2px 0;">Gardu Induk / Sect</td>
                        <td class="value border-dotted font-bold" style="font-size: 10px; padding: 2px 0;">:
                            {{ $row->gardu_induk ?? '-' }} / {{ $row->sectoral ?? '-' }}
                        </td>
                    </tr>
                    <tr>
                        <td class="label" style="font-size: 10px; padding: 2px 0;">Penyulang</td>
                        <td class="value border-dotted font-bold" style="font-size: 10px; padding: 2px 0;">:
                            {{ $row->penyulang ?? '-' }}
                        </td>
                    </tr>
                    <tr>
                        <td class="label" style="font-size: 10px; padding: 2px 0;">Tanggal</td>
                        <td class="value border-dotted font-bold" style="font-size: 10px; padding: 2px 0;">:
                            {{ $row->tgl_komisioning ?? '-' }}
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
                            <th width="11%" style="font-size: 7.5px; padding: 3px;">ADD-MS</th>
                            <th width="11%" style="font-size: 7.5px; padding: 3px;">ADD-RTU</th>
                            <th width="8%" style="font-size: 7.5px; padding: 3px;">OBJ</th>
                            <th width="10%" style="font-size: 7.5px; padding: 3px;">STATUS</th>
                            <th width="10%" style="font-size: 7.5px; padding: 3px;">VALUE</th>
                            <th width="6%" style="font-size: 7.5px; padding: 3px;">OK</th>
                            <th width="6%" style="font-size: 7.5px; padding: 3px;">NOK</th>
                            <th width="6%" style="font-size: 7.5px; padding: 3px;">LOG</th>
                            <th width="6%" style="font-size: 7.5px; padding: 3px;">SLD</th>
                            <th width="26%" style="font-size: 7.5px; padding: 3px;">Ket</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($statusData as $index => $item)
                        {{-- Row 1 --}}
                        <tr>
                            <td style="height: 12px; font-size: 6px; padding: 2px;">{{ $item['row1']['ms'] }}</td>
                            <td style="height: 12px; font-size: 6px; padding: 2px;">{{ $item['row1']['rtu'] }}</td>
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
                            <td rowspan="24" class="text-left align-top" style="padding: 4px; font-size: 7px;">
                                {{ $row->ketfts ?? '' }}
                            </td>
                            @endif
                        </tr>
                        {{-- Row 2 --}}
                        <tr>
                            <td style="height: 12px; font-size: 6px; padding: 2px;">{{ $item['row2']['ms'] }}</td>
                            <td style="height: 12px; font-size: 6px; padding: 2px;">{{ $item['row2']['rtu'] }}</td>
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
                            <th width="11%" style="font-size: 7.5px; padding: 3px;">ADD-MS</th>
                            <th width="11%" style="font-size: 7.5px; padding: 3px;">ADD-RTU</th>
                            <th width="8%" style="font-size: 7.5px; padding: 3px;">OBJ</th>
                            <th width="10%" style="font-size: 7.5px; padding: 3px;">CTRL</th>
                            <th width="10%" style="font-size: 7.5px; padding: 3px;">VALUE</th>
                            <th width="6%" style="font-size: 7.5px; padding: 3px;">OK</th>
                            <th width="6%" style="font-size: 7.5px; padding: 3px;">NOK</th>
                            <th width="6%" style="font-size: 7.5px; padding: 3px;">LOG</th>
                            <th width="6%" style="font-size: 7.5px; padding: 3px;">SLD</th>
                            <th width="26%" style="font-size: 7.5px; padding: 3px;">Ket</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($controlData as $index => $item)
                        @if(isset($item['single']) && $item['single'])
                        {{-- Single Row (RR/Reset) --}}
                        <tr>
                            <td style="height: 12px; font-size: 7px; padding: 2px;">{{ $item['row1']['ms'] }}</td>
                            <td style="height: 12px; font-size: 7px; padding: 2px;">{{ $item['row1']['rtu'] }}</td>
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
                            <td rowspan="7" class="text-left align-top" style="padding: 4px; font-size: 7px;">
                                {{ $row->ketftc ?? '' }}
                            </td>
                            @endif
                        </tr>
                        @else
                        {{-- Row 1 --}}
                        <tr>
                            <td style="height: 12px; font-size: 7px; padding: 2px;">{{ $item['row1']['ms'] }}</td>
                            <td style="height: 12px; font-size: 7px; padding: 2px;">{{ $item['row1']['rtu'] }}</td>
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
                            <td rowspan="7" class="text-left align-top" style="padding: 4px; font-size: 7px;">
                                {{ $row->ketftc ?? '' }}
                            </td>
                            @endif
                        </tr>
                        {{-- Row 2 --}}
                        <tr>
                            <td style="height: 12px; font-size: 7px; padding: 2px;">{{ $item['row2']['ms'] ?? '' }}</td>
                            <td style="height: 12px; font-size: 7px; padding: 2px;">{{ $item['row2']['rtu'] ?? '' }}
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
                            <th width="11%" style="font-size: 7.5px; padding: 3px;">ADD-MS</th>
                            <th width="11%" style="font-size: 7.5px; padding: 3px;">ADD-RTU</th>
                            <th width="8%" style="font-size: 7.5px; padding: 3px;">OBJ</th>
                            <th width="10%" style="font-size: 7.5px; padding: 3px;">METER</th>
                            <th width="9%" style="font-size: 7.5px; padding: 3px;">FIELD</th>
                            <th width="9%" style="font-size: 7.5px; padding: 3px;">MS</th>
                            <th width="8%" style="font-size: 7.5px; padding: 3px;">SCALE</th>
                            <th width="8%" style="font-size: 7.5px; padding: 3px;">OK/NOK</th>
                            <th width="6%" style="font-size: 7.5px; padding: 3px;">SLD</th>
                            <th width="20%" style="font-size: 7.5px; padding: 3px;">Ket</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $meters = ['HZ', 'I AVG', 'IR', 'IS', 'IT', 'IN', 'IFR', 'IFS', 'IFT', 'IFN', 'PF', 'V AVG',
                        'V-R_IN', 'V-S_IN', 'V-T_IN', 'V-R_OUT', 'V-S_OUT', 'V-T_OUT'];
                        $pseudos = ['IFR', 'IFS', 'IFT', 'IFN'];
                        @endphp
                        @foreach($meters as $index => $meter)
                        <tr>
                            @if(in_array($meter, $pseudos))
                            <td class="bg-gray" style="height: 12px; font-size: 6px; padding: 2px;">Pseudo</td>
                            @else
                            <td style="height: 12px; font-size: 7px; padding: 2px;"></td>
                            @endif
                            <td style="height: 12px; font-size: 7px; padding: 2px;"></td>
                            <td style="height: 12px; font-size: 7px; padding: 2px;"></td>
                            <td class="font-bold" style="height: 12px; font-size: 8px; padding: 2px;">{{ $meter }}</td>
                            <td style="height: 12px; font-size: 7px; padding: 2px;"></td>
                            <td style="height: 12px; font-size: 7px; padding: 2px;"></td>
                            <td style="height: 12px; font-size: 7px; padding: 2px;"></td>
                            <td style="height: 12px; font-size: 7px; padding: 2px;"></td>
                            <td style="height: 12px; font-size: 7px; padding: 2px;"></td>
                            @if($index == 0)
                            <td rowspan="18" class="text-left align-top" style="padding: 4px; font-size: 7px;">
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

                {{-- HARDWARE TABLE --}}
                <table class="data-table" style="margin-bottom: 4px;">
                    <thead>
                        <tr>
                            <th width="32%" class="text-left" style="padding: 4px 6px; font-size: 8px;">Hardware</th>
                            <th width="18%" style="padding: 4px; font-size: 8px;">OK/NOK</th>
                            <th width="18%" style="padding: 4px; font-size: 8px;">Value</th>
                            <th width="32%" style="padding: 4px; font-size: 8px;">Ket</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $hardwareItems = [
                        ['name' => 'Batere', 'status' => $hardwareData[0]['status'] ?? '', 'value' =>
                        $hardwareData[0]['value'] ?? ''],
                        ['name' => 'PS 220', 'status' => $hardwareData[1]['status'] ?? '', 'value' =>
                        $hardwareData[1]['value'] ?? ''],
                        ['name' => 'Charger', 'status' => $hardwareData[2]['status'] ?? '', 'value' =>
                        $hardwareData[2]['value'] ?? ''],
                        ['name' => 'Limit Switch', 'status' => $hardwareData[3]['status'] ?? '', 'value' =>
                        $hardwareData[3]['value'] ?? ''],
                        ];
                        @endphp
                        @foreach($hardwareItems as $i => $hw)
                        <tr>
                            <td class="text-left" style="height: 14px; font-size: 7.5px; padding: 3px 6px;">
                                {{ $hw['name'] }}
                            </td>
                            <td style="height: 14px; font-size: 7.5px; padding: 3px;">{{ $hw['status'] }}</td>
                            <td style="height: 14px; font-size: 7.5px; padding: 3px;">{{ $hw['value'] }}</td>
                            @if($i == 0)
                            <td rowspan="4" class="text-left align-top" style="padding: 4px; font-size: 7px;">
                                {{ $row->kethard ?? '' }}
                            </td>
                            @endif
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                {{-- SYSTEM TABLE --}}
                <table class="data-table" style="margin-bottom: 4px;">
                    <thead>
                        <tr>
                            <th width="32%" class="text-left" style="padding: 4px 6px; font-size: 8px;">System</th>
                            <th width="18%" style="padding: 4px; font-size: 8px;">OK/NOK</th>
                            <th width="18%" style="padding: 4px; font-size: 8px;">Value</th>
                            <th width="32%" style="padding: 4px; font-size: 8px;">Ket</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $systemItems = [
                        ['name' => 'COMF', 'status' => $systemData[0]['status'] ?? '', 'value' =>
                        $systemData[0]['value'] ?? ''],
                        ['name' => 'LRUF', 'status' => $systemData[1]['status'] ?? '', 'value' =>
                        $systemData[1]['value'] ?? ''],
                        ['name' => 'SIGN S', 'status' => $systemData[2]['status'] ?? '', 'value' =>
                        $systemData[2]['value'] ?? ''],
                        ['name' => 'Limit Switch', 'status' => $systemData[3]['status'] ?? '', 'value' =>
                        $systemData[3]['value'] ?? ''],
                        ];
                        @endphp
                        @foreach($systemItems as $i => $sys)
                        <tr>
                            <td class="text-left" style="height: 14px; font-size: 7.5px; padding: 3px 6px;">
                                {{ $sys['name'] }}
                            </td>
                            <td style="height: 14px; font-size: 7.5px; padding: 3px;">{{ $sys['status'] }}</td>
                            <td style="height: 14px; font-size: 7.5px; padding: 3px;">{{ $sys['value'] }}</td>
                            @if($i == 0)
                            <td rowspan="4" class="text-left align-top" style="padding: 4px; font-size: 7px;">
                                {{ $row->ketsys ?? '' }}
                            </td>
                            @endif
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                {{-- RECLOSER TABLE --}}
                <table class="data-table" style="margin-bottom: 4px;">
                    <thead>
                        <tr>
                            <th width="25%" class="text-left" style="padding: 4px 6px; font-size: 8px;">RECLOSER</th>
                            <th width="25%" style="padding: 4px; font-size: 8px;">Value</th>
                            <th width="18%" style="padding: 4px; font-size: 8px;">OK/NOK</th>
                            <th width="32%" style="padding: 4px; font-size: 8px;">Ket</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $recloserItems = [
                        ['name' => 'AR', 'on' => $recloserData[0]['on'] ?? '', 'off' => $recloserData[0]['off'] ?? ''],
                        ['name' => 'CTRL AR', 'on' => $recloserData[1]['on'] ?? '', 'off' => $recloserData[1]['off'] ??
                        ''],
                        ];
                        @endphp
                        @foreach($recloserItems as $i => $rec)
                        <tr>
                            <td class="text-left font-bold" style="font-size: 8px; padding: 3px 6px;">{{ $rec['name'] }}
                            </td>
                            <td style="padding: 0;">
                                <div class="border-b text-center" style="padding: 3px; font-size: 7px;">On
                                </div>
                                <div class="text-center" style="padding: 3px; font-size: 7px;">Off
                                </div>
                            </td>
                            <td style="padding: 0;">
                                <div class="border-b text-center" style="padding: 3px; font-size: 7px;">
                                    {{ $rec['on'] }}
                                </div>
                                <div class="text-center" style="padding: 3px; font-size: 7px;">{{ $rec['off'] }}
                                </div>
                            </td>
                            @if($i == 0)
                            <td rowspan="2" class="text-left align-top" style="padding: 4px; font-size: 7px;">
                                {{ $row->ketre ?? '' }}
                            </td>
                            @endif
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                {{-- CATATAN --}}
                <table class="border" style="margin-bottom: 4px; width: 100%;">
                    <tr>
                        <td class="bg-gray font-bold border-b text-left" style="padding: 4px 6px; font-size: 9px;">
                            CATATAN</td>
                    </tr>
                    <tr>
                        <td class="align-top" style="height: 75px; padding: 6px; font-size: 8px; line-height: 1.3;">
                            {{ $row->catatankp ?? '' }}
                        </td>
                    </tr>
                </table>

                {{-- PELAKSANA --}}
                <table class="border" style="width: 100%;">
                    <tr>
                        <td class="bg-gray font-bold border-b text-left" style="padding: 4px 6px; font-size: 9px;">
                            PELAKSANA :</td>
                    </tr>
                    <tr>
                        <td style="padding: 0;">
                            <table style="width: 100%;">
                                <tr>
                                    {{-- Field Engineer --}}
                                    <td width="33%" class="border-r border-b"
                                        style="height: 50px; vertical-align: bottom; text-align: center; padding-bottom: 4px;">
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
                                            style="height: 30px; width: auto; margin-bottom: 2px;">
                                        @endif
                                        <div style="font-size: 7px; font-weight: bold;">
                                            {{ $pelaksanaRtu[0]->nama_pelrtu ?? 'Field Eng. 01' }}
                                        </div>
                                        @else
                                        <div
                                            style="border-bottom: 0.5pt solid black; width: 80%; margin: 0 auto 3px auto;">
                                        </div>
                                        <div style="font-size: 7px; font-weight: bold;">Field Eng. 01</div>
                                        @endif
                                    </td>
                                    {{-- MS Engineer --}}
                                    <td width="33%" class="border-r border-b"
                                        style="height: 50px; vertical-align: bottom; text-align: center; padding-bottom: 4px;">
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
                                            style="height: 30px; width: auto; margin-bottom: 2px;">
                                        @endif
                                        <div style="font-size: 7px; font-weight: bold;">
                                            {{ $pelaksanaMs[0]->nama_picmaster ?? 'MS Eng. 01' }}
                                        </div>
                                        @else
                                        <div
                                            style="border-bottom: 0.5pt solid black; width: 80%; margin: 0 auto 3px auto;">
                                        </div>
                                        <div style="font-size: 7px; font-weight: bold;">MS Eng. 01</div>
                                        @endif
                                    </td>
                                    {{-- Dispatcher --}}
                                    <td width="34%" class="border-b"
                                        style="height: 50px; vertical-align: bottom; text-align: center; padding-bottom: 4px;">
                                        <div
                                            style="border-bottom: 0.5pt solid black; width: 80%; margin: 0 auto 3px auto;">
                                        </div>
                                        <div style="font-size: 7px; font-weight: bold;">Dispatcher 01</div>
                                    </td>
                                </tr>
                                <tr>
                                    {{-- Field Engineer 2 --}}
                                    <td class="border-r"
                                        style="height: 50px; vertical-align: bottom; text-align: center; padding-bottom: 4px;">
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
                                            style="height: 30px; width: auto; margin-bottom: 2px;">
                                        @endif
                                        <div style="font-size: 7px; font-weight: bold;">
                                            {{ $pelaksanaRtu[1]->nama_pelrtu ?? 'Field Eng. 02' }}
                                        </div>
                                        @else
                                        <div
                                            style="border-bottom: 0.5pt solid black; width: 80%; margin: 0 auto 3px auto;">
                                        </div>
                                        <div style="font-size: 7px; font-weight: bold;">Field Eng. 02</div>
                                        @endif
                                    </td>
                                    {{-- MS Engineer 2 --}}
                                    <td class="border-r"
                                        style="height: 50px; vertical-align: bottom; text-align: center; padding-bottom: 4px;">
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
                                            style="height: 30px; width: auto; margin-bottom: 2px;">
                                        @endif
                                        <div style="font-size: 7px; font-weight: bold;">
                                            {{ $pelaksanaMs[1]->nama_picmaster ?? 'MS Eng. 02' }}
                                        </div>
                                        @else
                                        <div
                                            style="border-bottom: 0.5pt solid black; width: 80%; margin: 0 auto 3px auto;">
                                        </div>
                                        <div style="font-size: 7px; font-weight: bold;">MS Eng. 02</div>
                                        @endif
                                    </td>
                                    {{-- Dispatcher 2 --}}
                                    <td
                                        style="height: 50px; vertical-align: bottom; text-align: center; padding-bottom: 4px;">
                                        <div
                                            style="border-bottom: 0.5pt solid black; width: 80%; margin: 0 auto 3px auto;">
                                        </div>
                                        <div style="font-size: 7px; font-weight: bold;">Dispatcher 02</div>
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
    <div class="border text-center italic" style="font-size: 6px; padding: 3px; margin-top: 4px;">
        Apabila dokumen ini didownload / dicetak maka akan menjadi "DOKUMEN TIDAK TERKENDALI"
    </div>

</body>

</html>
