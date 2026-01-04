<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Form Penyulangan - {{ $row->nama_peny ?? 'Detail' }}</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        font-size: 10pt;
    }

    table {
        border-collapse: collapse;
        width: 100%;
    }

    td,
    th {
        border: 1px solid #000000;
        padding: 4px 6px;
        vertical-align: middle;
    }

    .no-border {
        border: none !important;
    }

    .no-border td,
    .no-border th {
        border: none !important;
    }

    .border-bottom {
        border-bottom: 1px solid #000000 !important;
    }

    .text-center {
        text-align: center;
    }

    .text-left {
        text-align: left;
    }

    .text-right {
        text-align: right;
    }

    .font-bold {
        font-weight: bold;
    }

    .bg-gray {
        background-color: #d1d5db;
    }

    .bg-yellow {
        background-color: #fef3c7;
    }

    .bg-green {
        background-color: #d1fae5;
    }

    .bg-blue {
        background-color: #dbeafe;
    }

    .text-green {
        color: #16a34a;
    }

    .text-red {
        color: #dc2626;
    }

    .text-blue {
        color: #2563eb;
    }

    .text-orange {
        color: #ea580c;
    }

    .header-title {
        font-size: 14pt;
        font-weight: bold;
    }

    .section-title {
        font-size: 11pt;
        font-weight: bold;
        background-color: #d1d5db;
    }

    .check-ok {
        color: #16a34a;
        font-weight: bold;
    }

    .check-nok {
        color: #dc2626;
        font-weight: bold;
    }

    .check-log {
        color: #2563eb;
        font-weight: bold;
    }

    .check-sld {
        color: #ea580c;
        font-weight: bold;
    }

    .v-top {
        vertical-align: top;
    }

    .v-bottom {
        vertical-align: bottom;
    }
    </style>
</head>

<body>

    {{-- ===== HEADER SECTION ===== --}}
    <table class="no-border" style="margin-bottom: 10px;">
        <tr>
            <td class="no-border" style="width: 20%;">
                <strong style="font-size: 16pt;">PLN</strong>
            </td>
            <td class="no-border" style="width: 50%;">
                <strong style="font-size: 14pt;">PT PLN (PERSERO)</strong><br>
                <strong style="font-size: 14pt;">DISTRIBUSI JAWA TIMUR</strong><br>
                <span style="font-size: 10pt;">JL. EMBONG TRENGGULI NO. 19 - 21, SURABAYA</span>
            </td>
            <td class="no-border text-right" style="width: 30%;">
                <strong>NO. DOKUMEN: FS.SCA.01.18</strong><br>
                <span>HAL: 1 - 3</span><br>
                <span>TGL: {{ $row->tgl_kom ?? date('d-m-Y') }}</span><br>
                <span>REV: 0</span>
            </td>
        </tr>
    </table>

    {{-- ===== TITLE ===== --}}
    <table class="no-border" style="margin-bottom: 10px;">
        <tr>
            <td class="no-border text-center">
                <strong style="font-size: 14pt; text-decoration: underline;">TES POINT TO POINT PENYULANG</strong><br>
                <strong style="font-size: 12pt;">FORM KOMISIONING PENYULANGAN</strong>
            </td>
        </tr>
    </table>

    {{-- ===== DEVICE INFO ===== --}}
    <table style="margin-bottom: 15px;">
        <tr>
            <td class="bg-gray font-bold" style="width: 15%;">Nama Penyulang</td>
            <td style="width: 18%;">{{ $row->nama_peny ?? '-' }}</td>
            <td class="bg-gray font-bold" style="width: 15%;">Protocol / Address</td>
            <td style="width: 18%;">{{ $row->rtu_addrs ?? '-' }}</td>
            <td class="bg-gray font-bold" style="width: 16%;">Tanggal Komisioning</td>
            <td style="width: 18%;">{{ $row->tgl_kom ?? '-' }}</td>
        </tr>
        <tr>
            <td class="bg-gray font-bold">Gardu Induk</td>
            <td>{{ $row->id_gi ?? '-' }}</td>
            <td class="bg-gray font-bold">Media Komunikasi</td>
            <td>{{ $row->nama_medkom ?? '-' }}</td>
            <td class="bg-gray font-bold">Master Station</td>
            <td>{{ $row->nama_user ?? '-' }}</td>
        </tr>
        <tr>
            <td class="bg-gray font-bold">RTU GI</td>
            <td>{{ $row->nama_rtugi ?? $row->id_rtugi ?? '-' }}</td>
            <td class="bg-gray font-bold">Jenis Komisioning</td>
            <td>{{ $row->jenis_komkp ?? '-' }}</td>
            <td class="bg-gray font-bold">Last Update</td>
            <td>{{ $row->lastupdate ?? '-' }}</td>
        </tr>
    </table>

    {{-- ===== STATUS TABLE ===== --}}
    <table style="margin-bottom: 15px;">
        <thead>
            <tr class="bg-gray">
                <th style="width: 12%;">ADDRESS</th>
                <th style="width: 8%;">OBJ</th>
                <th style="width: 10%;">STATUS</th>
                <th style="width: 10%;">VALUE</th>
                <th style="width: 6%;">OK</th>
                <th style="width: 6%;">NOK</th>
                <th style="width: 6%;">LOG</th>
                <th style="width: 6%;">SLD</th>
                <th style="width: 36%;">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($statusData as $index => $item)
            {{-- Row 1 --}}
            <tr>
                <td class="text-center">{{ $item['row1']['address'] }}</td>
                <td class="text-center">{{ $item['row1']['obj'] }}</td>
                <td rowspan="2" class="text-center font-bold bg-blue">{{ $item['name'] }}</td>
                <td class="text-center">{{ $item['row1']['label'] }}</td>
                <td class="text-center">
                    @if(in_array(1, $item['row1']['checks'] ?? []))
                    <span class="check-ok">✓</span>
                    @endif
                </td>
                <td class="text-center">
                    @if(in_array(2, $item['row1']['checks'] ?? []))
                    <span class="check-nok">✓</span>
                    @endif
                </td>
                <td class="text-center">
                    @if(in_array(3, $item['row1']['checks'] ?? []))
                    <span class="check-log">✓</span>
                    @endif
                </td>
                <td class="text-center">
                    @if(in_array(4, $item['row1']['checks'] ?? []))
                    <span class="check-sld">✓</span>
                    @endif
                </td>
                @if($index == 0)
                <td rowspan="{{ count($statusData) * 2 }}" class="text-left v-top">
                    {{ $row->ketfts ?? '' }}
                </td>
                @endif
            </tr>
            {{-- Row 2 --}}
            <tr>
                <td class="text-center">{{ $item['row2']['address'] }}</td>
                <td class="text-center">{{ $item['row2']['obj'] }}</td>
                <td class="text-center">{{ $item['row2']['label'] }}</td>
                <td class="text-center">
                    @if(in_array(1, $item['row2']['checks'] ?? []))
                    <span class="check-ok">✓</span>
                    @endif
                </td>
                <td class="text-center">
                    @if(in_array(2, $item['row2']['checks'] ?? []))
                    <span class="check-nok">✓</span>
                    @endif
                </td>
                <td class="text-center">
                    @if(in_array(3, $item['row2']['checks'] ?? []))
                    <span class="check-log">✓</span>
                    @endif
                </td>
                <td class="text-center">
                    @if(in_array(4, $item['row2']['checks'] ?? []))
                    <span class="check-sld">✓</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{-- ===== CONTROL TABLE ===== --}}
    <table style="margin-bottom: 15px;">
        <thead>
            <tr class="bg-gray">
                <th style="width: 12%;">ADDRESS</th>
                <th style="width: 8%;">OBJ</th>
                <th style="width: 10%;">CTRL</th>
                <th style="width: 10%;">VALUE</th>
                <th style="width: 6%;">OK</th>
                <th style="width: 6%;">NOK</th>
                <th style="width: 6%;">LOG</th>
                <th style="width: 6%;">SLD</th>
                <th style="width: 36%;">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @php
            $controlRowCount = 0;
            foreach($controlData as $item) {
            $controlRowCount += isset($item['single']) && $item['single'] ? 1 : 2;
            }
            @endphp

            @foreach($controlData as $index => $item)
            @if(isset($item['single']) && $item['single'])
            {{-- Single Row (Reset) --}}
            <tr>
                <td class="text-center">{{ $item['row1']['address'] }}</td>
                <td class="text-center">{{ $item['row1']['obj'] }}</td>
                <td class="text-center font-bold bg-green">{{ $item['name'] }}</td>
                <td class="text-center">{{ $item['row1']['label'] }}</td>
                <td class="text-center">
                    @if(in_array(1, $item['row1']['checks'] ?? []))
                    <span class="check-ok">✓</span>
                    @endif
                </td>
                <td class="text-center">
                    @if(in_array(2, $item['row1']['checks'] ?? []))
                    <span class="check-nok">✓</span>
                    @endif
                </td>
                <td class="text-center">
                    @if(in_array(3, $item['row1']['checks'] ?? []))
                    <span class="check-log">✓</span>
                    @endif
                </td>
                <td class="text-center">
                    @if(in_array(4, $item['row1']['checks'] ?? []))
                    <span class="check-sld">✓</span>
                    @endif
                </td>
                @if($index == 0)
                <td rowspan="{{ $controlRowCount }}" class="text-left v-top">
                    {{ $row->ketftc ?? '' }}
                </td>
                @endif
            </tr>
            @else
            {{-- Row 1 --}}
            <tr>
                <td class="text-center">{{ $item['row1']['address'] }}</td>
                <td class="text-center">{{ $item['row1']['obj'] }}</td>
                <td rowspan="2" class="text-center font-bold bg-green">{{ $item['name'] }}</td>
                <td class="text-center">{{ $item['row1']['label'] }}</td>
                <td class="text-center">
                    @if(in_array(1, $item['row1']['checks'] ?? []))
                    <span class="check-ok">✓</span>
                    @endif
                </td>
                <td class="text-center">
                    @if(in_array(2, $item['row1']['checks'] ?? []))
                    <span class="check-nok">✓</span>
                    @endif
                </td>
                <td class="text-center">
                    @if(in_array(3, $item['row1']['checks'] ?? []))
                    <span class="check-log">✓</span>
                    @endif
                </td>
                <td class="text-center">
                    @if(in_array(4, $item['row1']['checks'] ?? []))
                    <span class="check-sld">✓</span>
                    @endif
                </td>
                @if($index == 0)
                <td rowspan="{{ $controlRowCount }}" class="text-left v-top">
                    {{ $row->ketftc ?? '' }}
                </td>
                @endif
            </tr>
            {{-- Row 2 --}}
            <tr>
                <td class="text-center">{{ $item['row2']['address'] ?? '' }}</td>
                <td class="text-center">{{ $item['row2']['obj'] ?? '' }}</td>
                <td class="text-center">{{ $item['row2']['label'] ?? '' }}</td>
                <td class="text-center">
                    @if(in_array(1, $item['row2']['checks'] ?? []))
                    <span class="check-ok">✓</span>
                    @endif
                </td>
                <td class="text-center">
                    @if(in_array(2, $item['row2']['checks'] ?? []))
                    <span class="check-nok">✓</span>
                    @endif
                </td>
                <td class="text-center">
                    @if(in_array(3, $item['row2']['checks'] ?? []))
                    <span class="check-log">✓</span>
                    @endif
                </td>
                <td class="text-center">
                    @if(in_array(4, $item['row2']['checks'] ?? []))
                    <span class="check-sld">✓</span>
                    @endif
                </td>
            </tr>
            @endif
            @endforeach
        </tbody>
    </table>

    {{-- ===== METERING TABLE ===== --}}
    <table style="margin-bottom: 15px;">
        <thead>
            <tr class="bg-gray">
                <th style="width: 12%;">ADDRESS</th>
                <th style="width: 8%;">OBJ</th>
                <th style="width: 10%;">METER</th>
                <th style="width: 9%;">RTU</th>
                <th style="width: 9%;">MS</th>
                <th style="width: 8%;">SCALE</th>
                <th style="width: 8%;">OK/NOK</th>
                <th style="width: 6%;">SLD</th>
                <th style="width: 30%;">Keterangan</th>
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
            <tr class="{{ ($meter['isPseudo'] ?? false) ? 'bg-yellow' : '' }}">
                {{-- ADDRESS Column --}}
                @if($meter['isPseudo'] ?? false)
                <td class="text-center bg-gray font-bold">Pseudo</td>
                @else
                <td class="text-center">{{ $meter['address'] ?? '' }}</td>
                @endif

                {{-- OBJ Column --}}
                <td class="text-center">{{ $meter['obj'] ?? '' }}</td>

                {{-- METER Name Column --}}
                <td class="text-center font-bold">{{ $meter['name'] ?? '' }}</td>

                {{-- RTU Column --}}
                <td class="text-center">{{ $meter['rtu'] ?? '' }}</td>

                {{-- MS Column --}}
                <td class="text-center">{{ $meter['ms'] ?? '' }}</td>

                {{-- SCALE Column --}}
                <td class="text-center">{{ $meter['scale'] ?? '' }}</td>

                {{-- OK/NOK Column --}}
                <td class="text-center">
                    @if($hasOk)
                    <span class="check-ok">OK</span>
                    @elseif($hasNok)
                    <span class="check-nok">NOK</span>
                    @else
                    <span style="color: #9ca3af;">-</span>
                    @endif
                </td>

                {{-- SLD Column --}}
                <td class="text-center">
                    @if($hasSld)
                    <span class="check-sld">✓</span>
                    @else
                    <span style="color: #9ca3af;">-</span>
                    @endif
                </td>

                {{-- Ket Column --}}
                @if($index === 0)
                <td rowspan="{{ count($meteringData) }}" class="text-left v-top">
                    {{ $row->ketftm ?? '' }}
                </td>
                @endif
            </tr>
            @endforeach
        </tbody>
    </table>

    {{-- ===== ADDITIONAL INFO SECTION ===== --}}
    <table style="margin-bottom: 15px;">
        <tr>
            <td class="bg-gray font-bold" style="width: 20%;">KETERANGAN FORM DATA</td>
            <td style="width: 80%;" class="v-top">{{ $row->ketfd ?? '-' }}</td>
        </tr>
        <tr>
            <td class="bg-gray font-bold">PIC KOMISIONING</td>
            <td class="v-top">{{ $row->ketpk ?? '-' }}</td>
        </tr>
        <tr>
            <td class="bg-gray font-bold">CATATAN</td>
            <td class="v-top">{{ $row->catatanpeny ?? '-' }}</td>
        </tr>
    </table>

    {{-- ===== PELAKSANA SECTION ===== --}}
    <table style="margin-bottom: 15px;">
        <tr>
            <td colspan="6" class="bg-gray font-bold">PELAKSANA :</td>
        </tr>
        <tr>
            <td class="text-center font-bold bg-blue" style="width: 16.66%;">Field Engineer 01</td>
            <td class="text-center font-bold bg-blue" style="width: 16.66%;">Field Engineer 02</td>
            <td class="text-center font-bold bg-green" style="width: 16.66%;">MS Engineer 01</td>
            <td class="text-center font-bold bg-green" style="width: 16.66%;">MS Engineer 02</td>
            <td class="text-center font-bold bg-yellow" style="width: 16.66%;">Dispatcher 01</td>
            <td class="text-center font-bold bg-yellow" style="width: 16.66%;">Dispatcher 02</td>
        </tr>
        <tr>
            <td class="text-center" style="height: 60px; vertical-align: bottom;">
                @if(isset($pelaksanaRtu[0]))
                <strong>{{ $pelaksanaRtu[0]->nama_pelrtu ?? '-' }}</strong>
                @else
                <span style="color: #9ca3af;">-</span>
                @endif
            </td>
            <td class="text-center" style="height: 60px; vertical-align: bottom;">
                @if(isset($pelaksanaRtu[1]))
                <strong>{{ $pelaksanaRtu[1]->nama_pelrtu ?? '-' }}</strong>
                @else
                <span style="color: #9ca3af;">-</span>
                @endif
            </td>
            <td class="text-center" style="height: 60px; vertical-align: bottom;">
                @if(isset($pelaksanaMs[0]))
                <strong>{{ $pelaksanaMs[0]->nama_picmaster ?? '-' }}</strong>
                @else
                <span style="color: #9ca3af;">-</span>
                @endif
            </td>
            <td class="text-center" style="height: 60px; vertical-align: bottom;">
                @if(isset($pelaksanaMs[1]))
                <strong>{{ $pelaksanaMs[1]->nama_picmaster ?? '-' }}</strong>
                @else
                <span style="color: #9ca3af;">-</span>
                @endif
            </td>
            <td class="text-center" style="height: 60px; vertical-align: bottom;">
                <span style="color: #9ca3af;">________________</span>
            </td>
            <td class="text-center" style="height: 60px; vertical-align: bottom;">
                <span style="color: #9ca3af;">________________</span>
            </td>
        </tr>
    </table>

    {{-- ===== FOOTER ===== --}}
    <table class="no-border">
        <tr>
            <td class="no-border text-center" style="font-style: italic; font-size: 9pt; color: #666;">
                Apabila dokumen ini didownload / dicetak maka akan menjadi "DOKUMEN TIDAK TERKENDALI"
            </td>
        </tr>
    </table>

</body>

</html>
