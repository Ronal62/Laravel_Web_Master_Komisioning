{{-- resources/views/excel/keypoint_excel.blade.php --}}
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
</head>

<body>
    @foreach($keypoints as $index => $data)
    @php
    $row = $data['row'];
    $pelaksanaMs = $data['pelaksanaMs'];
    $pelaksanaRtu = $data['pelaksanaRtu'];
    $statusData = $data['statusData'];
    $controlData = $data['controlData'];
    $meteringData = $data['meteringData'];
    $hardwareData = $data['hardwareData'];
    $systemData = $data['systemData'];
    $recloserData = $data['recloserData'] ?? [];

    // Calculate starting row for this page
    $pageStartRow = $index * 60 + 1; // Adjust based on your needs
    @endphp

    {{-- ===== HEADER SECTION ===== --}}
    <table>
        {{-- Row 1 --}}
        <tr>
            <td colspan="3" rowspan="3"
                style="border: 1px solid #000000; text-align: center; vertical-align: middle; font-weight: bold;">
                PT PLN (PERSERO)
                DISTRIBUSI JAWA TIMUR
                JL. EMBONG TRENGGULI NO. 19 - 21
                SURABAYA | TLP: (031) 53406531
            </td>
            <td colspan="3" rowspan="3"
                style="border: 1px solid #000000; text-align: center; vertical-align: middle; font-weight: bold; font-size: 14px;">
                FORM STANDART
            </td>
            <td colspan="2" style="border: 1px solid #000000; background-color: #CCCCCC; font-weight: bold;">NO. DOKUMEN
            </td>
            <td colspan="2" style="border: 1px solid #000000;">HAL : {{ $index + 1 }}</td>
        </tr>
        {{-- Row 2 --}}
        <tr>
            <td colspan="2" rowspan="2"
                style="border: 1px solid #000000; text-align: center; font-weight: bold; font-size: 14px;">FS.SCA.01.17
            </td>
            <td colspan="2" style="border: 1px solid #000000;">TGL : {{ $row->tgl_komisioning_formatted }}</td>
        </tr>
        {{-- Row 3 --}}
        <tr>
            <td colspan="2" style="border: 1px solid #000000;">REV : 0</td>
        </tr>

        {{-- Spacer --}}
        <tr>
            <td colspan="10"></td>
        </tr>

        {{-- ===== TITLE ===== --}}
        <tr>
            <td colspan="10"
                style="text-align: center; font-weight: bold; font-size: 14px; text-decoration: underline;">
                TES POINT TO POINT LBS
            </td>
        </tr>
        <tr>
            <td colspan="10" style="text-align: center; font-weight: bold;">
                FORM KOMISIONING KEYPOINT
            </td>
        </tr>

        {{-- Spacer --}}
        <tr>
            <td colspan="10"></td>
        </tr>

        {{-- ===== DEVICE INFO ===== --}}
        <tr>
            <td style="border: 1px solid #000000; background-color: #E5E5E5;">Nama LBS / REC.</td>
            <td colspan="2" style="border: 1px solid #000000; font-weight: bold;">{{ $row->nama_keypoint }}</td>
            <td style="border: 1px solid #000000; background-color: #E5E5E5;">Modem</td>
            <td colspan="2" style="border: 1px solid #000000; font-weight: bold;">{{ $row->nama_modem }}</td>
            <td style="border: 1px solid #000000; background-color: #E5E5E5;">Gardu Induk</td>
            <td colspan="3" style="border: 1px solid #000000; font-weight: bold;">{{ $row->gardu_induk }}</td>
        </tr>
        <tr>
            <td style="border: 1px solid #000000; background-color: #E5E5E5;">Merk</td>
            <td colspan="2" style="border: 1px solid #000000; font-weight: bold;">{{ $row->nama_merklbs }}</td>
            <td style="border: 1px solid #000000; background-color: #E5E5E5;">IP / No. Kartu</td>
            <td colspan="2" style="border: 1px solid #000000; font-weight: bold;">{{ $row->ip_rtu }}</td>
            <td style="border: 1px solid #000000; background-color: #E5E5E5;">Penyulang</td>
            <td colspan="3" style="border: 1px solid #000000; font-weight: bold;">{{ $row->penyulang }}</td>
        </tr>
        <tr>
            <td style="border: 1px solid #000000; background-color: #E5E5E5;">Protocol</td>
            <td colspan="2" style="border: 1px solid #000000; font-weight: bold;">{{ $row->alamat_rtu }}</td>
            <td style="border: 1px solid #000000; background-color: #E5E5E5;">Koordinat</td>
            <td colspan="2" style="border: 1px solid #000000; font-weight: bold;">-</td>
            <td style="border: 1px solid #000000; background-color: #E5E5E5;">Tanggal</td>
            <td colspan="3" style="border: 1px solid #000000; font-weight: bold;">{{ $row->tgl_komisioning_formatted }}
            </td>
        </tr>

        {{-- Spacer --}}
        <tr>
            <td colspan="10"></td>
        </tr>

        {{-- ===== STATUS TABLE HEADER ===== --}}
        <tr>
            <td style="border: 1px solid #000000; background-color: #CCCCCC; font-weight: bold; text-align: center;">
                ADD-MS</td>
            <td style="border: 1px solid #000000; background-color: #CCCCCC; font-weight: bold; text-align: center;">
                ADD-RTU</td>
            <td style="border: 1px solid #000000; background-color: #CCCCCC; font-weight: bold; text-align: center;">
                STATUS</td>
            <td style="border: 1px solid #000000; background-color: #CCCCCC; font-weight: bold; text-align: center;">
                VALUE</td>
            <td style="border: 1px solid #000000; background-color: #CCCCCC; font-weight: bold; text-align: center;">OK
            </td>
            <td style="border: 1px solid #000000; background-color: #CCCCCC; font-weight: bold; text-align: center;">NOK
            </td>
            <td style="border: 1px solid #000000; background-color: #CCCCCC; font-weight: bold; text-align: center;">KET
            </td>
            {{-- Right side - Hardware Header --}}
            <td style="border: 1px solid #000000; background-color: #CCCCCC; font-weight: bold; text-align: center;">
                HARDWARE</td>
            <td style="border: 1px solid #000000; background-color: #CCCCCC; font-weight: bold; text-align: center;">
                OK/NOK</td>
            <td style="border: 1px solid #000000; background-color: #CCCCCC; font-weight: bold; text-align: center;">
                VALUE</td>
        </tr>

        {{-- ===== STATUS DATA ROWS ===== --}}
        @php
        $statusRows = [];
        foreach($statusData as $item) {
        foreach(['row1', 'row2'] as $r) {
        if(isset($item[$r])) {
        $statusRows[] = [
        'ms' => $item[$r]['ms'],
        'rtu' => $item[$r]['rtu'],
        'name' => $item['name'],
        'label' => $item[$r]['label'],
        'ok' => in_array(1, $item[$r]['checks']) ? '✓' : '',
        'nok' => in_array(2, $item[$r]['checks']) ? '✓' : '',
        ];
        }
        }
        }

        $hwItems = [
        ['name' => 'Batere', 'idx' => 0],
        ['name' => 'PS 220', 'idx' => 1],
        ['name' => 'Charger', 'idx' => 2],
        ['name' => 'Limit Switch', 'idx' => 3],
        ];

        $maxRows = max(count($statusRows), count($hwItems));
        @endphp

        @for($i = 0; $i < $maxRows; $i++) <tr>
            {{-- Status columns --}}
            <td style="border: 1px solid #000000; text-align: center;">{{ $statusRows[$i]['ms'] ?? '' }}</td>
            <td style="border: 1px solid #000000; text-align: center;">{{ $statusRows[$i]['rtu'] ?? '' }}</td>
            <td style="border: 1px solid #000000;">{{ $statusRows[$i]['name'] ?? '' }}</td>
            <td style="border: 1px solid #000000;">{{ $statusRows[$i]['label'] ?? '' }}</td>
            <td style="border: 1px solid #000000; text-align: center;">{{ $statusRows[$i]['ok'] ?? '' }}</td>
            <td style="border: 1px solid #000000; text-align: center;">{{ $statusRows[$i]['nok'] ?? '' }}</td>
            <td style="border: 1px solid #000000;"></td>
            {{-- Hardware columns --}}
            <td style="border: 1px solid #000000;">{{ $hwItems[$i]['name'] ?? '' }}</td>
            <td style="border: 1px solid #000000; text-align: center;">
                {{ $hardwareData[$hwItems[$i]['idx'] ?? 0]['status'] ?? '' }}</td>
            <td style="border: 1px solid #000000; text-align: center;">
                {{ $hardwareData[$hwItems[$i]['idx'] ?? 0]['value'] ?? '' }}</td>
            </tr>
            @endfor

            {{-- Spacer --}}
            <tr>
                <td colspan="10"></td>
            </tr>

            {{-- ===== CONTROL TABLE HEADER ===== --}}
            <tr>
                <td
                    style="border: 1px solid #000000; background-color: #CCCCCC; font-weight: bold; text-align: center;">
                    ADD-MS</td>
                <td
                    style="border: 1px solid #000000; background-color: #CCCCCC; font-weight: bold; text-align: center;">
                    ADD-RTU</td>
                <td
                    style="border: 1px solid #000000; background-color: #CCCCCC; font-weight: bold; text-align: center;">
                    CONTROL</td>
                <td
                    style="border: 1px solid #000000; background-color: #CCCCCC; font-weight: bold; text-align: center;">
                    VALUE</td>
                <td
                    style="border: 1px solid #000000; background-color: #CCCCCC; font-weight: bold; text-align: center;">
                    OK</td>
                <td
                    style="border: 1px solid #000000; background-color: #CCCCCC; font-weight: bold; text-align: center;">
                    NOK</td>
                <td
                    style="border: 1px solid #000000; background-color: #CCCCCC; font-weight: bold; text-align: center;">
                    KET</td>
                {{-- Right side - System Header --}}
                <td
                    style="border: 1px solid #000000; background-color: #CCCCCC; font-weight: bold; text-align: center;">
                    SYSTEM</td>
                <td
                    style="border: 1px solid #000000; background-color: #CCCCCC; font-weight: bold; text-align: center;">
                    OK/NOK</td>
                <td
                    style="border: 1px solid #000000; background-color: #CCCCCC; font-weight: bold; text-align: center;">
                    VALUE</td>
            </tr>

            {{-- ===== CONTROL DATA ROWS ===== --}}
            @php
            $controlRows = [];
            foreach($controlData as $item) {
            if(isset($item['row1'])) {
            $controlRows[] = [
            'ms' => $item['row1']['ms'] ?? '',
            'rtu' => $item['row1']['rtu'] ?? '',
            'name' => $item['name'],
            'label' => $item['row1']['label'] ?? '',
            'ok' => in_array(1, $item['row1']['checks'] ?? []) ? '✓' : '',
            'nok' => in_array(2, $item['row1']['checks'] ?? []) ? '✓' : '',
            ];
            }
            if(!($item['single'] ?? false) && isset($item['row2'])) {
            $controlRows[] = [
            'ms' => $item['row2']['ms'] ?? '',
            'rtu' => $item['row2']['rtu'] ?? '',
            'name' => $item['name'],
            'label' => $item['row2']['label'] ?? '',
            'ok' => in_array(1, $item['row2']['checks'] ?? []) ? '✓' : '',
            'nok' => in_array(2, $item['row2']['checks'] ?? []) ? '✓' : '',
            ];
            }
            }

            $sysItems = [
            ['name' => 'COMF', 'idx' => 0],
            ['name' => 'LRUF', 'idx' => 1],
            ['name' => 'SIGN S', 'idx' => 2],
            ['name' => 'Limit Switch', 'idx' => 3],
            ];

            $maxControlRows = max(count($controlRows), count($sysItems));
            @endphp

            @for($i = 0; $i < $maxControlRows; $i++) <tr>
                {{-- Control columns --}}
                <td style="border: 1px solid #000000; text-align: center;">{{ $controlRows[$i]['ms'] ?? '' }}</td>
                <td style="border: 1px solid #000000; text-align: center;">{{ $controlRows[$i]['rtu'] ?? '' }}</td>
                <td style="border: 1px solid #000000;">{{ $controlRows[$i]['name'] ?? '' }}</td>
                <td style="border: 1px solid #000000;">{{ $controlRows[$i]['label'] ?? '' }}</td>
                <td style="border: 1px solid #000000; text-align: center;">{{ $controlRows[$i]['ok'] ?? '' }}</td>
                <td style="border: 1px solid #000000; text-align: center;">{{ $controlRows[$i]['nok'] ?? '' }}</td>
                <td style="border: 1px solid #000000;"></td>
                {{-- System columns --}}
                <td style="border: 1px solid #000000;">{{ $sysItems[$i]['name'] ?? '' }}</td>
                <td style="border: 1px solid #000000; text-align: center;">
                    {{ $systemData[$sysItems[$i]['idx'] ?? 0]['status'] ?? '' }}</td>
                <td style="border: 1px solid #000000; text-align: center;">
                    {{ $systemData[$sysItems[$i]['idx'] ?? 0]['value'] ?? '' }}</td>
                </tr>
                @endfor

                {{-- Spacer --}}
                <tr>
                    <td colspan="10"></td>
                </tr>

                {{-- ===== METERING TABLE HEADER ===== --}}
                <tr>
                    <td
                        style="border: 1px solid #000000; background-color: #CCCCCC; font-weight: bold; text-align: center;">
                        ADD-MS</td>
                    <td
                        style="border: 1px solid #000000; background-color: #CCCCCC; font-weight: bold; text-align: center;">
                        ADD-RTU</td>
                    <td
                        style="border: 1px solid #000000; background-color: #CCCCCC; font-weight: bold; text-align: center;">
                        METER</td>
                    <td
                        style="border: 1px solid #000000; background-color: #CCCCCC; font-weight: bold; text-align: center;">
                        FIELD</td>
                    <td
                        style="border: 1px solid #000000; background-color: #CCCCCC; font-weight: bold; text-align: center;">
                        MS</td>
                    <td
                        style="border: 1px solid #000000; background-color: #CCCCCC; font-weight: bold; text-align: center;">
                        OK/NOK</td>
                    <td colspan="4"
                        style="border: 1px solid #000000; background-color: #CCCCCC; font-weight: bold; text-align: center;">
                        PELAKSANA</td>
                </tr>

                {{-- ===== METERING DATA ROWS ===== --}}
                @php
                $pelaksanaRows = [
                ['fe' => $pelaksanaRtu[0]->nama_pelrtu ?? 'Field Eng. 01', 'ms' => $pelaksanaMs[0]->nama_picmaster ??
                'MS Eng. 01', 'disp' => 'Dispatcher 01'],
                ['fe' => $pelaksanaRtu[1]->nama_pelrtu ?? 'Field Eng. 02', 'ms' => $pelaksanaMs[1]->nama_picmaster ??
                'MS Eng. 02', 'disp' => 'Dispatcher 02'],
                ];
                $maxMeterRows = max(count($meteringData), count($pelaksanaRows) + 2);
                @endphp

                @for($i = 0; $i < $maxMeterRows; $i++) <tr>
                    {{-- Metering columns --}}
                    <td style="border: 1px solid #000000; text-align: center;">{{ $meteringData[$i]['ms'] ?? '' }}</td>
                    <td style="border: 1px solid #000000; text-align: center;">{{ $meteringData[$i]['rtu'] ?? '' }}</td>
                    <td style="border: 1px solid #000000;">{{ $meteringData[$i]['name'] ?? '' }}</td>
                    <td style="border: 1px solid #000000;">{{ $meteringData[$i]['field'] ?? '' }}</td>
                    <td style="border: 1px solid #000000; text-align: center;">{{ $meteringData[$i]['msVal'] ?? '' }}
                    </td>
                    <td style="border: 1px solid #000000; text-align: center;">
                        @if(in_array(1, $meteringData[$i]['checks'] ?? []))OK
                        @elseif(in_array(2, $meteringData[$i]['checks'] ?? []))NOK
                        @endif
                    </td>

                    {{-- Pelaksana columns --}}
                    @if($i == 0)
                    <td
                        style="border: 1px solid #000000; text-align: center; font-weight: bold; background-color: #E5E5E5;">
                        Field Engineer</td>
                    <td
                        style="border: 1px solid #000000; text-align: center; font-weight: bold; background-color: #E5E5E5;">
                        Master Station</td>
                    <td
                        style="border: 1px solid #000000; text-align: center; font-weight: bold; background-color: #E5E5E5;">
                        Dispatcher</td>
                    <td style="border: 1px solid #000000;"></td>
                    @elseif($i == 1)
                    <td style="border: 1px solid #000000; text-align: center;">{{ $pelaksanaRows[0]['fe'] }}</td>
                    <td style="border: 1px solid #000000; text-align: center;">{{ $pelaksanaRows[0]['ms'] }}</td>
                    <td style="border: 1px solid #000000; text-align: center;">{{ $pelaksanaRows[0]['disp'] }}</td>
                    <td style="border: 1px solid #000000;"></td>
                    @elseif($i == 2)
                    <td style="border: 1px solid #000000; text-align: center;">{{ $pelaksanaRows[1]['fe'] }}</td>
                    <td style="border: 1px solid #000000; text-align: center;">{{ $pelaksanaRows[1]['ms'] }}</td>
                    <td style="border: 1px solid #000000; text-align: center;">{{ $pelaksanaRows[1]['disp'] }}</td>
                    <td style="border: 1px solid #000000;"></td>
                    @else
                    <td style="border: 1px solid #000000;"></td>
                    <td style="border: 1px solid #000000;"></td>
                    <td style="border: 1px solid #000000;"></td>
                    <td style="border: 1px solid #000000;"></td>
                    @endif
                    </tr>
                    @endfor

                    {{-- Page break spacer --}}
                    @if(!$loop->last)
                    <tr>
                        <td colspan="10" style="height: 50px;"></td>
                    </tr>
                    @endif
    </table>

    @endforeach
</body>

</html>
