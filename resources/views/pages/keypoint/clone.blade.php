@extends('layout.app')

@section('title', 'Clone Data Keypoint')

@section('content')
<div class="page-inner">
    <div class="page-header">
        <div class="section-header-back">
            <a href="{{ route('keypoint.index') }}" class="btn"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h3 class="fw-bold">Clone Data Keypoint</h3>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Clone Data Keypoint</h4>
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
                    <form action="{{ route('keypoint.clone.store') }}" method="POST" autocomplete="off">
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
                                                            name="tgl_komisioning"
                                                            value="{{ old('tgl_komisioning', $keypoint->tgl_komisioning) }}"
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
                                                            {{ old('id_merkrtu', $keypoint->id_merkrtu) == $merk->id_merkrtu ? 'selected' : '' }}>
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
                                                            {{ old('id_modem', $keypoint->id_modem) == $modem->id_modem ? 'selected' : '' }}>
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
                                                            value="{{ old('rtu_addrs', $keypoint->rtu_addrs) }}" />
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
                                                            {{ old('id_medkom', $keypoint->id_medkom) == $media->id_medkom ? 'selected' : '' }}>
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
                                                            value="{{ old('ip_kp', $keypoint->ip_kp) }}" />
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
                                                            {{ old('id_gi', $keypoint->id_gi) == $gi->id_gi ? 'selected' : '' }}>
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
                                                            value="{{ old('nama_peny', $keypoint->nama_peny) }}" />
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
                                                            {{ old('id_sec', $keypoint->id_sec) == $sec->id_sec ? 'selected' : '' }}>
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
                                        <div class="row">
                                            <div class="col-md-12">
                                                @php
                                                $checkboxValues = [
                                                's_cb' => $keypoint->s_cb ? explode(',', $keypoint->s_cb) : [],
                                                's_cb2' => $keypoint->s_cb2 ? explode(',', $keypoint->s_cb2) : [],
                                                's_lr' => $keypoint->s_lr ? explode(',', $keypoint->s_lr) : [],
                                                's_door' => $keypoint->s_door ? explode(',', $keypoint->s_door) : [],
                                                's_acf' => $keypoint->s_acf ? explode(',', $keypoint->s_acf) : [],
                                                's_dcd' => $keypoint->s_dcd ? explode(',', $keypoint->s_dcd) : [],
                                                's_dcf' => $keypoint->s_dcf ? explode(',', $keypoint->s_dcf) : [],
                                                's_hlt' => $keypoint->s_hlt ? explode(',', $keypoint->s_hlt) : [],
                                                's_sf6' => $keypoint->s_sf6 ? explode(',', $keypoint->s_sf6) : [],
                                                's_fir' => $keypoint->s_fir ? explode(',', $keypoint->s_fir) : [],
                                                's_fis' => $keypoint->s_fis ? explode(',', $keypoint->s_fis) : [],
                                                's_fit' => $keypoint->s_fit ? explode(',', $keypoint->s_fit) : [],
                                                's_fin' => $keypoint->s_fin ? explode(',', $keypoint->s_fin) : [],
                                                's_comf' => $keypoint->s_comf ? explode(',', $keypoint->s_comf) : [],
                                                's_lruf' => $keypoint->s_lruf ? explode(',', $keypoint->s_lruf) : [],
                                                ];
                                                @endphp
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-1">
                                                            <label class="form-label t-bold">CB Open</label>
                                                        </div>
                                                        <div class="col-md-10">
                                                            <div class="selectgroup w-100">
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" id="cb_open_checkAll"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">Normal</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_cb[]" value="open_1"
                                                                        id="cb_open_1" class="selectgroup-input"
                                                                        {{ in_array('open_1', $checkboxValues['s_cb']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">OK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_cb[]" value="open_2"
                                                                        id="cb_open_2" class="selectgroup-input"
                                                                        {{ in_array('open_2', $checkboxValues['s_cb']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">NOK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_cb[]" value="open_3"
                                                                        id="cb_open_3" class="selectgroup-input"
                                                                        {{ in_array('open_3', $checkboxValues['s_cb']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">LOG</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_cb[]" value="open_4"
                                                                        id="cb_open_4" class="selectgroup-input"
                                                                        {{ in_array('open_4', $checkboxValues['s_cb']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">SLD</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_cb[]" value="open_5"
                                                                        id="cb_open_5" class="selectgroup-input"
                                                                        {{ in_array('open_5', $checkboxValues['s_cb']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">Tidak Uji</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-1">
                                                            <label class="form-label t-bold">CB Close</label>
                                                        </div>
                                                        <div class="col-md-10">
                                                            <div class="selectgroup w-100">
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" id="cb_close_checkAll"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">Normal</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_cb[]" value="close_1"
                                                                        id="cb_close_1" class="selectgroup-input"
                                                                        {{ in_array('close_1', $checkboxValues['s_cb']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">OK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_cb[]" value="close_2"
                                                                        id="cb_close_2" class="selectgroup-input"
                                                                        {{ in_array('close_2', $checkboxValues['s_cb']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">NOK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_cb[]" value="close_3"
                                                                        id="cb_close_3" class="selectgroup-input"
                                                                        {{ in_array('close_3', $checkboxValues['s_cb']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">LOG</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_cb[]" value="close_4"
                                                                        id="cb_close_4" class="selectgroup-input"
                                                                        {{ in_array('close_4', $checkboxValues['s_cb']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">SLD</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_cb[]" value="close_5"
                                                                        id="cb_close_5" class="selectgroup-input"
                                                                        {{ in_array('close_5', $checkboxValues['s_cb']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">Tidak Uji</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-1">
                                                            <label class="form-label t-bold">CB 2 Open</label>
                                                        </div>
                                                        <div class="col-md-10">
                                                            <div class="selectgroup w-100">
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" id="cb2_open_checkAll"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">Normal</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_cb2[]" value="open_1"
                                                                        id="cb2_open_1" class="selectgroup-input"
                                                                        {{ in_array('open_1', $checkboxValues['s_cb2']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">OK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_cb2[]" value="open_2"
                                                                        id="cb2_open_2" class="selectgroup-input"
                                                                        {{ in_array('open_2', $checkboxValues['s_cb2']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">NOK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_cb2[]" value="open_3"
                                                                        id="cb2_open_3" class="selectgroup-input"
                                                                        {{ in_array('open_3', $checkboxValues['s_cb2']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">LOG</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_cb2[]" value="open_4"
                                                                        id="cb2_open_4" class="selectgroup-input"
                                                                        {{ in_array('open_4', $checkboxValues['s_cb2']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">SLD</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_cb2[]" value="open_5"
                                                                        id="cb2_open_5" class="selectgroup-input"
                                                                        {{ in_array('open_5', $checkboxValues['s_cb2']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">Tidak Uji</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-1">
                                                            <label class="form-label t-bold">CB 2 Close</label>
                                                        </div>
                                                        <div class="col-md-10">
                                                            <div class="selectgroup w-100">
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" id="cb2_close_checkAll"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">Normal</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_cb2[]"
                                                                        value="close_1" id="cb2_close_1"
                                                                        class="selectgroup-input"
                                                                        {{ in_array('close_1', $checkboxValues['s_cb2']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">OK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_cb2[]"
                                                                        value="close_2" id="cb2_close_2"
                                                                        class="selectgroup-input"
                                                                        {{ in_array('close_2', $checkboxValues['s_cb2']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">NOK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_cb2[]"
                                                                        value="close_3" id="cb2_close_3"
                                                                        class="selectgroup-input"
                                                                        {{ in_array('close_3', $checkboxValues['s_cb2']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">LOG</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_cb2[]"
                                                                        value="close_4" id="cb2_close_4"
                                                                        class="selectgroup-input"
                                                                        {{ in_array('close_4', $checkboxValues['s_cb2']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">SLD</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_cb2[]"
                                                                        value="close_5" id="cb2_close_5"
                                                                        class="selectgroup-input"
                                                                        {{ in_array('close_5', $checkboxValues['s_cb2']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">Tidak Uji</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-1">
                                                            <label class="form-label t-bold">Local</label>
                                                        </div>
                                                        <div class="col-md-10">
                                                            <div class="selectgroup w-100">
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" id="lr_local_checkAll"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">Normal</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_lr[]" value="local_1"
                                                                        id="lr_local_1" class="selectgroup-input"
                                                                        {{ in_array('local_1', $checkboxValues['s_lr']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">OK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_lr[]" value="local_2"
                                                                        id="lr_local_2" class="selectgroup-input"
                                                                        {{ in_array('local_2', $checkboxValues['s_lr']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">NOK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_lr[]" value="local_3"
                                                                        id="lr_local_3" class="selectgroup-input"
                                                                        {{ in_array('local_3', $checkboxValues['s_lr']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">LOG</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_lr[]" value="local_4"
                                                                        id="lr_local_4" class="selectgroup-input"
                                                                        {{ in_array('local_4', $checkboxValues['s_lr']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">SLD</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_lr[]" value="local_5"
                                                                        id="lr_local_5" class="selectgroup-input"
                                                                        {{ in_array('local_5', $checkboxValues['s_lr']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">Tidak Uji</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-1">
                                                            <label class="form-label t-bold">Remote</label>
                                                        </div>
                                                        <div class="col-md-10">
                                                            <div class="selectgroup w-100">
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" id="lr_remote_checkAll"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">Normal</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_lr[]"
                                                                        value="remote_1" id="lr_remote_1"
                                                                        class="selectgroup-input"
                                                                        {{ in_array('remote_1', $checkboxValues['s_lr']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">OK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_lr[]"
                                                                        value="remote_2" id="lr_remote_2"
                                                                        class="selectgroup-input"
                                                                        {{ in_array('remote_2', $checkboxValues['s_lr']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">NOK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_lr[]"
                                                                        value="remote_3" id="lr_remote_3"
                                                                        class="selectgroup-input"
                                                                        {{ in_array('remote_3', $checkboxValues['s_lr']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">LOG</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_lr[]"
                                                                        value="remote_4" id="lr_remote_4"
                                                                        class="selectgroup-input"
                                                                        {{ in_array('remote_4', $checkboxValues['s_lr']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">SLD</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_lr[]"
                                                                        value="remote_5" id="lr_remote_5"
                                                                        class="selectgroup-input"
                                                                        {{ in_array('remote_5', $checkboxValues['s_lr']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">Tidak Uji</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-1">
                                                            <label class="form-label t-bold">Door Open</label>
                                                        </div>
                                                        <div class="col-md-10">
                                                            <div class="selectgroup w-100">
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" id="door_open_checkAll"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">Normal</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_door[]"
                                                                        value="dropen_1" id="door_open_1"
                                                                        class="selectgroup-input"
                                                                        {{ in_array('dropen_1', $checkboxValues['s_door']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">OK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_door[]"
                                                                        value="dropen_2" id="door_open_2"
                                                                        class="selectgroup-input"
                                                                        {{ in_array('dropen_2', $checkboxValues['s_door']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">NOK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_door[]"
                                                                        value="dropen_3" id="door_open_3"
                                                                        class="selectgroup-input"
                                                                        {{ in_array('dropen_3', $checkboxValues['s_door']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">LOG</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_door[]"
                                                                        value="dropen_4" id="door_open_4"
                                                                        class="selectgroup-input"
                                                                        {{ in_array('dropen_4', $checkboxValues['s_door']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">SLD</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_door[]"
                                                                        value="dropen_5" id="door_open_5"
                                                                        class="selectgroup-input"
                                                                        {{ in_array('dropen_5', $checkboxValues['s_door']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">Tidak Uji</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-1">
                                                            <label class="form-label t-bold">Door Close</label>
                                                        </div>
                                                        <div class="col-md-10">
                                                            <div class="selectgroup w-100">
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" id="door_close_checkAll"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">Normal</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_door[]"
                                                                        value="drclose_1" id="door_close_1"
                                                                        class="selectgroup-input"
                                                                        {{ in_array('drclose_1', $checkboxValues['s_door']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">OK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_door[]"
                                                                        value="drclose_2" id="door_close_2"
                                                                        class="selectgroup-input"
                                                                        {{ in_array('drclose_2', $checkboxValues['s_door']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">NOK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_door[]"
                                                                        value="drclose_3" id="door_close_3"
                                                                        class="selectgroup-input"
                                                                        {{ in_array('drclose_3', $checkboxValues['s_door']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">LOG</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_door[]"
                                                                        value="drclose_4" id="door_close_4"
                                                                        class="selectgroup-input"
                                                                        {{ in_array('drclose_4', $checkboxValues['s_door']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">SLD</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_door[]"
                                                                        value="drclose_5" id="door_close_5"
                                                                        class="selectgroup-input"
                                                                        {{ in_array('drclose_5', $checkboxValues['s_door']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">Tidak Uji</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-1">
                                                            <label class="form-label t-bold">ACF Normal</label>
                                                        </div>
                                                        <div class="col-md-10">
                                                            <div class="selectgroup w-100">
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" id="acf_normal_checkAll"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">Normal</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_acf[]"
                                                                        value="acnrml_1" id="acf_acnrml_1"
                                                                        class="selectgroup-input"
                                                                        {{ in_array('acnrml_1', $checkboxValues['s_acf']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">OK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_acf[]"
                                                                        value="acnrml_2" id="acf_acnrml_2"
                                                                        class="selectgroup-input"
                                                                        {{ in_array('acnrml_2', $checkboxValues['s_acf']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">NOK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_acf[]"
                                                                        value="acnrml_3" id="acf_acnrml_3"
                                                                        class="selectgroup-input"
                                                                        {{ in_array('acnrml_3', $checkboxValues['s_acf']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">LOG</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_acf[]"
                                                                        value="acnrml_4" id="acf_acnrml_4"
                                                                        class="selectgroup-input"
                                                                        {{ in_array('acnrml_4', $checkboxValues['s_acf']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">SLD</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_acf[]"
                                                                        value="acnrml_5" id="acf_acnrml_5"
                                                                        class="selectgroup-input"
                                                                        {{ in_array('acnrml_5', $checkboxValues['s_acf']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">Tidak Uji</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-1">
                                                            <label class="form-label t-bold">ACF Failed</label>
                                                        </div>
                                                        <div class="col-md-10">
                                                            <div class="selectgroup w-100">
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" id="acf_failed_checkAll"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">Normal</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_acf[]"
                                                                        value="acfail_1" id="acf_failed_1"
                                                                        class="selectgroup-input"
                                                                        {{ in_array('acfail_1', $checkboxValues['s_acf']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">OK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_acf[]"
                                                                        value="acfail_2" id="acf_failed_2"
                                                                        class="selectgroup-input"
                                                                        {{ in_array('acfail_2', $checkboxValues['s_acf']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">NOK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_acf[]"
                                                                        value="acfail_3" id="acf_failed_3"
                                                                        class="selectgroup-input"
                                                                        {{ in_array('acfail_3', $checkboxValues['s_acf']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">LOG</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_acf[]"
                                                                        value="acfail_4" id="acf_failed_4"
                                                                        class="selectgroup-input"
                                                                        {{ in_array('acfail_4', $checkboxValues['s_acf']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">SLD</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_acf[]"
                                                                        value="acfail_5" id="acf_failed_5"
                                                                        class="selectgroup-input"
                                                                        {{ in_array('acfail_5', $checkboxValues['s_acf']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">Tidak Uji</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-1">
                                                            <label class="form-label t-bold">DCD Normal</label>
                                                        </div>
                                                        <div class="col-md-10">
                                                            <div class="selectgroup w-100">
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" id="dcd_normal_checkAll"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">Normal</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_dcd[]"
                                                                        value="dcnrml_1" id="dcd_dcnrml_1"
                                                                        class="selectgroup-input"
                                                                        {{ in_array('dcnrml_1', $checkboxValues['s_dcd']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">OK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_dcd[]"
                                                                        value="dcnrml_2" id="dcd_dcnrml_2"
                                                                        class="selectgroup-input"
                                                                        {{ in_array('dcnrml_2', $checkboxValues['s_dcd']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">NOK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_dcd[]"
                                                                        value="dcnrml_3" id="dcd_dcnrml_3"
                                                                        class="selectgroup-input"
                                                                        {{ in_array('dcnrml_3', $checkboxValues['s_dcd']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">LOG</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_dcd[]"
                                                                        value="dcnrml_4" id="dcd_dcnrml_4"
                                                                        class="selectgroup-input"
                                                                        {{ in_array('dcnrml_4', $checkboxValues['s_dcd']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">SLD</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_dcd[]"
                                                                        value="dcnrml_5" id="dcd_dcnrml_5"
                                                                        class="selectgroup-input"
                                                                        {{ in_array('dcnrml_5', $checkboxValues['s_dcd']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">Tidak Uji</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-1">
                                                            <label class="form-label t-bold">DCD Failed</label>
                                                        </div>
                                                        <div class="col-md-10">
                                                            <div class="selectgroup w-100">
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" id="dcd_failed_checkAll"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">Normal</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_dcd[]"
                                                                        value="dcfail_1" id="dcd_dcfail_1"
                                                                        class="selectgroup-input"
                                                                        {{ in_array('dcfail_1', $checkboxValues['s_dcd']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">OK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_dcd[]"
                                                                        value="dcfail_2" id="dcd_dcfail_2"
                                                                        class="selectgroup-input"
                                                                        {{ in_array('dcfail_2', $checkboxValues['s_dcd']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">NOK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_dcd[]"
                                                                        value="dcfail_3" id="dcd_dcfail_3"
                                                                        class="selectgroup-input"
                                                                        {{ in_array('dcfail_3', $checkboxValues['s_dcd']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">LOG</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_dcd[]"
                                                                        value="dcfail_4" id="dcd_dcfail_4"
                                                                        class="selectgroup-input"
                                                                        {{ in_array('dcfail_4', $checkboxValues['s_dcd']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">SLD</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_dcd[]"
                                                                        value="dcfail_5" id="dcd_dcfail_5"
                                                                        class="selectgroup-input"
                                                                        {{ in_array('dcfail_5', $checkboxValues['s_dcd']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">Tidak Uji</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-1">
                                                            <label class="form-label t-bold">DCF Normal</label>
                                                        </div>
                                                        <div class="col-md-10">
                                                            <div class="selectgroup w-100">
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" id="dcf_normal_checkAll"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">Normal</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_dcf[]"
                                                                        value="dcfnrml_1" id="dcf_dcfnrml_1"
                                                                        class="selectgroup-input"
                                                                        {{ in_array('dcfnrml_1', $checkboxValues['s_dcf']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">OK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_dcf[]"
                                                                        value="dcfnrml_2" id="dcf_dcfnrml_2"
                                                                        class="selectgroup-input"
                                                                        {{ in_array('dcfnrml_2', $checkboxValues['s_dcf']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">NOK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_dcf[]"
                                                                        value="dcfnrml_3" id="dcf_dcfnrml_3"
                                                                        class="selectgroup-input"
                                                                        {{ in_array('dcfnrml_3', $checkboxValues['s_dcf']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">LOG</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_dcf[]"
                                                                        value="dcfnrml_4" id="dcf_dcfnrml_4"
                                                                        class="selectgroup-input"
                                                                        {{ in_array('dcfnrml_4', $checkboxValues['s_dcf']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">SLD</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_dcf[]"
                                                                        value="dcfnrml_5" id="dcf_dcfnrml_5"
                                                                        class="selectgroup-input"
                                                                        {{ in_array('dcfnrml_5', $checkboxValues['s_dcf']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">Tidak Uji</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-1">
                                                            <label class="form-label t-bold">DCF Failed</label>
                                                        </div>
                                                        <div class="col-md-10">
                                                            <div class="selectgroup w-100">
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" id="dcf_failed_checkAll"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">Normal</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_dcf[]"
                                                                        value="dcffail_1" id="dcf_dcffail_1"
                                                                        class="selectgroup-input"
                                                                        {{ in_array('dcffail_1', $checkboxValues['s_dcf']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">OK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_dcf[]"
                                                                        value="dcffail_2" id="dcf_dcffail_2"
                                                                        class="selectgroup-input"
                                                                        {{ in_array('dcffail_2', $checkboxValues['s_dcf']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">NOK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_dcf[]"
                                                                        value="dcffail_3" id="dcf_dcffail_3"
                                                                        class="selectgroup-input"
                                                                        {{ in_array('dcffail_3', $checkboxValues['s_dcf']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">LOG</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_dcf[]"
                                                                        value="dcffail_4" id="dcf_dcffail_4"
                                                                        class="selectgroup-input"
                                                                        {{ in_array('dcffail_4', $checkboxValues['s_dcf']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">SLD</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_dcf[]"
                                                                        value="dcffail_5" id="dcf_dcffail_5"
                                                                        class="selectgroup-input"
                                                                        {{ in_array('dcffail_5', $checkboxValues['s_dcf']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">Tidak Uji</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-1">
                                                            <label class="form-label t-bold">HLT ON</label>
                                                        </div>
                                                        <div class="col-md-10">
                                                            <div class="selectgroup w-100">
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" id="hlt_on_checkAll"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">Normal</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_hlt[]"
                                                                        value="hlton_1" id="hlt_hlton_1"
                                                                        class="selectgroup-input"
                                                                        {{ in_array('hlton_1', $checkboxValues['s_hlt']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">OK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_hlt[]"
                                                                        value="hlton_2" id="hlt_hlton_2"
                                                                        class="selectgroup-input"
                                                                        {{ in_array('hlton_2', $checkboxValues['s_hlt']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">NOK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_hlt[]"
                                                                        value="hlton_3" id="hlt_hlton_3"
                                                                        class="selectgroup-input"
                                                                        {{ in_array('hlton_3', $checkboxValues['s_hlt']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">LOG</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_hlt[]"
                                                                        value="hlton_4" id="hlt_hlton_4"
                                                                        class="selectgroup-input"
                                                                        {{ in_array('hlton_4', $checkboxValues['s_hlt']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">SLD</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_hlt[]"
                                                                        value="hlton_5" id="hlt_hlton_5"
                                                                        class="selectgroup-input"
                                                                        {{ in_array('hlton_5', $checkboxValues['s_hlt']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">Tidak Uji</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-1">
                                                            <label class="form-label t-bold">HLT OFF</label>
                                                        </div>
                                                        <div class="col-md-10">
                                                            <div class="selectgroup w-100">
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" id="hlt_off_checkAll"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">Normal</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_hlt[]"
                                                                        value="hltoff_1" id="hlt_hltoff_1"
                                                                        class="selectgroup-input"
                                                                        {{ in_array('hltoff_1', $checkboxValues['s_hlt']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">OK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_hlt[]"
                                                                        value="hltoff_2" id="hlt_hltoff_2"
                                                                        class="selectgroup-input"
                                                                        {{ in_array('hltoff_2', $checkboxValues['s_hlt']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">NOK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_hlt[]"
                                                                        value="hltoff_3" id="hlt_hltoff_3"
                                                                        class="selectgroup-input"
                                                                        {{ in_array('hltoff_3', $checkboxValues['s_hlt']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">LOG</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_hlt[]"
                                                                        value="hltoff_4" id="hlt_hltoff_4"
                                                                        class="selectgroup-input"
                                                                        {{ in_array('hltoff_4', $checkboxValues['s_hlt']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">SLD</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_hlt[]"
                                                                        value="hltoff_5" id="hlt_hltoff_5"
                                                                        class="selectgroup-input"
                                                                        {{ in_array('hltoff_5', $checkboxValues['s_hlt']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">Tidak Uji</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-1">
                                                            <label class="form-label t-bold">SF6 Normal</label>
                                                        </div>
                                                        <div class="col-md-10">
                                                            <div class="selectgroup w-100">
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" id="sf6_normal_checkAll"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">Normal</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_sf6[]"
                                                                        value="sf6nrml_1" id="sf6_sf6nrml_1"
                                                                        class="selectgroup-input"
                                                                        {{ in_array('sf6nrml_1', $checkboxValues['s_sf6']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">OK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_sf6[]"
                                                                        value="sf6nrml_2" id="sf6_sf6nrml_2"
                                                                        class="selectgroup-input"
                                                                        {{ in_array('sf6nrml_2', $checkboxValues['s_sf6']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">NOK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_sf6[]"
                                                                        value="sf6nrml_3" id="sf6_sf6nrml_3"
                                                                        class="selectgroup-input"
                                                                        {{ in_array('sf6nrml_3', $checkboxValues['s_sf6']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">LOG</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_sf6[]"
                                                                        value="sf6nrml_4" id="sf6_sf6nrml_4"
                                                                        class="selectgroup-input"
                                                                        {{ in_array('sf6nrml_4', $checkboxValues['s_sf6']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">SLD</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_sf6[]"
                                                                        value="sf6nrml_5" id="sf6_sf6nrml_5"
                                                                        class="selectgroup-input"
                                                                        {{ in_array('sf6nrml_5', $checkboxValues['s_sf6']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">Tidak Uji</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-1">
                                                            <label class="form-label t-bold">SF6 Failed</label>
                                                        </div>
                                                        <div class="col-md-10">
                                                            <div class="selectgroup w-100">
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" id="sf6_failed_checkAll"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">Normal</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_sf6[]"
                                                                        value="sf6fail_1" id="sf6_sf6fail_1"
                                                                        class="selectgroup-input"
                                                                        {{ in_array('sf6fail_1', $checkboxValues['s_sf6']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">OK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_sf6[]"
                                                                        value="sf6fail_2" id="sf6_sf6fail_2"
                                                                        class="selectgroup-input"
                                                                        {{ in_array('sf6fail_2', $checkboxValues['s_sf6']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">NOK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_sf6[]"
                                                                        value="sf6fail_3" id="sf6_sf6fail_3"
                                                                        class="selectgroup-input"
                                                                        {{ in_array('sf6fail_3', $checkboxValues['s_sf6']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">LOG</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_sf6[]"
                                                                        value="sf6fail_4" id="sf6_sf6fail_4"
                                                                        class="selectgroup-input"
                                                                        {{ in_array('sf6fail_4', $checkboxValues['s_sf6']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">SLD</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_sf6[]"
                                                                        value="sf6fail_5" id="sf6_sf6fail_5"
                                                                        class="selectgroup-input"
                                                                        {{ in_array('sf6fail_5', $checkboxValues['s_sf6']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">Tidak Uji</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-1">
                                                            <label class="form-label t-bold">FIR Normal</label>
                                                        </div>
                                                        <div class="col-md-10">
                                                            <div class="selectgroup w-100">
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" id="fir_normal_checkAll"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">Normal</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_fir[]"
                                                                        value="firnrml_1" id="fir_firnrml_1"
                                                                        class="selectgroup-input"
                                                                        {{ in_array('firnrml_1', $checkboxValues['s_fir']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">OK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_fir[]"
                                                                        value="firnrml_2" id="fir_firnrml_2"
                                                                        class="selectgroup-input"
                                                                        {{ in_array('firnrml_2', $checkboxValues['s_fir']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">NOK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_fir[]"
                                                                        value="firnrml_3" id="fir_firnrml_3"
                                                                        class="selectgroup-input"
                                                                        {{ in_array('firnrml_3', $checkboxValues['s_fir']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">LOG</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_fir[]"
                                                                        value="firnrml_4" id="fir_firnrml_4"
                                                                        class="selectgroup-input"
                                                                        {{ in_array('firnrml_4', $checkboxValues['s_fir']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">SLD</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_fir[]"
                                                                        value="firnrml_5" id="fir_firnrml_5"
                                                                        class="selectgroup-input"
                                                                        {{ in_array('firnrml_5', $checkboxValues['s_fir']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">Tidak Uji</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-1">
                                                            <label class="form-label t-bold">FIR Failed</label>
                                                        </div>
                                                        <div class="col-md-10">
                                                            <div class="selectgroup w-100">
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" id="fir_failed_checkAll"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">Normal</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_fir[]"
                                                                        value="firfail_1" id="fir_firfail_1"
                                                                        class="selectgroup-input"
                                                                        {{ in_array('firfail_1', $checkboxValues['s_fir']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">OK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_fir[]"
                                                                        value="firfail_2" id="fir_firfail_2"
                                                                        class="selectgroup-input"
                                                                        {{ in_array('firfail_2', $checkboxValues['s_fir']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">NOK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_fir[]"
                                                                        value="firfail_3" id="fir_firfail_3"
                                                                        class="selectgroup-input"
                                                                        {{ in_array('firfail_3', $checkboxValues['s_fir']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">LOG</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_fir[]"
                                                                        value="firfail_4" id="fir_firfail_4"
                                                                        class="selectgroup-input"
                                                                        {{ in_array('firfail_4', $checkboxValues['s_fir']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">SLD</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_fir[]"
                                                                        value="firfail_5" id="fir_firfail_5"
                                                                        class="selectgroup-input"
                                                                        {{ in_array('firfail_5', $checkboxValues['s_fir']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">Tidak Uji</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-1">
                                                            <label class="form-label t-bold">FIS Normal</label>
                                                        </div>
                                                        <div class="col-md-10">
                                                            <div class="selectgroup w-100">
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" id="fis_normal_checkAll"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">Normal</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_fis[]"
                                                                        value="fisnrml_1" id="fis_fisnrml_1"
                                                                        class="selectgroup-input"
                                                                        {{ in_array('fisnrml_1', $checkboxValues['s_fis']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">OK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_fis[]"
                                                                        value="fisnrml_2" id="fis_fisnrml_2"
                                                                        class="selectgroup-input"
                                                                        {{ in_array('fisnrml_2', $checkboxValues['s_fis']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">NOK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_fis[]"
                                                                        value="fisnrml_3" id="fis_fisnrml_3"
                                                                        class="selectgroup-input"
                                                                        {{ in_array('fisnrml_3', $checkboxValues['s_fis']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">LOG</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_fis[]"
                                                                        value="fisnrml_4" id="fis_fisnrml_4"
                                                                        class="selectgroup-input"
                                                                        {{ in_array('fisnrml_4', $checkboxValues['s_fis']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">SLD</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_fis[]"
                                                                        value="fisnrml_5" id="fis_fisnrml_5"
                                                                        class="selectgroup-input"
                                                                        {{ in_array('fisnrml_5', $checkboxValues['s_fis']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">Tidak Uji</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-1">
                                                            <label class="form-label t-bold">FIS Failed</label>
                                                        </div>
                                                        <div class="col-md-10">
                                                            <div class="selectgroup w-100">
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" id="fis_failed_checkAll"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">Normal</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_fis[]"
                                                                        value="fisfail_1" id="fis_fisfail_1"
                                                                        class="selectgroup-input"
                                                                        {{ in_array('fisfail_1', $checkboxValues['s_fis']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">OK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_fis[]"
                                                                        value="fisfail_2" id="fis_fisfail_2"
                                                                        class="selectgroup-input"
                                                                        {{ in_array('fisfail_2', $checkboxValues['s_fis']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">NOK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_fis[]"
                                                                        value="fisfail_3" id="fis_fisfail_3"
                                                                        class="selectgroup-input"
                                                                        {{ in_array('fisfail_3', $checkboxValues['s_fis']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">LOG</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_fis[]"
                                                                        value="fisfail_4" id="fis_fisfail_4"
                                                                        class="selectgroup-input"
                                                                        {{ in_array('fisfail_4', $checkboxValues['s_fis']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">SLD</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_fis[]"
                                                                        value="fisfail_5" id="fis_fisfail_5"
                                                                        class="selectgroup-input"
                                                                        {{ in_array('fisfail_5', $checkboxValues['s_fis']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">Tidak Uji</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-1">
                                                            <label class="form-label t-bold">FIT Normal</label>
                                                        </div>
                                                        <div class="col-md-10">
                                                            <div class="selectgroup w-100">
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" id="fit_normal_checkAll"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">Normal</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_fit[]"
                                                                        value="fitnrml_1" id="fit_fitnrml_1"
                                                                        class="selectgroup-input"
                                                                        {{ in_array('fitnrml_1', $checkboxValues['s_fit']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">OK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_fit[]"
                                                                        value="fitnrml_2" id="fit_fitnrml_2"
                                                                        class="selectgroup-input"
                                                                        {{ in_array('fitnrml_2', $checkboxValues['s_fit']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">NOK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_fit[]"
                                                                        value="fitnrml_3" id="fit_fitnrml_3"
                                                                        class="selectgroup-input"
                                                                        {{ in_array('fitnrml_3', $checkboxValues['s_fit']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">LOG</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_fit[]"
                                                                        value="fitnrml_4" id="fit_fitnrml_4"
                                                                        class="selectgroup-input"
                                                                        {{ in_array('fitnrml_4', $checkboxValues['s_fit']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">SLD</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_fit[]"
                                                                        value="fitnrml_5" id="fit_fitnrml_5"
                                                                        class="selectgroup-input"
                                                                        {{ in_array('fitnrml_5', $checkboxValues['s_fit']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">Tidak Uji</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-1">
                                                            <label class="form-label t-bold">FIT Failed</label>
                                                        </div>
                                                        <div class="col-md-10">
                                                            <div class="selectgroup w-100">
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" id="fit_failed_checkAll"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">Normal</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_fit[]"
                                                                        value="fitfail_1" id="fit_fitfail_1"
                                                                        class="selectgroup-input"
                                                                        {{ in_array('fitfail_1', $checkboxValues['s_fit']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">OK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_fit[]"
                                                                        value="fitfail_2" id="fit_fitfail_2"
                                                                        class="selectgroup-input"
                                                                        {{ in_array('fitfail_2', $checkboxValues['s_fit']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">NOK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_fit[]"
                                                                        value="fitfail_3" id="fit_fitfail_3"
                                                                        class="selectgroup-input"
                                                                        {{ in_array('fitfail_3', $checkboxValues['s_fit']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">LOG</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_fit[]"
                                                                        value="fitfail_4" id="fit_fitfail_4"
                                                                        class="selectgroup-input"
                                                                        {{ in_array('fitfail_4', $checkboxValues['s_fit']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">SLD</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_fit[]"
                                                                        value="fitfail_5" id="fit_fitfail_5"
                                                                        class="selectgroup-input"
                                                                        {{ in_array('fitfail_5', $checkboxValues['s_fit']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">Tidak Uji</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-1">
                                                            <label class="form-label t-bold">FIN Normal</label>
                                                        </div>
                                                        <div class="col-md-10">
                                                            <div class="selectgroup w-100">
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" id="fin_normal_checkAll"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">Normal</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_fin[]"
                                                                        value="finnrml_1" id="fin_finnrml_1"
                                                                        class="selectgroup-input"
                                                                        {{ in_array('finnrml_1', $checkboxValues['s_fin']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">OK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_fin[]"
                                                                        value="finnrml_2" id="fin_finnrml_2"
                                                                        class="selectgroup-input"
                                                                        {{ in_array('finnrml_2', $checkboxValues['s_fin']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">NOK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_fin[]"
                                                                        value="finnrml_3" id="fin_finnrml_3"
                                                                        class="selectgroup-input"
                                                                        {{ in_array('finnrml_3', $checkboxValues['s_fin']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">LOG</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_fin[]"
                                                                        value="finnrml_4" id="fin_finnrml_4"
                                                                        class="selectgroup-input"
                                                                        {{ in_array('finnrml_4', $checkboxValues['s_fin']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">SLD</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_fin[]"
                                                                        value="finnrml_5" id="fin_finnrml_5"
                                                                        class="selectgroup-input"
                                                                        {{ in_array('finnrml_5', $checkboxValues['s_fin']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">Tidak Uji</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-1">
                                                            <label class="form-label t-bold">FIN Failed</label>
                                                        </div>
                                                        <div class="col-md-10">
                                                            <div class="selectgroup w-100">
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" id="fin_failed_checkAll"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">Normal</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_fin[]"
                                                                        value="finfail_1" id="fin_finfail_1"
                                                                        class="selectgroup-input"
                                                                        {{ in_array('finfail_1', $checkboxValues['s_fin']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">OK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_fin[]"
                                                                        value="finfail_2" id="fin_finfail_2"
                                                                        class="selectgroup-input"
                                                                        {{ in_array('finfail_2', $checkboxValues['s_fin']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">NOK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_fin[]"
                                                                        value="finfail_3" id="fin_finfail_3"
                                                                        class="selectgroup-input"
                                                                        {{ in_array('finfail_3', $checkboxValues['s_fin']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">LOG</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_fin[]"
                                                                        value="finfail_4" id="fin_finfail_4"
                                                                        class="selectgroup-input"
                                                                        {{ in_array('finfail_4', $checkboxValues['s_fin']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">SLD</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_fin[]"
                                                                        value="finfail_5" id="fin_finfail_5"
                                                                        class="selectgroup-input"
                                                                        {{ in_array('finfail_5', $checkboxValues['s_fin']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">Tidak Uji</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-1">
                                                            <label class="form-label t-bold">COMF</label>
                                                        </div>
                                                        <div class="col-md-10">
                                                            <div class="selectgroup w-100">
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_comf[]"
                                                                        value="comf_nrml_1" class="selectgroup-input"
                                                                        {{ in_array('comf_nrml_1', $checkboxValues['s_comf']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">OK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_comf[]"
                                                                        value="comf_nrml_2" class="selectgroup-input"
                                                                        {{ in_array('comf_nrml_2', $checkboxValues['s_comf']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">NOK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_comf[]"
                                                                        value="comf_nrml_3" class="selectgroup-input"
                                                                        {{ in_array('comf_nrml_3', $checkboxValues['s_comf']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">Tidak Ada</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-1">
                                                            <label class="form-label t-bold">LRUF</label>
                                                        </div>
                                                        <div class="col-md-10">
                                                            <div class="selectgroup w-100">
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_lruf[]"
                                                                        value="lruf_nrml_1" class="selectgroup-input"
                                                                        {{ in_array('lruf_nrml_1', $checkboxValues['s_lruf']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">OK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_lruf[]"
                                                                        value="lruf_nrml_2" class="selectgroup-input"
                                                                        {{ in_array('lruf_nrml_2', $checkboxValues['s_lruf']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">NOK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_lruf[]"
                                                                        value="lruf_nrml_5" class="selectgroup-input"
                                                                        {{ in_array('lruf_nrml_5', $checkboxValues['s_lruf']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">Tidak Ada</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Form Telecontrol Tab -->
                                    <div class="tab-pane fade" id="v-pills-formtelecontrol-nobd" role="tabpanel"
                                        aria-labelledby="v-pills-formtelecontrol-tab-nobd">
                                        <div class="row">
                                            <div class="col-md-12">
                                                @php
                                                $telecontrolValues = [
                                                'c_cb' => $keypoint->c_cb ? explode(',', $keypoint->c_cb) : [],
                                                'c_hlt' => $keypoint->c_hlt ? explode(',', $keypoint->c_hlt) : [],
                                                'c_rst' => $keypoint->c_rst ? explode(',', $keypoint->c_rst) : [],
                                                ];
                                                @endphp
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-1">
                                                            <label class="form-label t-bold">CB Open</label>
                                                        </div>
                                                        <div class="col-md-10">
                                                            <div class="selectgroup w-100">
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" id="ccb_open_checkAll_ok"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">Normal</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="c_cb[]"
                                                                        value="cbctrl_op_1" id="ccb_open_1"
                                                                        class="selectgroup-input"
                                                                        {{ in_array('cbctrl_op_1', $telecontrolValues['c_cb']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">OK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="c_cb[]"
                                                                        value="cbctrl_op_2" id="ccb_open_2"
                                                                        class="selectgroup-input"
                                                                        {{ in_array('cbctrl_op_2', $telecontrolValues['c_cb']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">NOK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="c_cb[]"
                                                                        value="cbctrl_op_3" id="ccb_open_3"
                                                                        class="selectgroup-input"
                                                                        {{ in_array('cbctrl_op_3', $telecontrolValues['c_cb']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">LOG</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="c_cb[]"
                                                                        value="cbctrl_op_4" id="ccb_open_4"
                                                                        class="selectgroup-input"
                                                                        {{ in_array('cbctrl_op_4', $telecontrolValues['c_cb']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">SLD</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="c_cb[]"
                                                                        value="cbctrl_op_5" id="ccb_open_5"
                                                                        class="selectgroup-input"
                                                                        {{ in_array('cbctrl_op_5', $telecontrolValues['c_cb']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">TDK UJI</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-1">
                                                            <label class="form-label t-bold">CB Close</label>
                                                        </div>
                                                        <div class="col-md-10">
                                                            <div class="selectgroup w-100">
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" id="ccb_close_checkAll_ok"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">Normal</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="c_cb[]"
                                                                        value="cbctrl_cl_1" id="ccb_close_1"
                                                                        class="selectgroup-input"
                                                                        {{ in_array('cbctrl_cl_1', $telecontrolValues['c_cb']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">OK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="c_cb[]"
                                                                        value="cbctrl_cl_2" id="ccb_close_2"
                                                                        class="selectgroup-input"
                                                                        {{ in_array('cbctrl_cl_2', $telecontrolValues['c_cb']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">NOK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="c_cb[]"
                                                                        value="cbctrl_cl_3" id="ccb_close_3"
                                                                        class="selectgroup-input"
                                                                        {{ in_array('cbctrl_cl_3', $telecontrolValues['c_cb']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">LOG</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="c_cb[]"
                                                                        value="cbctrl_cl_4" id="ccb_close_4"
                                                                        class="selectgroup-input"
                                                                        {{ in_array('cbctrl_cl_4', $telecontrolValues['c_cb']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">SLD</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="c_cb[]"
                                                                        value="cbctrl_cl_5" id="ccb_close_5"
                                                                        class="selectgroup-input"
                                                                        {{ in_array('cbctrl_cl_5', $telecontrolValues['c_cb']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">TDK UJI</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-1">
                                                            <label class="form-label t-bold">HLT On</label>
                                                        </div>
                                                        <div class="col-md-10">
                                                            <div class="selectgroup w-100">
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" id="chlt_on_checkAll_ok"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">Normal</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="c_hlt[]"
                                                                        value="hltctrl_on_1" id="chlt_on_1"
                                                                        class="selectgroup-input"
                                                                        {{ in_array('hltctrl_on_1', $telecontrolValues['c_hlt']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">OK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="c_hlt[]"
                                                                        value="hltctrl_on_2" id="chlt_on_2"
                                                                        class="selectgroup-input"
                                                                        {{ in_array('hltctrl_on_2', $telecontrolValues['c_hlt']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">NOK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="c_hlt[]"
                                                                        value="hltctrl_on_3" id="chlt_on_3"
                                                                        class="selectgroup-input"
                                                                        {{ in_array('hltctrl_on_3', $telecontrolValues['c_hlt']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">LOG</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="c_hlt[]"
                                                                        value="hltctrl_on_4" id="chlt_on_4"
                                                                        class="selectgroup-input"
                                                                        {{ in_array('hltctrl_on_4', $telecontrolValues['c_hlt']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">SLD</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="c_hlt[]"
                                                                        value="hltctrl_on_5" id="chlt_on_5"
                                                                        class="selectgroup-input"
                                                                        {{ in_array('hltctrl_on_5', $telecontrolValues['c_hlt']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">TDK UJI</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-1">
                                                            <label class="form-label t-bold">HLT Off</label>
                                                        </div>
                                                        <div class="col-md-10">
                                                            <div class="selectgroup w-100">
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" id="chlt_off_checkAll_ok"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">Normal</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="c_hlt[]"
                                                                        value="hltctrl_off_1" id="chlt_off_1"
                                                                        class="selectgroup-input"
                                                                        {{ in_array('hltctrl_off_1', $telecontrolValues['c_hlt']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">OK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="c_hlt[]"
                                                                        value="hltctrl_off_2" id="chlt_off_2"
                                                                        class="selectgroup-input"
                                                                        {{ in_array('hltctrl_off_2', $telecontrolValues['c_hlt']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">NOK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="c_hlt[]"
                                                                        value="hltctrl_off_3" id="chlt_off_3"
                                                                        class="selectgroup-input"
                                                                        {{ in_array('hltctrl_off_3', $telecontrolValues['c_hlt']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">LOG</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="c_hlt[]"
                                                                        value="hltctrl_off_4" id="chlt_off_4"
                                                                        class="selectgroup-input"
                                                                        {{ in_array('hltctrl_off_4', $telecontrolValues['c_hlt']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">SLD</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="c_hlt[]"
                                                                        value="hltctrl_off_5" id="chlt_off_5"
                                                                        class="selectgroup-input"
                                                                        {{ in_array('hltctrl_off_5', $telecontrolValues['c_hlt']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">TDK UJI</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-1">
                                                            <label class="form-label t-bold">Reset</label>
                                                        </div>
                                                        <div class="col-md-10">
                                                            <div class="selectgroup w-100">
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" id="crst_on_checkAll_ok"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">Normal</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="c_rst[]"
                                                                        value="rrctrl_on_1" id="crst_on_1"
                                                                        class="selectgroup-input"
                                                                        {{ in_array('rrctrl_on_1', $telecontrolValues['c_rst']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">OK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="c_rst[]"
                                                                        value="rrctrl_on_2" id="crst_on_2"
                                                                        class="selectgroup-input"
                                                                        {{ in_array('rrctrl_on_2', $telecontrolValues['c_rst']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">NOK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="c_rst[]"
                                                                        value="rrctrl_on_3" id="crst_on_3"
                                                                        class="selectgroup-input"
                                                                        {{ in_array('rrctrl_on_3', $telecontrolValues['c_rst']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">LOG</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="c_rst[]"
                                                                        value="rrctrl_on_4" id="crst_on_4"
                                                                        class="selectgroup-input"
                                                                        {{ in_array('rrctrl_on_4', $telecontrolValues['c_rst']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">SLD</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="c_rst[]"
                                                                        value="rrctrl_on_5" id="crst_on_5"
                                                                        class="selectgroup-input"
                                                                        {{ in_array('rrctrl_on_5', $telecontrolValues['c_rst']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">TDK UJI</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Form Telemetering Tab -->
                                    <div class="tab-pane fade" id="v-pills-formtelemetering-nobd" role="tabpanel"
                                        aria-labelledby="v-pills-formtelemetering-tab-nobd">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Arus Phase R</label>
                                                    <input class="form-control @error('ir_rtu') is-invalid @enderror"
                                                        placeholder="IR RTU" name="ir_rtu"
                                                        value="{{ old('ir_rtu', $keypoint->ir_rtu) }}">
                                                    @error('ir_rtu')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                    <input class="form-control @error('ir_ms') is-invalid @enderror"
                                                        placeholder="IR Master" name="ir_ms"
                                                        value="{{ old('ir_ms', $keypoint->ir_ms) }}">
                                                    @error('ir_ms')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                    <input class="form-control @error('ir_scale') is-invalid @enderror"
                                                        placeholder="Scale" name="ir_scale"
                                                        value="{{ old('ir_scale', $keypoint->ir_scale) }}">
                                                    @error('ir_scale')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label>Arus Phase S</label>
                                                    <input class="form-control @error('is_rtu') is-invalid @enderror"
                                                        placeholder="IS RTU" name="is_rtu"
                                                        value="{{ old('is_rtu', $keypoint->is_rtu) }}">
                                                    @error('is_rtu')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                    <input class="form-control @error('is_ms') is-invalid @enderror"
                                                        placeholder="IS Master" name="is_ms"
                                                        value="{{ old('is_ms', $keypoint->is_ms) }}">
                                                    @error('is_ms')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                    <input class="form-control @error('is_scale') is-invalid @enderror"
                                                        placeholder="Scale" name="is_scale"
                                                        value="{{ old('is_scale', $keypoint->is_scale) }}">
                                                    @error('is_scale')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label>Arus Phase T</label>
                                                    <input class="form-control @error('it_rtu') is-invalid @enderror"
                                                        placeholder="IT RTU" name="it_rtu"
                                                        value="{{ old('it_rtu', $keypoint->it_rtu) }}">
                                                    @error('it_rtu')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                    <input class="form-control @error('it_ms') is-invalid @enderror"
                                                        placeholder="IT Master" name="it_ms"
                                                        value="{{ old('it_ms', $keypoint->it_ms) }}">
                                                    @error('it_ms')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                    <input class="form-control @error('it_scale') is-invalid @enderror"
                                                        placeholder="Scale" name="it_scale"
                                                        value="{{ old('it_scale', $keypoint->it_scale) }}">
                                                    @error('it_scale')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Teg Phase R</label>
                                                    <input class="form-control @error('vr_rtu') is-invalid @enderror"
                                                        placeholder="VR RTU" name="vr_rtu"
                                                        value="{{ old('vr_rtu', $keypoint->vr_rtu) }}">
                                                    @error('vr_rtu')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                    <input class="form-control @error('vr_ms') is-invalid @enderror"
                                                        placeholder="VR Master" name="vr_ms"
                                                        value="{{ old('vr_ms', $keypoint->vr_ms) }}">
                                                    @error('vr_ms')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                    <input class="form-control @error('vr_scale') is-invalid @enderror"
                                                        placeholder="Scale" name="vr_scale"
                                                        value="{{ old('vr_scale', $keypoint->vr_scale) }}">
                                                    @error('vr_scale')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label>Teg Phase S</label>
                                                    <input class="form-control @error('vs_rtu') is-invalid @enderror"
                                                        placeholder="VS RTU" name="vs_rtu"
                                                        value="{{ old('vs_rtu', $keypoint->vs_rtu) }}">
                                                    @error('vs_rtu')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                    <input class="form-control @error('vs_ms') is-invalid @enderror"
                                                        placeholder="VS Master" name="vs_ms"
                                                        value="{{ old('vs_ms', $keypoint->vs_ms) }}">
                                                    @error('vs_ms')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                    <input class="form-control @error('vs_scale') is-invalid @enderror"
                                                        placeholder="Scale" name="vs_scale"
                                                        value="{{ old('vs_scale', $keypoint->vs_scale) }}">
                                                    @error('vs_scale')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label>Teg Phase T</label>
                                                    <input class="form-control @error('vt_rtu') is-invalid @enderror"
                                                        placeholder="VT RTU" name="vt_rtu"
                                                        value="{{ old('vt_rtu', $keypoint->vt_rtu) }}">
                                                    @error('vt_rtu')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                    <input class="form-control @error('vt_ms') is-invalid @enderror"
                                                        placeholder="VT Master" name="vt_ms"
                                                        value="{{ old('vt_ms', $keypoint->vt_ms) }}">
                                                    @error('vt_ms')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                    <input class="form-control @error('vt_scale') is-invalid @enderror"
                                                        placeholder="Scale" name="vt_scale"
                                                        value="{{ old('vt_scale', $keypoint->vt_scale) }}">
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
                                                        value="{{ old('sign_kp', $keypoint->sign_kp) }}">
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
                                                <option value="">Pilih Jenis Komisioning</option>
                                                @foreach ($komkp as $kom)
                                                <option value="{{ $kom->id_komkp }}"
                                                    {{ old('id_komkp', $keypoint->id_komkp) == $kom->id_komkp ? 'selected' : '' }}>
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
                                        <div class="custom-form-container">
                                            <div class="custom-form-group">
                                                <label for="id_picms" class="custom-label">Pelaksana Master II</label>
                                                <div class="custom-select-wrapper">
                                                    <div class="selected-items" id="selected-items"></div>
                                                    <input type="hidden" id="id_picms" name="id_picms"
                                                        value="{{ old('id_picms', implode(',', $selectedPicms ?? [])) }}">
                                                    <div class="dropdown" id="dropdown-options">
                                                        @foreach ($picmaster as $item)
                                                        <div class="dropdown-item" data-id="{{ $item->id_picmaster }}">
                                                            {{ $item->nama_picmaster }}
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                                <div class="invalid-feedback" id="error-message" style="display: none;">
                                                    Please select at least one option.
                                                </div>
                                                @error('id_picms')
                                                <div class="invalid-feedback" style="display: block;">{{ $message }}
                                                </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="pelrtu">Pelaksana RTU</label>
                                            <input type="text"
                                                class="form-control text-uppercase @error('pelrtu') is-invalid @enderror"
                                                id="pelrtu" name="pelrtu"
                                                value="{{ old('pelrtu', $keypoint->pelrtu) }}">
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
                                id="ketkp" name="ketkp"
                                style="height: 155px;">{{ old('ketkp', $keypoint->ketkp) }}</textarea>
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

<script>
const hiddenInput = document.getElementById("id_picms");
let selectedValues = (hiddenInput.value.split(",").filter(v => v)); // Remove empty strings

const selectedItems = document.getElementById("selected-items");
const dropdown = document.getElementById("dropdown-options");
const errorMessage = document.getElementById("error-message");
const wrapper = document.querySelector(".custom-select-wrapper");

function handleSelection() {
    selectedItems.innerHTML = "";
    hiddenInput.value = selectedValues.join(",");

    selectedValues.forEach((value) => {
        const option = dropdown.querySelector(`.dropdown-item[data-id="${value}"]`);
        if (option) {
            const div = document.createElement("div");
            div.className = "selected-item";
            div.innerHTML =
                `${option.textContent} <button class="remove-item" onclick="removeSelection('${value}')">×</button>`;
            selectedItems.appendChild(div);
        }
    });

    updateDropdown();
    checkValidation();
}

function removeSelection(value) {
    selectedValues = selectedValues.filter(val => val !== value);
    handleSelection();
}

function toggleSelection(value) {
    if (selectedValues.includes(value)) {
        selectedValues = selectedValues.filter(val => val !== value);
    } else {
        selectedValues.push(value);
    }
    handleSelection();
}

function updateDropdown() {
    const items = dropdown.getElementsByClassName("dropdown-item");
    Array.from(items).forEach((item) => {
        const value = item.getAttribute("data-id");
        if (selectedValues.includes(value)) {
            item.classList.add("selected");
        } else {
            item.classList.remove("selected");
        }
    });

    dropdown.classList.toggle("active", items.length > 0);
}

function checkValidation() {
    const hasSelection = selectedValues.length > 0;
    errorMessage.style.display = hasSelection ? "none" : "block";
}

// Toggle dropdown on click
wrapper.addEventListener("click", (e) => {
    e.stopPropagation();
    dropdown.classList.toggle("active");
});

// Close dropdown when clicking outside
document.addEventListener("click", (e) => {
    if (!wrapper.contains(e.target)) {
        dropdown.classList.remove("active");
    }
});

// Initialize
document.addEventListener("DOMContentLoaded", handleSelection);

// Add click event to dropdown items
dropdown.addEventListener("click", (e) => {
    const item = e.target.closest(".dropdown-item");
    if (item) {
        const value = item.getAttribute("data-id");
        toggleSelection(value);
    }
});
</script>
@endsection
