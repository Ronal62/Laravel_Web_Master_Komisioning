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
                        @php
                        // Parse status values dari database
                        $parseStatus = function($statusString) {
                        if (empty($statusString)) return [];
                        return array_map('trim', explode(',', $statusString));
                        };

                        // Check apakah value ada dan return suffix number (1=OK, 2=NOK, 3=LOG, 4=SLD)
                        $getCheckValue = function($statusArray, $prefix) {
                        foreach ($statusArray as $item) {
                        if (strpos($item, $prefix) === 0) {
                        // Extract number dari akhir string (e.g., 'open_1' -> 1)
                        preg_match('/_(\d+)$/', $item, $matches);
                        if (isset($matches[1])) {
                        return (int)$matches[1];
                        }
                        }
                        }
                        return 0;
                        };

                        // Parse semua status dari database
                        $s_cb = $parseStatus($row->s_cb ?? '');
                        $s_cb2 = $parseStatus($row->s_cb2 ?? '');
                        $s_lr = $parseStatus($row->s_lr ?? '');
                        $s_door = $parseStatus($row->s_door ?? '');
                        $s_acf = $parseStatus($row->s_acf ?? '');
                        $s_dcf = $parseStatus($row->s_dcf ?? '');
                        $s_dcd = $parseStatus($row->s_dcd ?? '');
                        $s_hlt = $parseStatus($row->s_hlt ?? '');
                        $s_sf6 = $parseStatus($row->s_sf6 ?? '');
                        $s_fir = $parseStatus($row->s_fir ?? '');
                        $s_fis = $parseStatus($row->s_fis ?? '');
                        $s_fit = $parseStatus($row->s_fit ?? '');

                        // Define status items dengan mapping ke database fields
                        $statuses = [
                        [
                        'name' => 'CB',
                        'row1' => ['label' => 'Open', 'prefix' => 'open', 'status' => $s_cb],
                        'row2' => ['label' => 'Close', 'prefix' => 'close', 'status' => $s_cb],
                        'addr' => [
                        'row1' => ['ms' => $row->scb_open_addms ?? '', 'rtu' => $row->scb_open_addrtu ?? '', 'obj' =>
                        $row->scb_open_objfrmt ?? ''],
                        'row2' => ['ms' => $row->scb_close_addms ?? '', 'rtu' => $row->scb_close_addrtu ?? '', 'obj' =>
                        $row->scb_close_objfrmt ?? '']
                        ]
                        ],
                        [
                        'name' => 'CB 2',
                        'row1' => ['label' => 'Open', 'prefix' => 'open', 'status' => $s_cb2],
                        'row2' => ['label' => 'Close', 'prefix' => 'close', 'status' => $s_cb2],
                        'addr' => [
                        'row1' => ['ms' => $row->scb2_open_addms ?? '', 'rtu' => $row->scb2_open_addrtu ?? '', 'obj' =>
                        $row->scb2_open_objfrmt ?? ''],
                        'row2' => ['ms' => $row->scb2_close_addms ?? '', 'rtu' => $row->scb2_close_addrtu ?? '', 'obj'
                        => $row->scb2_close_objfrmt ?? '']
                        ]
                        ],
                        [
                        'name' => 'L/R',
                        'row1' => ['label' => 'Local', 'prefix' => 'local', 'status' => $s_lr],
                        'row2' => ['label' => 'Remote', 'prefix' => 'remote', 'status' => $s_lr],
                        'addr' => [
                        'row1' => ['ms' => $row->slr_local_addms ?? '', 'rtu' => $row->slr_local_addrtu ?? '', 'obj' =>
                        $row->slr_local_objfrmt ?? ''],
                        'row2' => ['ms' => $row->slr_remote_addms ?? '', 'rtu' => $row->slr_remote_addrtu ?? '', 'obj'
                        => $row->slr_remote_objfrmt ?? '']
                        ]
                        ],
                        [
                        'name' => 'DOOR',
                        'row1' => ['label' => 'Open', 'prefix' => 'dropen', 'status' => $s_door],
                        'row2' => ['label' => 'Close', 'prefix' => 'drclose', 'status' => $s_door],
                        'addr' => [
                        'row1' => ['ms' => $row->sdoor_open_addms ?? '', 'rtu' => $row->sdoor_open_addrtu ?? '', 'obj'
                        => $row->sdoor_open_objfrmt ?? ''],
                        'row2' => ['ms' => $row->sdoor_close_addms ?? '', 'rtu' => $row->sdoor_close_addrtu ?? '', 'obj'
                        => $row->sdoor_close_objfrmt ?? '']
                        ]
                        ],
                        [
                        'name' => 'ACF',
                        'row1' => ['label' => 'Normal', 'prefix' => 'acnrml', 'status' => $s_acf],
                        'row2' => ['label' => 'Failed', 'prefix' => 'acfail', 'status' => $s_acf],
                        'addr' => [
                        'row1' => ['ms' => $row->sacf_normal_addms ?? '', 'rtu' => $row->sacf_normal_addrtu ?? '', 'obj'
                        => $row->sacf_normal_objfrmt ?? ''],
                        'row2' => ['ms' => $row->sacf_fail_addms ?? '', 'rtu' => $row->sacf_fail_addrtu ?? '', 'obj' =>
                        $row->sacf_fail_objfrmt ?? '']
                        ]
                        ],
                        [
                        'name' => 'DCF',
                        'row1' => ['label' => 'Normal', 'prefix' => 'dcfnrml', 'status' => $s_dcf],
                        'row2' => ['label' => 'Failed', 'prefix' => 'dcffail', 'status' => $s_dcf],
                        'addr' => [
                        'row1' => ['ms' => $row->sdcf_normal_addms ?? '', 'rtu' => $row->sdcf_normal_addrtu ?? '', 'obj'
                        => $row->sdcf_normal_objfrmt ?? ''],
                        'row2' => ['ms' => $row->sdcf_fail_addms ?? '', 'rtu' => $row->sdcf_fail_addrtu ?? '', 'obj' =>
                        $row->sdcf_fail_objfrmt ?? '']
                        ]
                        ],
                        [
                        'name' => 'DCD',
                        'row1' => ['label' => 'Normal', 'prefix' => 'dcnrml', 'status' => $s_dcd],
                        'row2' => ['label' => 'Failed', 'prefix' => 'dcfail', 'status' => $s_dcd],
                        'addr' => [
                        'row1' => ['ms' => $row->sdcd_normal_addms ?? '', 'rtu' => $row->sdcd_normal_addrtu ?? '', 'obj'
                        => $row->sdcd_normal_objfrmt ?? ''],
                        'row2' => ['ms' => $row->sdcd_fail_addms ?? '', 'rtu' => $row->sdcd_fail_addrtu ?? '', 'obj' =>
                        $row->sdcd_fail_objfrmt ?? '']
                        ]
                        ],
                        [
                        'name' => 'HLT',
                        'row1' => ['label' => 'Active', 'prefix' => 'hlton', 'status' => $s_hlt],
                        'row2' => ['label' => 'Inactive', 'prefix' => 'hltoff', 'status' => $s_hlt],
                        'addr' => [
                        'row1' => ['ms' => $row->shlt_on_addms ?? '', 'rtu' => $row->shlt_on_addrtu ?? '', 'obj' =>
                        $row->shlt_on_objfrmt ?? ''],
                        'row2' => ['ms' => $row->shlt_off_addms ?? '', 'rtu' => $row->shlt_off_addrtu ?? '', 'obj' =>
                        $row->shlt_off_objfrmt ?? '']
                        ]
                        ],
                        [
                        'name' => 'SF6',
                        'row1' => ['label' => 'Normal', 'prefix' => 'sf6nrml', 'status' => $s_sf6],
                        'row2' => ['label' => 'Low', 'prefix' => 'sf6fail', 'status' => $s_sf6],
                        'addr' => [
                        'row1' => ['ms' => $row->ssf6_normal_addms ?? '', 'rtu' => $row->ssf6_normal_addrtu ?? '', 'obj'
                        => $row->ssf6_normal_objfrmt ?? ''],
                        'row2' => ['ms' => $row->ssf6_fail_addms ?? '', 'rtu' => $row->ssf6_fail_addrtu ?? '', 'obj' =>
                        $row->ssf6_fail_objfrmt ?? '']
                        ]
                        ],
                        [
                        'name' => 'FIR',
                        'row1' => ['label' => 'Normal', 'prefix' => 'firnrml', 'status' => $s_fir],
                        'row2' => ['label' => 'Failed', 'prefix' => 'firfail', 'status' => $s_fir],
                        'addr' => [
                        'row1' => ['ms' => $row->sfir_normal_addms ?? '', 'rtu' => $row->sfir_normal_addrtu ?? '', 'obj'
                        => $row->sfir_normal_objfrmt ?? ''],
                        'row2' => ['ms' => $row->sfir_fail_addms ?? '', 'rtu' => $row->sfir_fail_addrtu ?? '', 'obj' =>
                        $row->sfir_fail_objfrmt ?? '']
                        ]
                        ],
                        [
                        'name' => 'FIS',
                        'row1' => ['label' => 'Normal', 'prefix' => 'fisnrml', 'status' => $s_fis],
                        'row2' => ['label' => 'Failed', 'prefix' => 'fisfail', 'status' => $s_fis],
                        'addr' => [
                        'row1' => ['ms' => $row->sfis_normal_addms ?? '', 'rtu' => $row->sfis_normal_addrtu ?? '', 'obj'
                        => $row->sfis_normal_objfrmt ?? ''],
                        'row2' => ['ms' => $row->sfis_fail_addms ?? '', 'rtu' => $row->sfis_fail_addrtu ?? '', 'obj' =>
                        $row->sfis_fail_objfrmt ?? '']
                        ]
                        ],
                        [
                        'name' => 'FIT',
                        'row1' => ['label' => 'Normal', 'prefix' => 'fitnrml', 'status' => $s_fit],
                        'row2' => ['label' => 'Failed', 'prefix' => 'fitfail', 'status' => $s_fit],
                        'addr' => [
                        'row1' => ['ms' => $row->sfit_normal_addms ?? '', 'rtu' => $row->sfit_normal_addrtu ?? '', 'obj'
                        => $row->sfit_normal_objfrmt ?? ''],
                        'row2' => ['ms' => $row->sfit_fail_addms ?? '', 'rtu' => $row->sfit_fail_addrtu ?? '', 'obj' =>
                        $row->sfit_fail_objfrmt ?? '']
                        ]
                        ],
                        ];
                        @endphp

                        @foreach($statuses as $index => $item)
                        @php
                        // Get check values untuk row 1 dan row 2
                        $check1 = $getCheckValue($item['row1']['status'], $item['row1']['prefix']);
                        $check2 = $getCheckValue($item['row2']['status'], $item['row2']['prefix']);
                        @endphp
                        {{-- Row 1 --}}
                        <tr>
                            <td style="height: 12px; font-size: 6px; padding: 2px;">{{ $item['addr']['row1']['ms'] }}
                            </td>
                            <td style="height: 12px; font-size: 6px; padding: 2px;">{{ $item['addr']['row1']['rtu'] }}
                            </td>
                            <td style="height: 12px; font-size: 6px; padding: 2px;">{{ $item['addr']['row1']['obj'] }}
                            </td>
                            <td rowspan="2" class="font-bold" style="font-size: 8px; padding: 2px;">{{ $item['name'] }}
                            </td>
                            <td style="height: 12px; font-size: 7px; padding: 2px;">{{ $item['row1']['label'] }}</td>
                            <td style="height: 12px; font-size: 9px; padding: 2px; color: green;">
                                {{ $check1 == 1 ? '✓' : '' }}</td>
                            <td style="height: 12px; font-size: 9px; padding: 2px; color: red;">
                                {{ $check1 == 2 ? '✓' : '' }}</td>
                            <td style="height: 12px; font-size: 9px; padding: 2px; color: blue;">
                                {{ $check1 == 3 ? '✓' : '' }}</td>
                            <td style="height: 12px; font-size: 9px; padding: 2px; color: orange;">
                                {{ $check1 == 4 ? '✓' : '' }}</td>
                            @if($index == 0)
                            <td rowspan="24" class="text-left align-top" style="padding: 4px; font-size: 7px;">
                                {{ $row->ketfts ?? '' }}
                            </td>
                            @endif
                        </tr>
                        {{-- Row 2 --}}
                        <tr>
                            <td style="height: 12px; font-size: 6px; padding: 2px;">{{ $item['addr']['row2']['ms'] }}
                            </td>
                            <td style="height: 12px; font-size: 6px; padding: 2px;">{{ $item['addr']['row2']['rtu'] }}
                            </td>
                            <td style="height: 12px; font-size: 6px; padding: 2px;">{{ $item['addr']['row2']['obj'] }}
                            </td>
                            <td style="height: 12px; font-size: 7px; padding: 2px;">{{ $item['row2']['label'] }}</td>
                            <td style="height: 12px; font-size: 9px; padding: 2px; color: green;">
                                {{ $check2 == 1 ? '✓' : '' }}</td>
                            <td style="height: 12px; font-size: 9px; padding: 2px; color: red;">
                                {{ $check2 == 2 ? '✓' : '' }}</td>
                            <td style="height: 12px; font-size: 9px; padding: 2px; color: blue;">
                                {{ $check2 == 3 ? '✓' : '' }}</td>
                            <td style="height: 12px; font-size: 9px; padding: 2px; color: orange;">
                                {{ $check2 == 4 ? '✓' : '' }}</td>
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
                        @php
                        $controls = [
                        ['CB', 'Open', 'Close'],
                        ['CB 2', 'Open', 'Close'],
                        ['HLT', 'On', 'Off'],
                        ];
                        @endphp
                        @foreach($controls as $index => $item)
                        <tr>
                            <td style="height: 12px; font-size: 7px; padding: 2px;"></td>
                            <td style="height: 12px; font-size: 7px; padding: 2px;"></td>
                            <td style="height: 12px; font-size: 7px; padding: 2px;"></td>
                            <td rowspan="2" class="font-bold" style="font-size: 8px; padding: 2px;">{{ $item[0] }}</td>
                            <td style="height: 12px; font-size: 7px; padding: 2px;">{{ $item[1] }}</td>
                            <td style="height: 12px; font-size: 7px; padding: 2px;"></td>
                            <td style="height: 12px; font-size: 7px; padding: 2px;"></td>
                            <td style="height: 12px; font-size: 7px; padding: 2px;"></td>
                            <td style="height: 12px; font-size: 7px; padding: 2px;"></td>
                            @if($index == 0)
                            <td rowspan="7" class="text-left align-top" style="padding: 4px; font-size: 7px;">
                                {{ $row->ketftc ?? '' }}
                            </td>
                            @endif
                        </tr>
                        <tr>
                            <td style="height: 12px; font-size: 7px; padding: 2px;"></td>
                            <td style="height: 12px; font-size: 7px; padding: 2px;"></td>
                            <td style="height: 12px; font-size: 7px; padding: 2px;"></td>
                            <td style="height: 12px; font-size: 7px; padding: 2px;">{{ $item[2] }}</td>
                            <td style="height: 12px; font-size: 7px; padding: 2px;"></td>
                            <td style="height: 12px; font-size: 7px; padding: 2px;"></td>
                            <td style="height: 12px; font-size: 7px; padding: 2px;"></td>
                            <td style="height: 12px; font-size: 7px; padding: 2px;"></td>
                        </tr>
                        @endforeach
                        <tr>
                            <td style="height: 12px; font-size: 7px; padding: 2px;"></td>
                            <td style="height: 12px; font-size: 7px; padding: 2px;"></td>
                            <td style="height: 12px; font-size: 7px; padding: 2px;"></td>
                            <td class="font-bold" style="font-size: 8px; padding: 2px;">RR</td>
                            <td style="height: 12px; font-size: 7px; padding: 2px;">Reset</td>
                            <td style="height: 12px; font-size: 7px; padding: 2px;"></td>
                            <td style="height: 12px; font-size: 7px; padding: 2px;"></td>
                            <td style="height: 12px; font-size: 7px; padding: 2px;"></td>
                            <td style="height: 12px; font-size: 7px; padding: 2px;"></td>
                        </tr>
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
