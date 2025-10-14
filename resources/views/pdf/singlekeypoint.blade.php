<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Keypoint Details</title>
    <style>
    body {
        font-family: Helvetica, sans-serif;
        font-size: 8pt;
        margin: 0;
        padding: 0;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 10px;
    }

    th,
    td {
        border: 1px solid #000;
        padding: 2px;
        /* Reduced from 3px to save space */
        text-align: center;
        vertical-align: middle;
        font-size: 7pt;
    }

    th {
        background-color: #f2f2f2;
        font-weight: bold;
    }

    .header {
        font-size: 10pt;
        font-weight: bold;
        text-align: center;
        margin-bottom: 10px;
    }

    .section-header {
        background-color: #e0e0e0;
    }

    .col-label {
        width: 12%;
        /* Reduced from 15% to allow more space for other columns */
        text-align: left;
    }

    .col-value {
        width: 18%;
        /* Reduced from 20% to balance with other columns */
    }

    .col-small {
        width: 3%;
        /* Reduced from 5% to fit more columns */
    }

    .col-medium {
        width: 8%;
        /* Reduced from 10% to optimize space */
    }

    .col-ket {
        width: 12%;
        /* Reduced from 15% to align with col-label */
        text-align: left;
    }
    </style>
</head>

<body>
    <div class="header">FORM KOMISIONING KEYPOINT</div>

    <table>
        <tr>
            <td class="col-label">Nama LBS / REC.</td>
            <td class="col-value" colspan="4">{{ $formkp->nama_lbs }}</td>
            <td class="col-label">Modem</td>
            <td class="col-value" colspan="4">{{ $modem }}</td>
            <td class="col-label">Gardu Induk / Sectoral</td>
            <td class="col-value" colspan="6">{{ $gi }} / {{ $sectoral }}</td>
        </tr>
        <tr>
            <td class="col-label">Merk LBS / REC.</td>
            <td class="col-value" colspan="4">{{ $merklbs }}</td>
            <td class="col-label">IP Address / No. Kartu</td>
            <td class="col-value" colspan="4">{{ $formkp->ip_kp }}</td>
            <td class="col-label">Penyulang</td>
            <td class="col-value" colspan="6">{{ $formkp->nama_peny }}</td>
        </tr>
        <tr>
            <td class="col-label">Protocol / RTU Address</td>
            <td class="col-value" colspan="2">{{ $medkom }}</td>
            <td class="col-small">/</td>
            <td class="col-value">{{ $formkp->rtu_addrs }}</td>
            <td class="col-label">Koordinat</td>
            <td class="col-value" colspan="4">N/A</td>
            <td class="col-label">Tanggal</td>
            <td class="col-value" colspan="6">{{ \Carbon\Carbon::parse($formkp->tgl_komisioning)->format('d-m-Y') }}
            </td>
        </tr>
        <tr>
            <td class="col-label">Jenis Komisioning</td>
            <td class="col-value" colspan="4">{{ $komkp }}</td>
            <td class="col-label"></td>
            <td class="col-value" colspan="4"></td>
            <td class="col-label"></td>
            <td class="col-value" colspan="6"></td>
        </tr>
    </table>

    <table>
        <tr class="section-header">
            <th class="col-medium">ADD-MS</th>
            <th class="col-medium">ADD-RTU</th>
            <th class="col-medium">OBJ/FRMT</th>
            <th class="col-medium">STATUS</th>
            <th class="col-medium">VALUE</th>
            <th class="col-small">OK</th>
            <th class="col-small">NOK</th>
            <th class="col-small">LOG</th>
            <th class="col-small">SLD</th>
            <th class="col-ket">Keterangan</th>
            <th class="col-small"></th>
            <th class="col-medium">Hardware</th>
            <th class="col-small">OK/NOK</th>
            <th class="col-medium">Value</th>
            <th class="col-ket">Keterangan</th>
            <th class="col-small"></th>
            <th class="col-small"></th>
        </tr>
        @php
        $statuses = [
        's_cb' => ['open_1' => 'CB Open', 'close_1' => 'CB Close'],
        's_cb2' => ['open_1' => 'CB 2 Open', 'close_1' => 'CB 2 Close'],
        's_lr' => ['local_1' => 'L/R Local', 'remote_1' => 'L/R Remote'],
        's_door' => ['dropen_1' => 'DOOR Open', 'drclose_1' => 'DOOR Close'],
        's_acf' => ['acnrml_1' => 'ACF Normal', 'acfail_1' => 'ACF Failed'],
        's_dcf' => ['dcfnrml_1' => 'DCF Normal', 'dcffail_1' => 'DCF Failed'],
        's_dcd' => ['dcnrml_1' => 'DCD Normal', 'dcfail_1' => 'DCD Failed'],
        's_hlt' => ['hlton_1' => 'HLT Active', 'hltoff_1' => 'HLT Inactive'],
        's_sf6' => ['sf6nrml_1' => 'SF6 Normal', 'sf6fail_1' => 'SF6 Low'],
        's_fir' => ['firnrml_1' => 'FIR Normal', 'firfail_1' => 'FIR Failed'],
        's_fis' => ['fisnrml_1' => 'FIS Normal', 'fisfail_1' => 'FIS Failed'],
        's_fit' => ['fitnrml_1' => 'FIT Normal', 'fitfail_1' => 'FIT Failed'],
        's_fin' => ['finnrml_1' => 'Batere OK', 'finfail_1' => 'Batere NOK'],
        's_comf' => ['comf_nrml_1' => 'COMF Normal'],
        's_lruf' => ['lruf_nrml_1' => 'LRUF Normal']
        ];
        $hardware = [
        'Batere' => $formkp->sign_kp,
        'PS 220' => '',
        'Charger' => '',
        'Limit Switch' => '',
        'System' => '',
        'COMF' => in_array('comf_nrml_1', explode(',', $formkp->s_comf)) ? 'OK' : 'NOK',
        'LRUF' => in_array('lruf_nrml_1', explode(',', $formkp->s_lruf)) ? 'OK' : 'NOK',
        'SIGN S' => $formkp->sign_kp,
        'AR' => in_array('comf_nrml_1', explode(',', $formkp->s_comf)) ? 'On' : 'Off',
        'CTRL AR' => in_array('lruf_nrml_1', explode(',', $formkp->s_lruf)) ? 'On' : 'Off',
        'Catatan' => $formkp->ketkp
        ];
        @endphp
        @foreach ($statuses as $field => $values)
        @foreach ($values as $key => $label)
        <tr>
            <td></td>
            <td></td>
            <td>{{ strtoupper(str_replace(['s_', '_1'], '', $field)) }}</td>
            <td>{{ str_replace(['CB Open', 'CB Close', 'CB 2 Open', 'CB 2 Close', 'L/R Local', 'L/R Remote'], ['CB', 'CB', 'CB 2', 'CB 2', 'L/R', 'L/R'], $label) }}
            </td>
            <td>{{ str_replace(['CB ', 'CB 2 ', 'L/R ', 'DOOR ', 'ACF ', 'DCF ', 'DCD ', 'HLT ', 'SF6 ', 'FIR ', 'FIS ', 'FIT ', 'Batere ', 'COMF ', 'LRUF '], ['', '', '', '', '', '', '', '', '', '', '', '', '', ''], $label) }}
            </td>
            <td>{{ in_array($key, explode(',', $formkp->$field)) ? 'X' : '' }}</td>
            <td>{{ in_array(str_replace(['nrml', 'on', 'open'], ['fail', 'off', 'close'], $key), explode(',', $formkp->$field)) ? 'X' : '' }}
            </td>
            <td></td>
            <td></td>
            <td>{{ in_array($key, explode(',', $formkp->$field)) ? str_replace(['nrml_1', 'fail_1', 'on_1', 'off_1', 'open_1', 'close_1'], ['Normal', 'Failed', 'Active', 'Inactive', 'Open', 'Close'], $key) : '' }}
            </td>
            <td></td>
            <td>{{ isset($hardware[$label]) ? $label : '' }}</td>
            <td>{{ isset($hardware[$label]) ? ($hardware[$label] == 'OK' || $hardware[$label] == 'On' ? 'OK' : 'NOK') : '' }}
            </td>
            <td>{{ isset($hardware[$label]) ? $hardware[$label] : '' }}</td>
            <td>{{ $label == 'Catatan' ? $formkp->ketkp : '' }}</td>
            <td></td>
            <td></td>
        </tr>
        @endforeach
        @endforeach
        @foreach ($hardware as $key => $value)
        @if (!array_key_exists($key, array_merge(...array_values($statuses))))
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>{{ $key }}</td>
            <td>{{ $value == 'OK' || $value == 'On' ? 'OK' : ($value ? 'NOK' : '') }}</td>
            <td>{{ $value }}</td>
            <td>{{ $key == 'Catatan' ? $formkp->ketkp : '' }}</td>
            <td></td>
            <td></td>
        </tr>
        @endif
        @endforeach
    </table>

    <table>
        <tr class="section-header">
            <th class="col-medium">ADD-MS</th>
            <th class="col-medium">ADD-RTU</th>
            <th class="col-medium">OBJ/FRMT</th>
            <th class="col-medium">CTRL</th>
            <th class="col-medium">VALUE</th>
            <th class="col-small">OK</th>
            <th class="col-small">NOK</th>
            <th class="col-small">LOG</th>
            <th class="col-small">SLD</th>
            <th class="col-ket">Keterangan</th>
            <th class="col-small"></th>
            <th class="col-small"></th>
            <th class="col-small"></th>
            <th class="col-small"></th>
            <th class="col-small"></th>
            <th class="col-small"></th>
            <th class="col-small"></th>
        </tr>
        @php
        $controls = [
        'c_cb' => ['cbctrl_op_1' => 'CB Open', 'cbctrl_cl_1' => 'CB Close'],
        'c_cb2' => ['cbctrl_op_1' => 'CB 2 Open', 'cbctrl_cl_1' => 'CB 2 Close'],
        'c_hlt' => ['hltctrl_on_1' => 'HLT On', 'hltctrl_off_1' => 'HLT Off'],
        'c_rst' => ['rrctrl_on_1' => 'RR Reset']
        ];
        @endphp
        @foreach ($controls as $field => $values)
        @foreach ($values as $key => $label)
        <tr>
            <td></td>
            <td></td>
            <td>{{ strtoupper(str_replace(['c_', '_1'], '', $field)) }}</td>
            <td>{{ str_replace(['CB Open', 'CB Close', 'CB 2 Open', 'CB 2 Close'], ['CB', 'CB', 'CB 2', 'CB 2'], $label) }}
            </td>
            <td>{{ str_replace(['CB ', 'CB 2 ', 'HLT ', 'RR '], ['', '', '', ''], $label) }}</td>
            <td>{{ in_array($key, explode(',', $formkp->$field)) ? 'X' : '' }}</td>
            <td>{{ in_array(str_replace(['op', 'on'], ['cl', 'off'], $key), explode(',', $formkp->$field)) ? 'X' : '' }}
            </td>
            <td></td>
            <td></td>
            <td>{{ in_array($key, explode(',', $formkp->$field)) ? str_replace(['cbctrl_op_1', 'cbctrl_cl_1', 'hltctrl_on_1', 'hltctrl_off_1', 'rrctrl_on_1'], ['Open', 'Close', 'On', 'Off', 'Reset'], $key) : '' }}
            </td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        @endforeach
        @endforeach
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>Pelaksana:</td>
            <td colspan="6">{{ $formkp->pelrtu }}</td>
        </tr>
    </table>

    <table>
        <tr class="section-header">
            <th class="col-medium">ADD-MS</th>
            <th class="col-medium">ADD-RTU</th>
            <th class="col-medium">OBJ/FRMT</th>
            <th class="col-medium">METERING</th>
            <th class="col-medium">FIELD</th>
            <th class="col-medium">MS</th>
            <th class="col-medium">SCALE</th>
            <th class="col-small">OK/NOK</th>
            <th class="col-small">SLD</th>
            <th class="col-ket">Keterangan</th>
            <th class="col-small"></th>
            <th class="col-medium"></th>
            <th class="col-small"></th>
            <th class="col-medium"></th>
            <th class="col-small"></th>
            <th class="col-small"></th>
            <th class="col-small"></th>
        </tr>
        @php
        $metering = [
        'HZ' => ['', '', ''],
        'I AVG' => ['', '', ''],
        'IR' => [$formkp->ir_rtu, $formkp->ir_ms, $formkp->ir_scale],
        'IS' => [$formkp->is_rtu, $formkp->is_ms, $formkp->is_scale],
        'IT' => [$formkp->it_rtu, $formkp->it_ms, $formkp->it_scale],
        'IN' => ['', '', ''],
        'IFR' => ['', '', ''],
        'IFS' => ['', '', ''],
        'IFT' => ['', '', ''],
        'IFN' => ['', '', ''],
        'Pseudo IFR' => ['', '', ''],
        'Pseudo IFS' => ['', '', ''],
        'Pseudo IFT' => ['', '', ''],
        'Pseudo IFN' => ['', '', ''],
        'PF' => ['', '', ''],
        'V AVG' => ['', '', ''],
        'V-R_IN' => [$formkp->vr_rtu, $formkp->vr_ms, $formkp->vr_scale],
        'V-S_IN' => [$formkp->vs_rtu, $formkp->vs_ms, $formkp->vs_scale],
        'V-T_IN' => [$formkp->vt_rtu, $formkp->vt_ms, $formkp->vt_scale],
        'V-R_OUT' => ['', '', ''],
        'V-S_OUT' => ['', '', ''],
        'V-T_OUT' => ['', '', '']
        ];
        @endphp
        @foreach ($metering as $key => $values)
        <tr>
            <td></td>
            <td></td>
            <td>{{ strtoupper($key) }}</td>
            <td>{{ $key }}</td>
            <td>{{ $values[0] }}</td>
            <td>{{ $values[1] }}</td>
            <td>{{ $values[2] }}</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        @endforeach
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>Field Eng. 01</td>
            <td>{{ $picms[0] ?? 'N/A' }}</td>
            <td></td>
            <td>MS Eng. 01</td>
            <td>{{ $picms[0] ?? 'N/A' }}</td>
            <td>Dispatcher 01</td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>Field Eng. 02</td>
            <td>{{ $picms[1] ?? 'N/A' }}</td>
            <td></td>
            <td>MS Eng. 02</td>
            <td>{{ $picms[1] ?? 'N/A' }}</td>
            <td>Dispatcher 02</td>
            <td></td>
        </tr>
    </table>

    <div style="text-align: center; font-size: 7pt; margin-top: 10px;">
        Apabila dokumen ini didownload / dicetak maka akan menjadi "DOKUMEN TIDAK TERKENDALI"
    </div>
</body>

</html>
