<!DOCTYPE html>
<html lang="id">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style>
    /* CSS Class ini hanya backup, yang utama adalah inline style di elemen */
    .borders {
        border: 1px solid #000000;
    }

    .bg-gray {
        background-color: #d1d5db;
    }

    .text-center {
        text-align: center;
    }

    .text-bold {
        font-weight: bold;
    }

    .valign-middle {
        vertical-align: middle;
    }

    .valign-top {
        vertical-align: top;
    }
    </style>
</head>

<body>
    @foreach($keypoints as $index => $data)
    @php
    $row = $data['row'];
    // Data helpers
    $pelaksanaMs = $data['pelaksanaMs'];
    $pelaksanaRtu = $data['pelaksanaRtu'];
    $statusData = $data['statusData'];
    $controlData = $data['controlData'];
    $meteringData = $data['meteringData'];
    $hardwareData = $data['hardwareData'];
    $systemData = $data['systemData'];
    $recloserData = $data['recloserData'];
    @endphp

    {{-- WRAPPER TABLE UTAMA PER HALAMAN --}}
    <table>
        {{-- ===== HEADER SECTION ===== --}}
        <tr>
            {{-- Logo & Identitas (Kolom A-C kira-kira) --}}
            <td colspan="4" rowspan="3" class="borders text-center valign-middle"
                style="border: 1px solid #000000; vertical-align: middle; text-align: center;">
                <strong>PT PLN (PERSERO)<br>DISTRIBUSI JAWA TIMUR</strong><br>
                JL. EMBONG TRENGGULI NO. 19 - 21<br>
                SURABAYA | TLP: (031) 53406531
            </td>
            {{-- Form Standart (Kolom D-F) --}}
            <td colspan="4" rowspan="3" class="borders text-center valign-middle"
                style="border: 1px solid #000000; vertical-align: middle; text-align: center;">
                <strong>FORM<br>STANDART</strong>
            </td>
            {{-- Doc Info (Kolom G-J) --}}
            <td colspan="2" class="borders bg-gray text-bold"
                style="border: 1px solid #000000; background-color: #cccccc;">NO. DOKUMEN</td>
            <td colspan="3" class="borders" style="border: 1px solid #000000;">HAL : {{ $index + 1 }}</td>
        </tr>
        <tr>
            <td colspan="2" rowspan="2" class="borders text-center text-bold"
                style="border: 1px solid #000000; text-align: center; font-size: 14px;">FS.SCA.01.17</td>
            <td colspan="3" class="borders" style="border: 1px solid #000000;">TGL :
                {{ $row->tgl_komisioning_formatted }}</td>
        </tr>
        <tr>
            <td colspan="3" class="borders" style="border: 1px solid #000000;">REV : 0</td>
        </tr>

        {{-- Spacer Row --}}
        <tr>
            <td colspan="13"></td>
        </tr>

        {{-- ===== TITLE ===== --}}
        <tr>
            <td colspan="13" class="text-center" style="text-align: center;">
                <u style="font-weight: bold; font-size: 14px;">TES POINT TO POINT LBS</u><br>
                <strong>FORM KOMISIONING KEYPOINT</strong>
            </td>
        </tr>

        {{-- Spacer Row --}}
        <tr>
            <td colspan="13"></td>
        </tr>

        {{-- ===== DEVICE INFO (Menggunakan Grid Excel, bukan nested table) ===== --}}
        <tr>
            <td colspan="2" style="border: 1px solid #000000;">Nama LBS / REC.</td>
            <td colspan="2" style="border: 1px solid #000000;">: <strong>{{ $row->nama_keypoint }}</strong></td>

            <td colspan="2" style="border: 1px solid #000000;">Modem</td>
            <td colspan="2" style="border: 1px solid #000000;">: <strong>{{ $row->nama_modem }}</strong></td>

            <td colspan="2" style="border: 1px solid #000000;">Gardu Induk</td>
            <td colspan="3" style="border: 1px solid #000000;">: <strong>{{ $row->gardu_induk }}</strong></td>
        </tr>
        <tr>
            <td colspan="2" style="border: 1px solid #000000;">Merk</td>
            <td colspan="2" style="border: 1px solid #000000;">: <strong>{{ $row->nama_merklbs }}</strong></td>

            <td colspan="2" style="border: 1px solid #000000;">IP / No. Kartu</td>
            <td colspan="2" style="border: 1px solid #000000;">: <strong>{{ $row->ip_rtu }}</strong></td>

            <td colspan="2" style="border: 1px solid #000000;">Penyulang</td>
            <td colspan="3" style="border: 1px solid #000000;">: <strong>{{ $row->penyulang }}</strong></td>
        </tr>
        <tr>
            <td colspan="2" style="border: 1px solid #000000;">Protocol</td>
            <td colspan="2" style="border: 1px solid #000000;">: <strong>{{ $row->alamat_rtu }}</strong></td>

            <td colspan="2" style="border: 1px solid #000000;">Koordinat</td>
            <td colspan="2" style="border: 1px solid #000000;">: <strong>-</strong></td>

            <td colspan="2" style="border: 1px solid #000000;">Tanggal</td>
            <td colspan="3" style="border: 1px solid #000000;">: <strong>{{ $row->tgl_komisioning_formatted }}</strong>
            </td>
        </tr>

        {{-- Spacer Row --}}
        <tr>
            <td colspan="13"></td>
        </tr>

        {{-- ===== MAIN DATA CONTENT ===== --}}
        {{--
           Strategi: Kita buat Layout Kiri dan Kanan Terpisah dengan Cell Kosong di tengah sebagai pemisah
           Excel sangat sulit merender 2 tabel berdampingan dalam 1 row jika tinggi barisnya beda.
           Kita akan menggunakan table wrapper.
        --}}

        <tr>
            {{-- KOLOM KIRI (STATUS, CONTROL, METERING) --}}
            <td colspan="7" valign="top">
                {{-- TABEL STATUS --}}
                <table style="border-collapse: collapse; width: 100%;">
                    <thead>
                        <tr>
                            <th style="border: 1px solid #000; background-color: #cccccc;">ADD-MS</th>
                            <th style="border: 1px solid #000; background-color: #cccccc;">ADD-RTU</th>
                            <th style="border: 1px solid #000; background-color: #cccccc;">STATUS</th>
                            <th style="border: 1px solid #000; background-color: #cccccc;">VALUE</th>
                            <th style="border: 1px solid #000; background-color: #cccccc;">OK</th>
                            <th style="border: 1px solid #000; background-color: #cccccc;">NOK</th>
                            <th style="border: 1px solid #000; background-color: #cccccc;">KET</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($statusData as $item)
                        @foreach(['row1', 'row2'] as $r)
                        @if(isset($item[$r]))
                        <tr>
                            <td style="border: 1px solid #000;">{{ $item[$r]['ms'] }}</td>
                            <td style="border: 1px solid #000;">{{ $item[$r]['rtu'] }}</td>
                            <td style="border: 1px solid #000;">{{ $item['name'] }}</td>
                            <td style="border: 1px solid #000;">{{ $item[$r]['label'] }}</td>
                            <td style="border: 1px solid #000; text-align: center;">
                                {{ in_array(1, $item[$r]['checks']) ? 'v' : '' }}</td>
                            <td style="border: 1px solid #000; text-align: center;">
                                {{ in_array(2, $item[$r]['checks']) ? 'v' : '' }}</td>
                            <td style="border: 1px solid #000;"></td>
                        </tr>
                        @endif
                        @endforeach
                        @endforeach
                    </tbody>
                </table>
                <br>
                {{-- TABEL CONTROL --}}
                <table style="border-collapse: collapse; width: 100%;">
                    <thead>
                        <tr>
                            <th style="border: 1px solid #000; background-color: #cccccc;">ADD-MS</th>
                            <th style="border: 1px solid #000; background-color: #cccccc;">ADD-RTU</th>
                            <th style="border: 1px solid #000; background-color: #cccccc;">CTRL</th>
                            <th style="border: 1px solid #000; background-color: #cccccc;">VALUE</th>
                            <th style="border: 1px solid #000; background-color: #cccccc;">OK</th>
                            <th style="border: 1px solid #000; background-color: #cccccc;">NOK</th>
                            <th style="border: 1px solid #000; background-color: #cccccc;">KET</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($controlData as $item)
                        {{-- Loop manual untuk row1/row2 agar border aman --}}
                        <tr>
                            <td style="border: 1px solid #000;">{{ $item['row1']['ms'] ?? '' }}</td>
                            <td style="border: 1px solid #000;">{{ $item['row1']['rtu'] ?? '' }}</td>
                            <td style="border: 1px solid #000;">{{ $item['name'] }}</td>
                            <td style="border: 1px solid #000;">{{ $item['row1']['label'] ?? '' }}</td>
                            <td style="border: 1px solid #000; text-align: center;">
                                {{ in_array(1, $item['row1']['checks'] ?? []) ? 'v' : '' }}</td>
                            <td style="border: 1px solid #000; text-align: center;">
                                {{ in_array(2, $item['row1']['checks'] ?? []) ? 'v' : '' }}</td>
                            <td style="border: 1px solid #000;"></td>
                        </tr>
                        @if(!($item['single'] ?? false))
                        <tr>
                            <td style="border: 1px solid #000;">{{ $item['row2']['ms'] ?? '' }}</td>
                            <td style="border: 1px solid #000;">{{ $item['row2']['rtu'] ?? '' }}</td>
                            <td style="border: 1px solid #000;">{{ $item['name'] }}</td>
                            <td style="border: 1px solid #000;">{{ $item['row2']['label'] ?? '' }}</td>
                            <td style="border: 1px solid #000; text-align: center;">
                                {{ in_array(1, $item['row2']['checks'] ?? []) ? 'v' : '' }}</td>
                            <td style="border: 1px solid #000; text-align: center;">
                                {{ in_array(2, $item['row2']['checks'] ?? []) ? 'v' : '' }}</td>
                            <td style="border: 1px solid #000;"></td>
                        </tr>
                        @endif
                        @endforeach
                    </tbody>
                </table>
                <br>
                {{-- TABEL METERING --}}
                <table style="border-collapse: collapse; width: 100%;">
                    <thead>
                        <tr>
                            <th style="border: 1px solid #000; background-color: #cccccc;">ADD-MS</th>
                            <th style="border: 1px solid #000; background-color: #cccccc;">ADD-RTU</th>
                            <th style="border: 1px solid #000; background-color: #cccccc;">METER</th>
                            <th style="border: 1px solid #000; background-color: #cccccc;">FIELD</th>
                            <th style="border: 1px solid #000; background-color: #cccccc;">MS</th>
                            <th style="border: 1px solid #000; background-color: #cccccc;">OK/NOK</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($meteringData as $meter)
                        <tr>
                            <td style="border: 1px solid #000;">
                                {{ $meter['ms'] ?? ($meter['isPseudo'] ? 'Pseudo' : '') }}</td>
                            <td style="border: 1px solid #000;">{{ $meter['rtu'] ?? '' }}</td>
                            <td style="border: 1px solid #000;">{{ $meter['name'] ?? '' }}</td>
                            <td style="border: 1px solid #000;">{{ $meter['field'] ?? '' }}</td>
                            <td style="border: 1px solid #000;">{{ $meter['msVal'] ?? '' }}</td>
                            <td style="border: 1px solid #000; text-align: center;">
                                @if(in_array(1, $meter['checks'] ?? [])) OK
                                @elseif(in_array(2, $meter['checks'] ?? [])) NOK
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </td>

            {{-- SPACER COLUMN --}}
            <td style="width: 20px;"></td>

            {{-- KOLOM KANAN (HARDWARE, SYSTEM, RECLOSER, PELAKSANA) --}}
            <td colspan="5" valign="top">
                {{-- HARDWARE --}}
                <table style="border-collapse: collapse; width: 100%;">
                    <thead>
                        <tr>
                            <th colspan="4" style="border: 1px solid #000; background-color: #cccccc; text-align:left;">
                                Hardware</th>
                        </tr>
                        <tr>
                            <th style="border: 1px solid #000;">Item</th>
                            <th style="border: 1px solid #000;">OK/NOK</th>
                            <th style="border: 1px solid #000;">Value</th>
                            <th style="border: 1px solid #000;">Ket</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach([
                        ['name' => 'Batere', 'idx' => 0],
                        ['name' => 'PS 220', 'idx' => 1],
                        ['name' => 'Charger', 'idx' => 2],
                        ['name' => 'Limit Switch', 'idx' => 3],
                        ] as $hw)
                        <tr>
                            <td style="border: 1px solid #000;">{{ $hw['name'] }}</td>
                            <td style="border: 1px solid #000; text-align:center;">
                                {{ $hardwareData[$hw['idx']]['status'] ?? '' }}</td>
                            <td style="border: 1px solid #000; text-align:center;">
                                {{ $hardwareData[$hw['idx']]['value'] ?? '' }}</td>
                            <td style="border: 1px solid #000;"></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <br>

                {{-- SYSTEM --}}
                <table style="border-collapse: collapse; width: 100%;">
                    <thead>
                        <tr>
                            <th colspan="4" style="border: 1px solid #000; background-color: #cccccc; text-align:left;">
                                System</th>
                        </tr>
                        <tr>
                            <th style="border: 1px solid #000;">Item</th>
                            <th style="border: 1px solid #000;">OK/NOK</th>
                            <th style="border: 1px solid #000;">Value</th>
                            <th style="border: 1px solid #000;">Ket</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach([
                        ['name' => 'COMF', 'idx' => 0],
                        ['name' => 'LRUF', 'idx' => 1],
                        ['name' => 'SIGN S', 'idx' => 2],
                        ['name' => 'Limit Switch', 'idx' => 3],
                        ] as $sys)
                        <tr>
                            <td style="border: 1px solid #000;">{{ $sys['name'] }}</td>
                            <td style="border: 1px solid #000; text-align:center;">
                                {{ $systemData[$sys['idx']]['status'] ?? '' }}</td>
                            <td style="border: 1px solid #000; text-align:center;">
                                {{ $systemData[$sys['idx']]['value'] ?? '' }}</td>
                            <td style="border: 1px solid #000;"></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <br>

                {{-- PELAKSANA --}}
                <table style="border-collapse: collapse; width: 100%;">
                    <thead>
                        <tr>
                            <th colspan="3" style="border: 1px solid #000; background-color: #cccccc; text-align:left;">
                                PELAKSANA :</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr style="height: 60px;">
                            <td
                                style="border: 1px solid #000; height: 60px; vertical-align: bottom; text-align: center;">
                                <u>{{ $pelaksanaRtu[0]->nama_pelrtu ?? 'Field Eng. 01' }}</u><br>Field Engineer
                            </td>
                            <td
                                style="border: 1px solid #000; height: 60px; vertical-align: bottom; text-align: center;">
                                <u>{{ $pelaksanaMs[0]->nama_picmaster ?? 'MS Eng. 01' }}</u><br>Master Station
                            </td>
                            <td
                                style="border: 1px solid #000; height: 60px; vertical-align: bottom; text-align: center;">
                                <u>Dispatcher 01</u><br>Dispatcher
                            </td>
                        </tr>
                        <tr style="height: 60px;">
                            <td
                                style="border: 1px solid #000; height: 60px; vertical-align: bottom; text-align: center;">
                                <u>{{ $pelaksanaRtu[1]->nama_pelrtu ?? 'Field Eng. 02' }}</u><br>Field Engineer
                            </td>
                            <td
                                style="border: 1px solid #000; height: 60px; vertical-align: bottom; text-align: center;">
                                <u>{{ $pelaksanaMs[1]->nama_picmaster ?? 'MS Eng. 02' }}</u><br>Master Station
                            </td>
                            <td
                                style="border: 1px solid #000; height: 60px; vertical-align: bottom; text-align: center;">
                                <u>Dispatcher 02</u><br>Dispatcher
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </table>

    {{-- Jarak antar Record --}}
    <br><br>
    @endforeach

</body>

</html>
