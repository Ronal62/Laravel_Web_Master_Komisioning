<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <title>Form Keypoint - {{ $row->nama_keypoint ?? 'Detail' }}</title>
    <style>
    @page {
        margin: 3mm;
        size: A4 landscape;
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: Arial, sans-serif;
        font-size: 7px;
        line-height: 1.1;
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

    /* Borders */
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
        background-color: #e5e7eb;
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

    /* Layout */
    .col-left {
        width: 57%;
        padding-right: 3px;
        vertical-align: top;
    }

    .col-right {
        width: 43%;
        padding-left: 3px;
        vertical-align: top;
    }

    /* Data Table */
    .data-table th {
        background-color: #e5e7eb;
        border: 0.5pt solid black;
        font-size: 6px;
        padding: 1px;
        font-weight: bold;
    }

    .data-table td {
        border: 0.5pt solid black;
        font-size: 6px;
        padding: 0px 1px;
        text-align: center;
        height: 10px;
    }

    .data-table .text-left {
        text-align: left;
        padding-left: 2px;
    }

    /* Header */
    .header-table td {
        padding: 2px;
    }

    .header-logo {
        width: 40px;
        height: auto;
    }

    /* Compact row */
    .compact-row td {
        height: 9px;
    }

    /* Signature */
    .sig-cell {
        height: 35px;
        vertical-align: bottom;
        text-align: center;
        padding-bottom: 2px;
    }

    .sig-line {
        border-bottom: 0.5pt solid black;
        width: 75%;
        margin: 0 auto 1px auto;
    }
    </style>
</head>

<body>
    {{-- ===== HEADER ===== --}}
    <table class="border" style="margin-bottom: 3px;">
        <tr>
            {{-- Logo & Company --}}
            <td width="48%" class="border-r" style="padding: 0;">
                <table>
                    <tr>
                        <td width="18%" class="text-center align-middle" style="padding: 3px;">
                            <img src="{{ public_path('assets/img/logo.png') }}" class="header-logo" alt="PLN">
                        </td>
                        <td width="82%" class="border-l" style="padding: 3px; line-height: 1.2;">
                            <b style="font-size: 9px;">PT PLN (PERSERO)</b><br>
                            <b style="font-size: 9px;">DISTRIBUSI JAWA TIMUR</b><br>
                            <span style="font-size: 7px;">JL. EMBONG TRENGGULI NO. 19 - 21</span><br>
                            <span style="font-size: 7px;">SURABAYA | TLP: (031) 53406531</span>
                        </td>
                    </tr>
                </table>
            </td>

            {{-- Form Standard --}}
            <td width="17%" class="align-middle text-center border-r">
                <b style="font-size: 9px;">FORM<br>STANDART</b>
            </td>

            {{-- Document Info --}}
            <td width="35%" style="padding: 0;">
                <table>
                    <tr>
                        <td class="bg-gray font-bold text-center border-b border-r" width="45%" style="font-size: 7px;">
                            NO. DOKUMEN</td>
                        <td class="border-b" style="padding-left: 3px; font-size: 7px;">HAL : 1 - 3</td>
                    </tr>
                    <tr>
                        <td rowspan="2" class="font-bold text-center border-r" style="font-size: 11px;">FS.SCA.01.17
                        </td>
                        <td class="border-b" style="padding-left: 3px; font-size: 7px;">TGL :
                            {{ $row->tgl_komisioning ?? date('d-m-Y') }}</td>
                    </tr>
                    <tr>
                        <td style="padding-left: 3px; font-size: 7px;">REV : 0</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    {{-- ===== TITLE ===== --}}
    <div class="text-center" style="margin-bottom: 4px;">
        <u style="font-weight: bold; font-size: 10px; letter-spacing: 0.5px;">TES POINT TO POINT LBS</u><br>
        <span style="font-weight: bold; font-size: 8px;">FORM KOMISIONING KEYPOINT</span>
    </div>

    {{-- ===== DEVICE INFO ===== --}}
    <table class="border" style="margin-bottom: 4px;">
        <tr>
            <td width="33%" class="border-r" style="padding: 3px;">
                <table>
                    <tr>
                        <td width="38%" style="font-size: 7px;">Nama LBS / REC.</td>
                        <td class="border-dotted font-bold" style="font-size: 7px;">: {{ $row->nama_keypoint ?? '-' }}
                        </td>
                    </tr>
                    <tr>
                        <td style="font-size: 7px;">Merk LBS / REC.</td>
                        <td class="border-dotted font-bold" style="font-size: 7px;">: {{ $row->nama_merklbs ?? '-' }}
                        </td>
                    </tr>
                    <tr>
                        <td style="font-size: 7px;">Protocol / Address</td>
                        <td class="border-dotted font-bold" style="font-size: 7px;">: {{ $row->alamat_rtu ?? '-' }}</td>
                    </tr>
                </table>
            </td>
            <td width="33%" class="border-r" style="padding: 3px;">
                <table>
                    <tr>
                        <td width="35%" style="font-size: 7px;">Modem</td>
                        <td class="border-dotted font-bold" style="font-size: 7px;">: {{ $row->nama_modem ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td style="font-size: 7px;">IP / No. Kartu</td>
                        <td class="border-dotted font-bold" style="font-size: 7px;">: {{ $row->ip_rtu ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td style="font-size: 7px;">Koordinat</td>
                        <td class="border-dotted font-bold" style="font-size: 7px;">: {{ $row->koordinat ?? '-' }}</td>
                    </tr>
                </table>
            </td>
            <td width="34%" style="padding: 3px;">
                <table>
                    <tr>
                        <td width="38%" style="font-size: 7px;">Gardu Induk / Sect</td>
                        <td class="border-dotted font-bold" style="font-size: 7px;">: {{ $row->id_gi ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td style="font-size: 7px;">Penyulang</td>
                        <td class="border-dotted font-bold" style="font-size: 7px;">: {{ $row->penyulang ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td style="font-size: 7px;">Tanggal</td>
                        <td class="border-dotted font-bold" style="font-size: 7px;">: {{ $row->tgl_komisioning ?? '-' }}
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    {{-- ===== MAIN CONTENT ===== --}}
    <table>
        <tr>
            {{-- LEFT COLUMN --}}
            <td class="col-left">
                {{-- STATUS TABLE --}}
                <table class="data-table" style="margin-bottom: 3px;">
                    <thead>
                        <tr>
                            <th width="7%">ADD-MS</th>
                            <th width="7%">ADD-RTU</th>
                            <th width="7%">OBJ</th>
                            <th width="8%">STATUS</th>
                            <th width="8%">VALUE</th>
                            <th width="4%">OK</th>
                            <th width="4%">NOK</th>
                            <th width="4%">LOG</th>
                            <th width="4%">SLD</th>
                            <th width="12%">Ket</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $statuses = [
                        ['CB', 'Open', 'Close'],
                        ['CB 2', 'Open', 'Close'],
                        ['L/R', 'Local', 'Remote'],
                        ['DOOR', 'Open', 'Close'],
                        ['ACF', 'Normal', 'Failed'],
                        ['DCF', 'Normal', 'Failed'],
                        ['DCD', 'Normal', 'Failed'],
                        ['HLT', 'Active', 'Inactive'],
                        ['SF6', 'Normal', 'Low'],
                        ['FIR', 'Normal', 'Failed'],
                        ['FIS', 'Normal', 'Failed'],
                        ['FIT', 'Normal', 'Failed'],
                        ];
                        @endphp
                        @foreach($statuses as $index => $item)
                        <tr class="compact-row">
                            <td></td>
                            <td></td>
                            <td></td>
                            <td rowspan="2">{{ $item[0] }}</td>
                            <td>{{ $item[1] }}</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            @if($index == 0)<td rowspan="24"></td>@endif
                        </tr>
                        <tr class="compact-row">
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>{{ $item[2] }}</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                {{-- CONTROL TABLE --}}
                <table class="data-table" style="margin-bottom: 3px;">
                    <thead>
                        <tr>
                            <th width="7%">ADD-MS</th>
                            <th width="7%">ADD-RTU</th>
                            <th width="7%">OBJ</th>
                            <th width="8%">CTRL</th>
                            <th width="8%">VALUE</th>
                            <th width="4%">OK</th>
                            <th width="4%">NOK</th>
                            <th width="4%">LOG</th>
                            <th width="4%">SLD</th>
                            <th width="12%">Ket</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $controls = [
                        ['CB', 'Open', 'Close'],
                        ['CB 2', 'Open', 'Close'],
                        ['HLT', 'On', 'Off'],
                        ];
                        @endphp
                        @foreach($controls as $index => $item)
                        <tr class="compact-row">
                            <td></td>
                            <td></td>
                            <td></td>
                            <td rowspan="2">{{ $item[0] }}</td>
                            <td>{{ $item[1] }}</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            @if($index == 0)<td rowspan="7"></td>@endif
                        </tr>
                        <tr class="compact-row">
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>{{ $item[2] }}</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        @endforeach
                        <tr class="compact-row">
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>RR</td>
                            <td>Reset</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>

                {{-- METERING TABLE --}}
                <table class="data-table">
                    <thead>
                        <tr>
                            <th width="7%">ADD-MS</th>
                            <th width="7%">ADD-RTU</th>
                            <th width="7%">OBJ</th>
                            <th width="9%">METER</th>
                            <th width="6%">FIELD</th>
                            <th width="6%">MS</th>
                            <th width="5%">SCALE</th>
                            <th width="5%">OK/NOK</th>
                            <th width="4%">SLD</th>
                            <th width="12%">Ket</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $meters = ['HZ', 'I AVG', 'IR', 'IS', 'IT', 'IN', 'IFR', 'IFS', 'IFT', 'IFN', 'PF', 'V AVG',
                        'V-R_IN', 'V-S_IN', 'V-T_IN', 'V-R_OUT', 'V-S_OUT', 'V-T_OUT'];
                        $pseudos = ['IFR', 'IFS', 'IFT', 'IFN'];
                        @endphp
                        @foreach($meters as $index => $meter)
                        <tr class="compact-row">
                            @if(in_array($meter, $pseudos))
                            <td class="bg-gray" style="font-size: 5px;">Pseudo</td>
                            @else
                            <td></td>
                            @endif
                            <td></td>
                            <td></td>
                            <td>{{ $meter }}</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            @if($index == 0)<td rowspan="18"></td>@endif
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </td>

            {{-- RIGHT COLUMN --}}
            <td class="col-right">
                {{-- HARDWARE TABLE --}}
                <table class="data-table" style="margin-bottom: 3px;">
                    <thead>
                        <tr>
                            <th width="40%" class="text-left" style="padding-left: 3px;">Hardware</th>
                            <th width="15%">OK/NOK</th>
                            <th width="15%">Value</th>
                            <th width="30%">Ket</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach(['Batere', 'PS 220', 'Charger', 'Limit Switch'] as $i => $hw)
                        <tr class="compact-row">
                            <td class="text-left">{{ $hw }}</td>
                            <td></td>
                            <td></td>
                            @if($i == 0)<td rowspan="4"></td>@endif
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                {{-- SYSTEM TABLE --}}
                <table class="data-table" style="margin-bottom: 3px;">
                    <thead>
                        <tr>
                            <th width="40%" class="text-left" style="padding-left: 3px;">System</th>
                            <th width="15%">OK/NOK</th>
                            <th width="15%">Value</th>
                            <th width="30%">Ket</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach(['COMF', 'LRUF', 'SIGN S', 'Limit Switch'] as $i => $sys)
                        <tr class="compact-row">
                            <td class="text-left">{{ $sys }}</td>
                            <td></td>
                            <td></td>
                            @if($i == 0)<td rowspan="4"></td>@endif
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                {{-- RECLOSER TABLE --}}
                <table class="data-table" style="margin-bottom: 3px;">
                    <thead>
                        <tr>
                            <th width="28%" class="text-left" style="padding-left: 3px;">RECLOSER</th>
                            <th width="22%">Value</th>
                            <th width="15%">OK/NOK</th>
                            <th width="35%">Ket</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach(['AR', 'CTRL AR'] as $i => $rec)
                        <tr>
                            <td class="text-left">{{ $rec }}</td>
                            <td style="padding: 0; font-size: 5px;">
                                <div class="border-b text-center">On</div>
                                <div class="text-center">Off</div>
                            </td>
                            <td></td>
                            @if($i == 0)<td rowspan="2"></td>@endif
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                {{-- CATATAN --}}
                <table class="border" style="margin-bottom: 3px;">
                    <tr>
                        <td class="bg-gray font-bold border-b text-left" style="padding: 2px; font-size: 7px;">CATATAN
                        </td>
                    </tr>
                    <tr>
                        <td class="align-top" style="height: 70px; padding: 3px; font-size: 7px;">
                            {{ $row->keterangan ?? '' }}
                        </td>
                    </tr>
                </table>

                {{-- PELAKSANA --}}
                <table class="border">
                    <tr>
                        <td class="bg-gray font-bold border-b text-left" style="padding: 2px; font-size: 7px;">PELAKSANA
                            :</td>
                    </tr>
                    <tr>
                        <td style="padding: 0;">
                            <table>
                                <tr>
                                    <td width="33%" class="sig-cell border-r border-b">
                                        <div class="sig-line"></div>
                                        <div style="font-size: 6px; font-weight: bold;">Field Eng. 01</div>
                                    </td>
                                    <td width="33%" class="sig-cell border-r border-b">
                                        <div class="sig-line"></div>
                                        <div style="font-size: 6px; font-weight: bold;">MS Eng. 01</div>
                                    </td>
                                    <td width="34%" class="sig-cell border-b">
                                        <div class="sig-line"></div>
                                        <div style="font-size: 6px; font-weight: bold;">Dispatcher 01</div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="sig-cell border-r">
                                        <div class="sig-line"></div>
                                        <div style="font-size: 6px; font-weight: bold;">Field Eng. 02</div>
                                    </td>
                                    <td class="sig-cell border-r">
                                        <div class="sig-line"></div>
                                        <div style="font-size: 6px; font-weight: bold;">MS Eng. 02</div>
                                    </td>
                                    <td class="sig-cell">
                                        <div class="sig-line"></div>
                                        <div style="font-size: 6px; font-weight: bold;">Dispatcher 02</div>
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
    <div class="border text-center italic" style="font-size: 6px; padding: 2px; margin-top: 3px;">
        Apabila dokumen ini didownload / dicetak maka akan menjadi "DOKUMEN TIDAK TERKENDALI"
    </div>

</body>

</html>
