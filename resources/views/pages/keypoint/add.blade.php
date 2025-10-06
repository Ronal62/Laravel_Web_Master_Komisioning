@extends('layout.app')

@section('title', 'Tambah Data Keypoint')

@section('content')
<div class="page-inner">
    <div class="page-header">
        <div class="section-header-back">
            <a href="{{ route('keypoint.index') }}" class="btn"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h3 class="fw-bold">Tambah Data Keypoint</h3>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Tambah Data Keypoint</h4>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <form action="{{ route('keypoint.store') }}" method="POST" autocomplete="off">
                        @csrf
                        <div class="row">
                            <div class="col-5 col-md-2">
                                <div class="nav flex-column nav-pills nav-secondary nav-pills-no-bd"
                                    id="v-pills-tab-without-border" role="tablist" aria-orientation="vertical">
                                    <a class="nav-link active" id="v-pills-formdata-tab-nobd" data-bs-toggle="pill"
                                        href="#v-pills-formdata-nobd" role="tab" aria-controls="v-pills-formdata-nobd"
                                        aria-selected="true">Form Data</a>
                                    <a class="nav-link" id="v-pills-formtelestatus-tab-nobd" data-bs-toggle="pill"
                                        href="#v-pills-formtelestatus-nobd" role="tab"
                                        aria-controls="v-pills-formtelestatus-nobd" aria-selected="false">Form
                                        Telestatus</a>
                                    <a class="nav-link" id="v-pills-formtelecontrol-tab-nobd" data-bs-toggle="pill"
                                        href="#v-pills-formtelecontrol-nobd" role="tab"
                                        aria-controls="v-pills-formtelecontrol-nobd" aria-selected="false">Form
                                        Telecontrol</a>
                                    <a class="nav-link" id="v-pills-formtelemetering-tab-nobd" data-bs-toggle="pill"
                                        href="#v-pills-formtelemetering-nobd" role="tab"
                                        aria-controls="v-pills-formtelemetering-nobd" aria-selected="false">Form
                                        Telemetering</a>
                                    <a class="nav-link" id="v-pills-pickomisioning-tab-nobd" data-bs-toggle="pill"
                                        href="#v-pills-pickomisioning-nobd" role="tab"
                                        aria-controls="v-pills-pickomisioning-nobd" aria-selected="false">PIC
                                        Komisioning</a>
                                </div>
                            </div>
                            <div class="col-7 col-md-10">
                                <div class="tab-content no-padding" id="myTab2Content">
                                    <!-- Form Data Tab -->
                                    <div class="tab-pane fade show active" id="v-pills-formdata-nobd" role="tabpanel"
                                        aria-labelledby="v-pills-formdata-tab-nobd">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="tgl_komisioning">Tanggal Komisioning</label>
                                                    <div class="input-icon">
                                                        <input type="date" class="form-control" id="tgl_komisioning"
                                                            name="tgl_komisioning" value="{{ old('tgl_komisioning') }}"
                                                            required />
                                                        @error('tgl_komisioning')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="nama_lbs">Nama Keypoint</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="nama_lbs"
                                                            name="nama_lbs" placeholder="Nama Keypoint"
                                                            value="{{ old('nama_lbs') }}" required />
                                                        @error('nama_lbs')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="id_merkrtu">Merk RTU</label>
                                                    <select class="form-select form-control" id="id_merkrtu"
                                                        name="id_merkrtu" required>
                                                        <option value="">Pilih Merk RTU</option>
                                                        @foreach ($merklbs as $merk)
                                                        <option value="{{ $merk->id_merkrtu }}"
                                                            {{ old('id_merkrtu') == $merk->id_merkrtu ? 'selected' : '' }}>
                                                            {{ $merk->nama_merklbs }}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                    @error('id_merkrtu')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label for="id_modem">Merk Modem</label>
                                                    <select class="form-select form-control" id="id_modem"
                                                        name="id_modem" required>
                                                        <option value="">Pilih Merk Modem</option>
                                                        @foreach ($modems as $modem)
                                                        <option value="{{ $modem->id_modem }}"
                                                            {{ old('id_modem') == $modem->id_modem ? 'selected' : '' }}>
                                                            {{ $modem->nama_modem }}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                    @error('id_modem')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label for="rtu_addrs">Protocol/RTU Address</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="rtu_addrs"
                                                            name="rtu_addrs" placeholder="Protocol/RTU Address"
                                                            value="{{ old('rtu_addrs') }}" />
                                                        @error('rtu_addrs')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="id_medkom">Media Komunikasi</label>
                                                    <select class="form-select form-control" id="id_medkom"
                                                        name="id_medkom" required>
                                                        <option value="">Pilih Media Komunikasi</option>
                                                        @foreach ($medkom as $media)
                                                        <option value="{{ $media->id_medkom }}"
                                                            {{ old('id_medkom') == $media->id_medkom ? 'selected' : '' }}>
                                                            {{ $media->nama_medkom }}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                    @error('id_medkom')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label for="ip_kp">IP Address/No. Kartu</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="ip_kp" name="ip_kp"
                                                            placeholder="IP Address/No. Kartu"
                                                            value="{{ old('ip_kp') }}" />
                                                        @error('ip_kp')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="id_gi">Gardu Induk</label>
                                                    <select class="form-select form-control" id="id_gi" name="id_gi"
                                                        required>
                                                        <option value="">Pilih Gardu Induk</option>
                                                        @foreach ($garduinduk as $gi)
                                                        <option value="{{ $gi->id_gi }}"
                                                            {{ old('id_gi') == $gi->id_gi ? 'selected' : '' }}>
                                                            {{ $gi->nama_gi }}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                    @error('id_gi')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label for="nama_peny">Penyulang</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="nama_peny"
                                                            name="nama_peny" placeholder="Penyulang"
                                                            value="{{ old('nama_peny') }}" />
                                                        @error('nama_peny')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="id_sec">Sectoral</label>
                                                    <select class="form-select form-control" id="id_sec" name="id_sec"
                                                        required>
                                                        <option value="">Pilih Sectoral</option>
                                                        @foreach ($sectoral as $sec)
                                                        <option value="{{ $sec->id_sec }}"
                                                            {{ old('id_sec') == $sec->id_sec ? 'selected' : '' }}>
                                                            {{ $sec->nama_sec }}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                    @error('id_sec')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Form Telestatus Tab -->
                                    <div class="tab-pane fade" id="v-pills-formtelestatus-nobd" role="tabpanel"
                                        aria-labelledby="v-pills-formtelestatus-tab-nobd">
                                        @foreach ([
                                        'scb' => ['label' => 'CB', 'states' => ['open_1' => 'OK', 'open_2' => 'NOK',
                                        'open_3' => 'LOG', 'open_4' => 'SLD', 'open_5' => 'TDK UJI'], 'open' => 'CB
                                        Open', 'close' => 'CB Close'],
                                        'scb2' => ['label' => 'CB 2', 'states' => ['open_1' => 'OK', 'open_2' => 'NOK',
                                        'open_3' => 'LOG', 'open_4' => 'SLD', 'open_5' => 'TDK UJI'], 'open' => 'CB 2
                                        Open', 'close' => 'CB 2 Close'],
                                        'slr' => ['label' => 'Local/Remote', 'states' => ['local_1' => 'OK', 'local_2'
                                        => 'NOK', 'local_3' => 'LOG', 'local_4' => 'SLD', 'local_5' => 'TDK UJI'],
                                        'open' => 'Local', 'close' => 'Remote'],
                                        'sdoor' => ['label' => 'Door', 'states' => ['dropen_1' => 'OK', 'dropen_2' =>
                                        'NOK', 'dropen_3' => 'LOG', 'dropen_4' => 'SLD', 'dropen_5' => 'TDK UJI'],
                                        'open' => 'Door Open', 'close' => 'Door Close'],
                                        'sacf' => ['label' => 'ACF', 'states' => ['acnrml_1' => 'OK', 'acnrml_2' =>
                                        'NOK', 'acnrml_3' => 'LOG', 'acnrml_4' => 'SLD', 'acnrml_5' => 'TDK UJI'],
                                        'open' => 'ACF Normal', 'close' => 'ACF Failed'],
                                        'sdcd' => ['label' => 'DCD', 'states' => ['dcnrml_1' => 'OK', 'dcnrml_2' =>
                                        'NOK', 'dcnrml_3' => 'LOG', 'dcnrml_4' => 'SLD', 'dcnrml_5' => 'TDK UJI'],
                                        'open' => 'DCD Normal', 'close' => 'DCD Failed'],
                                        'sdcf' => ['label' => 'DCF', 'states' => ['dcfnrml_1' => 'OK', 'dcfnrml_2' =>
                                        'NOK', 'dcfnrml_3' => 'LOG', 'dcfnrml_4' => 'SLD', 'dcfnrml_5' => 'TDK UJI'],
                                        'open' => 'DCF Normal', 'close' => 'DCF Failed'],
                                        'shlt' => ['label' => 'HLT', 'states' => ['hltoff_1' => 'OK', 'hltoff_2' =>
                                        'NOK', 'hltoff_3' => 'LOG', 'hltoff_4' => 'SLD', 'hltoff_5' => 'TDK UJI'],
                                        'open' => 'HLT OFF', 'close' => 'HLT ON'],
                                        'ssf6' => ['label' => 'SF6', 'states' => ['sf6nrml_1' => 'OK', 'sf6nrml_2' =>
                                        'NOK', 'sf6nrml_3' => 'LOG', 'sf6nrml_4' => 'SLD', 'sf6nrml_5' => 'TDK UJI'],
                                        'open' => 'SF6 Normal', 'close' => 'SF6 Failed'],
                                        'sfir' => ['label' => 'FIR', 'states' => ['firnrml_1' => 'OK', 'firnrml_2' =>
                                        'NOK', 'firnrml_3' => 'LOG', 'firnrml_4' => 'SLD', 'firnrml_5' => 'TDK UJI'],
                                        'open' => 'FIR Normal', 'close' => 'FIR Failed'],
                                        'sfis' => ['label' => 'FIS', 'states' => ['fisnrml_1' => 'OK', 'fisnrml_2' =>
                                        'NOK', 'fisnrml_3' => 'LOG', 'fisnrml_4' => 'SLD', 'fisnrml_5' => 'TDK UJI'],
                                        'open' => 'FIS Normal', 'close' => 'FIS Failed'],
                                        'sfit' => ['label' => 'FIT', 'states' => ['fitnrml_1' => 'OK', 'fitnrml_2' =>
                                        'NOK', 'fitnrml_3' => 'LOG', 'fitnrml_4' => 'SLD', 'fitnrml_5' => 'TDK UJI'],
                                        'open' => 'FIT Normal', 'close' => 'FIT Failed'],
                                        'sfin' => ['label' => 'FIN', 'states' => ['finnrml_1' => 'OK', 'finnrml_2' =>
                                        'NOK', 'finnrml_3' => 'LOG', 'finnrml_4' => 'SLD', 'finnrml_5' => 'TDK UJI'],
                                        'open' => 'FIN Normal', 'close' => 'FIN Failed']
                                        ] as $field => $data)
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-2 font-weight-bold">{{ $data['open'] }}</div>
                                                <div class="col custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input"
                                                        id="NORMAL{{ strtoupper($field) }}OPEN"
                                                        onchange="selectAllOption(this, 'option-{{ $field }}open')">
                                                    <label class="custom-control-label"
                                                        for="NORMAL{{ strtoupper($field) }}OPEN">NORMAL</label>
                                                </div>
                                                @foreach ($data['states'] as $value => $label)
                                                @php
                                                $onChangeOpen = in_array($value, ['open_1', 'open_3', 'open_4',
                                                'local_1', 'local_3', 'local_4', 'dropen_1', 'dropen_3', 'dropen_4',
                                                'acnrml_1', 'acnrml_3', 'acnrml_4', 'dcnrml_1', 'dcnrml_3', 'dcnrml_4',
                                                'dcfnrml_1', 'dcfnrml_3', 'dcfnrml_4', 'hltoff_1', 'hltoff_3',
                                                'hltoff_4', 'sf6nrml_1', 'sf6nrml_3', 'sf6nrml_4', 'firnrml_1',
                                                'firnrml_3', 'firnrml_4', 'fisnrml_1', 'fisnrml_3', 'fisnrml_4',
                                                'fitnrml_1', 'fitnrml_3', 'fitnrml_4', 'finnrml_1', 'finnrml_3',
                                                'finnrml_4'])
                                                ? "checkSelectAllOption('option-{$field}open',
                                                document.getElementById('NORMAL" . strtoupper($field) . "OPEN'))"
                                                : '';
                                                @endphp
                                                <div class="col custom-control custom-checkbox">
                                                    <input type="checkbox"
                                                        class="custom-control-input {{ in_array($value, ['open_1', 'open_3', 'open_4', 'local_1', 'local_3', 'local_4', 'dropen_1', 'dropen_3', 'dropen_4', 'acnrml_1', 'acnrml_3', 'acnrml_4', 'dcnrml_1', 'dcnrml_3', 'dcnrml_4', 'dcfnrml_1', 'dcfnrml_3', 'dcfnrml_4', 'hltoff_1', 'hltoff_3', 'hltoff_4', 'sf6nrml_1', 'sf6nrml_3', 'sf6nrml_4', 'firnrml_1', 'firnrml_3', 'firnrml_4', 'fisnrml_1', 'fisnrml_3', 'fisnrml_4', 'fitnrml_1', 'fitnrml_3', 'fitnrml_4', 'finnrml_1', 'finnrml_3', 'finnrml_4']) ? 'option-' . $field . 'open' : '' }}"
                                                        id="{{ strtoupper($label) }}{{ strtoupper($field) }}OPEN"
                                                        name="{{ $field }}[]" value="{{ $value }}"
                                                        @checked(in_array($value, old($field, [])))
                                                        onchange="{{ $onChangeOpen }}">
                                                    <label class="custom-control-label"
                                                        for="{{ strtoupper($label) }}{{ strtoupper($field) }}OPEN">{{ $label }}</label>
                                                </div>
                                                @endforeach
                                            </div>
                                            @error($field)
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-2 font-weight-bold">{{ $data['close'] }}</div>
                                                <div class="col custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input"
                                                        id="NORMAL{{ strtoupper($field) }}CLOSE"
                                                        onchange="selectAllOption(this, 'option-{{ $field }}close')">
                                                    <label class="custom-control-label"
                                                        for="NORMAL{{ strtoupper($field) }}CLOSE">NORMAL</label>
                                                </div>
                                                @foreach ($data['states'] as $value => $label)
                                                @php
                                                $closeValue = str_replace(['open', 'local', 'dropen', 'acnrml',
                                                'dcnrml', 'dcfnrml', 'hltoff', 'sf6nrml', 'firnrml', 'fisnrml',
                                                'fitnrml', 'finnrml'], ['close', 'remote', 'drclose', 'acfail',
                                                'dcfail', 'dcffail', 'hlton', 'sf6fail', 'firfail', 'fisfail',
                                                'fitfail', 'finfail'], $value);
                                                $onChangeClose = in_array($value, ['open_1', 'open_3', 'open_4',
                                                'local_1', 'local_3', 'local_4', 'dropen_1', 'dropen_3', 'dropen_4',
                                                'acnrml_1', 'acnrml_3', 'acnrml_4', 'dcnrml_1', 'dcnrml_3', 'dcnrml_4',
                                                'dcfnrml_1', 'dcfnrml_3', 'dcfnrml_4', 'hltoff_1', 'hltoff_3',
                                                'hltoff_4', 'sf6nrml_1', 'sf6nrml_3', 'sf6nrml_4', 'firnrml_1',
                                                'firnrml_3', 'firnrml_4', 'fisnrml_1', 'fisnrml_3', 'fisnrml_4',
                                                'fitnrml_1', 'fitnrml_3', 'fitnrml_4', 'finnrml_1', 'finnrml_3',
                                                'finnrml_4'])
                                                ? "checkSelectAllOption('option-{$field}close',
                                                document.getElementById('NORMAL" . strtoupper($field) . "CLOSE'))"
                                                : '';
                                                @endphp
                                                <div class="col custom-control custom-checkbox">
                                                    <input type="checkbox"
                                                        class="custom-control-input {{ in_array($value, ['open_1', 'open_3', 'open_4', 'local_1', 'local_3', 'local_4', 'dropen_1', 'dropen_3', 'dropen_4', 'acnrml_1', 'acnrml_3', 'acnrml_4', 'dcnrml_1', 'dcnrml_3', 'dcnrml_4', 'dcfnrml_1', 'dcfnrml_3', 'dcfnrml_4', 'hltoff_1', 'hltoff_3', 'hltoff_4', 'sf6nrml_1', 'sf6nrml_3', 'sf6nrml_4', 'firnrml_1', 'firnrml_3', 'firnrml_4', 'fisnrml_1', 'fisnrml_3', 'fisnrml_4', 'fitnrml_1', 'fitnrml_3', 'fitnrml_4', 'finnrml_1', 'finnrml_3', 'finnrml_4']) ? 'option-' . $field . 'close' : '' }}"
                                                        id="{{ strtoupper($label) }}{{ strtoupper($field) }}CLOSE"
                                                        name="{{ $field }}[]" value="{{ $closeValue }}"
                                                        @checked(in_array($closeValue, old($field, [])))
                                                        onchange="{{ $onChangeClose }}">
                                                    <label class="custom-control-label"
                                                        for="{{ strtoupper($label) }}{{ strtoupper($field) }}CLOSE">{{ $label }}</label>
                                                </div>
                                                @endforeach
                                            </div>
                                            @error($field)
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        @endforeach
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-2 font-weight-bold">COMF Normal</div>
                                                <div class="col custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input"
                                                        id="OKSCOMFNORMAL" name="scomf[]" value="comf_nrml_1"
                                                        @checked(in_array('comf_nrml_1', old('scomf', [])))>
                                                    <label class="custom-control-label" for="OKSCOMFNORMAL">OK</label>
                                                </div>
                                                <div class="col custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input"
                                                        id="NOKSCOMFNORMAL" name="scomf[]" value="comf_nrml_2"
                                                        @checked(in_array('comf_nrml_2', old('scomf', [])))>
                                                    <label class="custom-control-label" for="NOKSCOMFNORMAL">NOK</label>
                                                </div>
                                                <div class="col custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input"
                                                        id="TDK_ADASCOMFNORMAL" name="scomf[]" value="comf_nrml_5"
                                                        @checked(in_array('comf_nrml_5', old('scomf', [])))>
                                                    <label class="custom-control-label" for="TDK_ADASCOMFNORMAL">TDK
                                                        ADA</label>
                                                </div>
                                            </div>
                                            @error('scomf')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-2 font-weight-bold">LRUF Normal</div>
                                                <div class="col custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input"
                                                        id="OKSLRUFNORMAL" name="slruf[]" value="lruf_nrml_1"
                                                        @checked(in_array('lruf_nrml_1', old('slruf', [])))>
                                                    <label class="custom-control-label" for="OKSLRUFNORMAL">OK</label>
                                                </div>
                                                <div class="col custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input"
                                                        id="NOKSLRUFNORMAL" name="slruf[]" value="lruf_nrml_2"
                                                        @checked(in_array('lruf_nrml_2', old('slruf', [])))>
                                                    <label class="custom-control-label" for="NOKSLRUFNORMAL">NOK</label>
                                                </div>
                                                <div class="col custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input"
                                                        id="TDK_ADASLRUFNORMAL" name="slruf[]" value="lruf_nrml_5"
                                                        @checked(in_array('lruf_nrml_5', old('slruf', [])))>
                                                    <label class="custom-control-label" for="TDK_ADASLRUFNORMAL">TDK
                                                        ADA</label>
                                                </div>
                                            </div>
                                            @error('slruf')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Form Telecontrol Tab -->
                                    <div class="tab-pane fade" id="v-pills-formtelecontrol-nobd" role="tabpanel"
                                        aria-labelledby="v-pills-formtelecontrol-tab-nobd">
                                        @foreach ([
                                        'ccb' => ['label' => 'CB', 'states' => ['cbctrl_op_1' => 'OK', 'cbctrl_op_2' =>
                                        'NOK', 'cbctrl_op_3' => 'LOG', 'cbctrl_op_4' => 'SLD', 'cbctrl_op_5' => 'TDK
                                        UJI'], 'open' => 'CB Open', 'close' => 'CB Close'],
                                        'ccb2' => ['label' => 'CB 2', 'states' => ['cbctrl2_op_1' => 'OK',
                                        'cbctrl2_op_2' => 'NOK', 'cbctrl2_op_3' => 'LOG', 'cbctrl2_op_4' => 'SLD',
                                        'cbctrl2_op_5' => 'TDK UJI'], 'open' => 'CB 2 Open', 'close' => 'CB 2 Close'],
                                        'chlt' => ['label' => 'HLT', 'states' => ['hltctrl_off_1' => 'OK',
                                        'hltctrl_off_2' => 'NOK', 'hltctrl_off_3' => 'LOG', 'hltctrl_off_4' => 'SLD',
                                        'hltctrl_off_5' => 'TDK UJI'], 'open' => 'HLT OFF', 'close' => 'HLT ON'],
                                        'crst' => ['label' => 'Reset', 'states' => ['rrctrl_on_1' => 'OK', 'rrctrl_on_2'
                                        => 'NOK', 'rrctrl_on_3' => 'LOG', 'rrctrl_on_4' => 'SLD', 'rrctrl_on_5' => 'TDK
                                        UJI'], 'open' => 'Reset']
                                        ] as $field => $data)
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-2 font-weight-bold">{{ $data['open'] }}</div>
                                                <div class="col custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input"
                                                        id="NORMAL{{ strtoupper($field) }}OPEN"
                                                        onchange="selectAllOption(this, 'option-{{ $field }}open')">
                                                    <label class="custom-control-label"
                                                        for="NORMAL{{ strtoupper($field) }}OPEN">NORMAL</label>
                                                </div>
                                                @foreach ($data['states'] as $value => $label)
                                                @php
                                                $onChangeOpen = in_array($value, ['cbctrl_op_1', 'cbctrl_op_3',
                                                'cbctrl_op_4', 'cbctrl2_op_1', 'cbctrl2_op_3', 'cbctrl2_op_4',
                                                'hltctrl_off_1', 'hltctrl_off_3', 'hltctrl_off_4', 'rrctrl_on_1',
                                                'rrctrl_on_3', 'rrctrl_on_4'])
                                                ? "checkSelectAllOption('option-{$field}open',
                                                document.getElementById('NORMAL" . strtoupper($field) . "OPEN'))"
                                                : '';
                                                @endphp
                                                <div class="col custom-control custom-checkbox">
                                                    <input type="checkbox"
                                                        class="custom-control-input {{ in_array($value, ['cbctrl_op_1', 'cbctrl_op_3', 'cbctrl_op_4', 'cbctrl2_op_1', 'cbctrl2_op_3', 'cbctrl2_op_4', 'hltctrl_off_1', 'hltctrl_off_3', 'hltctrl_off_4', 'rrctrl_on_1', 'rrctrl_on_3', 'rrctrl_on_4']) ? 'option-' . $field . 'open' : '' }}"
                                                        id="{{ strtoupper($label) }}{{ strtoupper($field) }}OPEN"
                                                        name="{{ $field }}[]" value="{{ $value }}"
                                                        @checked(in_array($value, old($field, [])))
                                                        onchange="{{ $onChangeOpen }}">
                                                    <label class="custom-control-label"
                                                        for="{{ strtoupper($label) }}{{ strtoupper($field) }}OPEN">{{ $label }}</label>
                                                </div>
                                                @endforeach
                                            </div>
                                            @error($field)
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        @if (isset($data['close']))
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-2 font-weight-bold">{{ $data['close'] }}</div>
                                                <div class="col custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input"
                                                        id="NORMAL{{ strtoupper($field) }}CLOSE"
                                                        onchange="selectAllOption(this, 'option-{{ $field }}close')">
                                                    <label class="custom-control-label"
                                                        for="NORMAL{{ strtoupper($field) }}CLOSE">NORMAL</label>
                                                </div>
                                                @foreach ($data['states'] as $value => $label)
                                                @php
                                                $closeValue = str_replace(['cbctrl_op', 'cbctrl2_op', 'hltctrl_off',
                                                'rrctrl_on'], ['cbctrl_cl', 'cbctrl2_cl', 'hltctrl_on', 'rrctrl_on'],
                                                $value);
                                                $onChangeClose = in_array($value, ['cbctrl_op_1', 'cbctrl_op_3',
                                                'cbctrl_op_4', 'cbctrl2_op_1', 'cbctrl2_op_3', 'cbctrl2_op_4',
                                                'hltctrl_off_1', 'hltctrl_off_3', 'hltctrl_off_4'])
                                                ? "checkSelectAllOption('option-{$field}close',
                                                document.getElementById('NORMAL" . strtoupper($field) . "CLOSE'))"
                                                : '';
                                                @endphp
                                                <div class="col custom-control custom-checkbox">
                                                    <input type="checkbox"
                                                        class="custom-control-input {{ in_array($value, ['cbctrl_op_1', 'cbctrl_op_3', 'cbctrl_op_4', 'cbctrl2_op_1', 'cbctrl2_op_3', 'cbctrl2_op_4', 'hltctrl_off_1', 'hltctrl_off_3', 'hltctrl_off_4']) ? 'option-' . $field . 'close' : '' }}"
                                                        id="{{ strtoupper($label) }}{{ strtoupper($field) }}CLOSE"
                                                        name="{{ $field }}[]" value="{{ $closeValue }}"
                                                        @checked(in_array($closeValue, old($field, [])))
                                                        onchange="{{ $onChangeClose }}">
                                                    <label class="custom-control-label"
                                                        for="{{ strtoupper($label) }}{{ strtoupper($field) }}CLOSE">{{ $label }}</label>
                                                </div>
                                                @endforeach
                                            </div>
                                            @error($field)
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        @endif
                                        @endforeach
                                    </div>
                                    <!-- Form Telemetering Tab -->
                                    <div class="tab-pane fade" id="v-pills-formtelemetering-nobd" role="tabpanel"
                                        aria-labelledby="v-pills-formtelemetering-tab-nobd">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Arus Phase R</label>
                                                    <input class="form-control @error('ir_rtu') is-invalid @enderror"
                                                        placeholder="IR RTU" name="ir_rtu" value="{{ old('ir_rtu') }}">
                                                    @error('ir_rtu')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                    <input class="form-control @error('ir_ms') is-invalid @enderror"
                                                        placeholder="IR Master" name="ir_ms" value="{{ old('ir_ms') }}">
                                                    @error('ir_ms')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                    <input class="form-control @error('ir_scale') is-invalid @enderror"
                                                        placeholder="Scale" name="ir_scale"
                                                        value="{{ old('ir_scale') }}">
                                                    @error('ir_scale')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label>Arus Phase S</label>
                                                    <input class="form-control @error('is_rtu') is-invalid @enderror"
                                                        placeholder="IS RTU" name="is_rtu" value="{{ old('is_rtu') }}">
                                                    @error('is_rtu')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                    <input class="form-control @error('is_ms') is-invalid @enderror"
                                                        placeholder="IS Master" name="is_ms" value="{{ old('is_ms') }}">
                                                    @error('is_ms')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                    <input class="form-control @error('is_scale') is-invalid @enderror"
                                                        placeholder="Scale" name="is_scale"
                                                        value="{{ old('is_scale') }}">
                                                    @error('is_scale')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label>Arus Phase T</label>
                                                    <input class="form-control @error('it_rtu') is-invalid @enderror"
                                                        placeholder="IT RTU" name="it_rtu" value="{{ old('it_rtu') }}">
                                                    @error('it_rtu')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                    <input class="form-control @error('it_ms') is-invalid @enderror"
                                                        placeholder="IT Master" name="it_ms" value="{{ old('it_ms') }}">
                                                    @error('it_ms')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                    <input class="form-control @error('it_scale') is-invalid @enderror"
                                                        placeholder="Scale" name="it_scale"
                                                        value="{{ old('it_scale') }}">
                                                    @error('it_scale')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Teg Phase R</label>
                                                    <input class="form-control @error('vr_rtu') is-invalid @enderror"
                                                        placeholder="VR RTU" name="vr_rtu" value="{{ old('vr_rtu') }}">
                                                    @error('vr_rtu')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                    <input class="form-control @error('vr_ms') is-invalid @enderror"
                                                        placeholder="VR Master" name="vr_ms" value="{{ old('vr_ms') }}">
                                                    @error('vr_ms')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                    <input class="form-control @error('vr_scale') is-invalid @enderror"
                                                        placeholder="Scale" name="vr_scale"
                                                        value="{{ old('vr_scale') }}">
                                                    @error('vr_scale')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label>Teg Phase S</label>
                                                    <input class="form-control @error('vs_rtu') is-invalid @enderror"
                                                        placeholder="VS RTU" name="vs_rtu" value="{{ old('vs_rtu') }}">
                                                    @error('vs_rtu')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                    <input class="form-control @error('vs_ms') is-invalid @enderror"
                                                        placeholder="VS Master" name="vs_ms" value="{{ old('vs_ms') }}">
                                                    @error('vs_ms')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                    <input class="form-control @error('vs_scale') is-invalid @enderror"
                                                        placeholder="Scale" name="vs_scale"
                                                        value="{{ old('vs_scale') }}">
                                                    @error('vs_scale')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label>Teg Phase T</label>
                                                    <input class="form-control @error('vt_rtu') is-invalid @enderror"
                                                        placeholder="VT RTU" name="vt_rtu" value="{{ old('vt_rtu') }}">
                                                    @error('vt_rtu')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                    <input class="form-control @error('vt_ms') is-invalid @enderror"
                                                        placeholder="VT Master" name="vt_ms" value="{{ old('vt_ms') }}">
                                                    @error('vt_ms')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                    <input class="form-control @error('vt_scale') is-invalid @enderror"
                                                        placeholder="Scale" name="vt_scale"
                                                        value="{{ old('vt_scale') }}">
                                                    @error('vt_scale')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="sign_kp">Sign Strength</label>
                                                    <input class="form-control @error('sign_kp') is-invalid @enderror"
                                                        id="sign_kp" placeholder="30 db" name="sign_kp"
                                                        value="{{ old('sign_kp') }}">
                                                    @error('sign_kp')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- PIC Komisioning Tab -->
                                    <div class="tab-pane fade" id="v-pills-pickomisioning-nobd" role="tabpanel"
                                        aria-labelledby="v-pills-pickomisioning-tab-nobd">
                                        <div class="form-group">
                                            <label for="id_komkp">Jenis Komisioning</label>
                                            <select class="form-control select2 @error('id_komkp') is-invalid @enderror"
                                                id="id_komkp" name="id_komkp">
                                                <option value="" hidden>Pilih Jenis Komisioning</option>
                                                @foreach ($komkp as $kom)
                                                <option value="{{ $kom->id_komkp }}"
                                                    {{ old('id_komkp') == $kom->id_komkp ? 'selected' : '' }}>
                                                    {{ $kom->jenis_komkp }}
                                                </option>
                                                @endforeach
                                            </select>
                                            @error('id_komkp')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="nama_user">Pelaksana Master</label>
                                            <input type="text" class="form-control" id="nama_user" name="nama_user"
                                                value="{{ auth()->user()->nama_admin ?? '' }}" readonly>
                                            @error('nama_user')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="id_picms">Pelaksana Master II</label>
                                            <select class="form-control select2 @error('id_picms') is-invalid @enderror"
                                                id="id_picms" name="id_picms">
                                                <option value="" hidden>Pilih Pelaksana Master II</option>
                                                @foreach ($picmaster as $pic)
                                                <option value="{{ $pic->id_picmaster }}"
                                                    @selected(old('id_picms')==$pic->id_picmaster)>
                                                    {{ $pic->nama_picmaster }}
                                                </option>
                                                @endforeach
                                            </select>
                                            @error('id_picms')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="pelrtu">Pelaksana RTU</label>
                                            <input type="text"
                                                class="form-control text-uppercase @error('pelrtu') is-invalid @enderror"
                                                id="pelrtu" name="pelrtu" value="{{ old('pelrtu') }}">
                                            @error('pelrtu')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="ketkp">Keterangan</label>
                            <textarea class="form-control text-uppercase @error('ketkp') is-invalid @enderror"
                                id="ketkp" name="ketkp" style="height: 155px;">{{ old('ketkp') }}</textarea>
                            @error('ketkp')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="card-action mt-4">
                            <button type="submit" class="btn btn-success">
                                <span class="btn-label">
                                    <i class="fas fa-paper-plane"></i>
                                </span>
                                Simpan
                            </button>
                            <a href="{{ route('keypoint.index') }}" class="btn btn-danger">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function selectAllOption(source, key) {
    var checkboxes = document.querySelectorAll(`.${key}`);
    for (var i = 0, n = checkboxes.length; i < n; i++) {
        checkboxes[i].checked = source.checked;
    }
}

function checkSelectAllOption(option, key) {
    var checkboxes = document.querySelectorAll(`.${option}`);
    var selectAllCheckbox = key;
    for (var i = 0, n = checkboxes.length; i < n; i++) {
        if (!checkboxes[i].checked) {
            selectAllCheckbox.checked = false;
            return;
        }
    }
    selectAllCheckbox.checked = true;
}
</script>
@endpush
