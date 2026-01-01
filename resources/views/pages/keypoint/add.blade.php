@extends('layout.app')

@section('title', 'Tambah Data Keypoint')

@section('content')


@php
$getOld = function($name) {
$val = old($name, []);
return is_array($val) ? $val : explode(',', $val);
};
@endphp


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
                                    <a class="nav-link" id="v-pills-formhardware-tab-nobd" data-bs-toggle="pill"
                                        href="#v-pills-formhardware-nobd" role="tab"
                                        aria-controls="v-pills-formhardware-nobd" aria-selected="false">Form
                                        Hardware</a>
                                    <a class="nav-link" id="v-pills-formsystem-tab-nobd" data-bs-toggle="pill"
                                        href="#v-pills-formsystem-nobd" role="tab"
                                        aria-controls="v-pills-formsystem-nobd" aria-selected="false">Form
                                        System</a>
                                    <a class="nav-link" id="v-pills-formrecloser-tab-nobd" data-bs-toggle="pill"
                                        href="#v-pills-formrecloser-nobd" role="tab"
                                        aria-controls="v-pills-formrecloser-nobd" aria-selected="false">Form
                                        Recloser</a>
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
                                                <input type="hidden" name="mode_input" id="mode_input" value="0">
                                                <div class="form-group">
                                                    <label for="id_gi">Gardu Induk</label>
                                                    <select class="form-select form-control" id="id_gi" name="id_gi"
                                                        required>
                                                        <option value="">Pilih Gardu Induk</option>
                                                        @foreach ($garduinduk as $gi)
                                                        <option value="{{ $gi->gardu_induk }}"
                                                            {{ old('id_gi') == $gi->gardu_induk ? 'selected' : '' }}>
                                                            {{ $gi->gardu_induk }}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                    @error('id_gi')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label for="nama_peny">Nama Penyulangan</label>
                                                    <select class="form-select form-control" id="nama_peny"
                                                        name="nama_peny" required>
                                                        <option value="">Pilih Nama Penyulangan</option>
                                                    </select>
                                                    @error('nama_peny')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label t-bold">Changer</label>
                                                    <div class="selectgroup w-100 flex-wrap">
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" id="changer_select"
                                                                class="selectgroup-input" checked />
                                                            <span class="selectgroup-button">Select Form Group</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" id="changer_input"
                                                                class="selectgroup-input" />
                                                            <span class="selectgroup-button">Input Form Group</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="nama_lbs">Nama Keypoint</label>
                                                    <div id="nama_lbs_select_container">
                                                        <select class="form-select form-control" id="nama_lbs_select"
                                                            name="nama_lbs" required>
                                                            <option value="">Pilih Nama Keypoint</option>
                                                        </select>
                                                    </div>
                                                    <div id="nama_lbs_input_container" style="display:none;">
                                                        <input type="text" class="form-control" id="nama_lbs_input"
                                                            placeholder="Nama Keypoint" value="{{ old('nama_lbs') }}"
                                                            required />
                                                    </div>
                                                    @error('nama_lbs')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label for="nama_sec">Sectoral</label>
                                                    <div id="nama_sec_select_container">
                                                        <select class="form-select form-control" id="nama_sec_select"
                                                            name="nama_sec" required>
                                                            <option value="">Pilih Sectoral</option>
                                                        </select>
                                                    </div>
                                                    <div id="nama_sec_input_container" style="display:none;">
                                                        <input type="text" class="form-control" id="nama_sec_input"
                                                            placeholder="Sectoral" value="{{ old('nama_sec') }}"
                                                            required />
                                                    </div>
                                                    @error('nama_sec')
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
                                            </div>
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
                                            </div>
                                            <div class="form-group">
                                                <label for="ketfd">Keterangan Form Data</label>
                                                <div class="input-icon">
                                                    <input type="text" class="form-control" id="ketfd" name="ketfd"
                                                        placeholder="Keterangan Form Data" value="{{ old('ketfd') }}" />
                                                    @error('ketfd')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Form Telestatus Tab -->
                                    <div class="tab-pane fade" id="v-pills-formtelestatus-nobd" role="tabpanel"
                                        aria-labelledby="v-pills-formtelestatus-tab-nobd">
                                        <div class="row g-3 g-lg-4">
                                            <div class="col-12 col-lg-6" style="max-height: 800px; overflow-y: auto;">
                                                <div class="form-group">
                                                    <label class="form-label t-bold">CB Open</label>
                                                    <div class="selectgroup w-100 flex-wrap">
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" id="cb_open_checkAll"
                                                                class="selectgroup-input" />
                                                            <span class="selectgroup-button">Normal</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_cb[]" value="open_1"
                                                                id="cb_open_1" class="selectgroup-input"
                                                                {{ in_array('open_1', old('s_cb', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">OK</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_cb[]" value="open_2"
                                                                id="cb_open_2" class="selectgroup-input"
                                                                {{ in_array('open_2', old('s_cb', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">NOK</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_cb[]" value="open_3"
                                                                id="cb_open_3" class="selectgroup-input"
                                                                {{ in_array('open_3', old('s_cb', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">LOG</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_cb[]" value="open_4"
                                                                id="cb_open_4" class="selectgroup-input"
                                                                {{ in_array('open_4', old('s_cb', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">SLD</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_cb[]" value="open_5"
                                                                id="cb_open_5" class="selectgroup-input"
                                                                {{ in_array('open_5', old('s_cb', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">Tidak Uji</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label t-bold">CB Close</label>
                                                    <div class="selectgroup w-100 flex-wrap">
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" id="cb_close_checkAll"
                                                                class="selectgroup-input" />
                                                            <span class="selectgroup-button">Normal</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_cb[]" value="close_1"
                                                                id="cb_close_1" class="selectgroup-input"
                                                                {{ in_array('close_1', old('s_cb', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">OK</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_cb[]" value="close_2"
                                                                id="cb_close_2" class="selectgroup-input"
                                                                {{ in_array('close_2', old('s_cb', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">NOK</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_cb[]" value="close_3"
                                                                id="cb_close_3" class="selectgroup-input"
                                                                {{ in_array('close_3', old('s_cb', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">LOG</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_cb[]" value="close_4"
                                                                id="cb_close_4" class="selectgroup-input"
                                                                {{ in_array('close_4', old('s_cb', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">SLD</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_cb[]" value="close_5"
                                                                id="cb_close_5" class="selectgroup-input"
                                                                {{ in_array('close_5', old('s_cb', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">Tidak Uji</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label t-bold">CB2 Open</label>
                                                    <div class="selectgroup w-100 flex-wrap">
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" id="cb2_open_checkAll"
                                                                class="selectgroup-input" />
                                                            <span class="selectgroup-button">Normal</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_cb2[]" value="open_1"
                                                                id="cb2_open_1" class="selectgroup-input"
                                                                {{ in_array('open_1', old('s_cb2', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">OK</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_cb2[]" value="open_2"
                                                                id="cb2_open_2" class="selectgroup-input"
                                                                {{ in_array('open_2', old('s_cb2', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">NOK</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_cb2[]" value="open_3"
                                                                id="cb2_open_3" class="selectgroup-input"
                                                                {{ in_array('open_3', old('s_cb2', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">LOG</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_cb2[]" value="open_4"
                                                                id="cb2_open_4" class="selectgroup-input"
                                                                {{ in_array('open_4', old('s_cb2', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">SLD</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_cb2[]" value="open_5"
                                                                id="cb2_open_5" class="selectgroup-input"
                                                                {{ in_array('open_5', old('s_cb2', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">Tidak Uji</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label t-bold">CB2 Close</label>
                                                    <div class="selectgroup w-100 flex-wrap">
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" id="cb2_close_checkAll"
                                                                class="selectgroup-input" />
                                                            <span class="selectgroup-button">Normal</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_cb2[]" value="close_1"
                                                                id="cb2_close_1" class="selectgroup-input"
                                                                {{ in_array('close_1', old('s_cb2', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">OK</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_cb2[]" value="close_2"
                                                                id="cb2_close_2" class="selectgroup-input"
                                                                {{ in_array('close_2', old('s_cb2', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">NOK</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_cb2[]" value="close_3"
                                                                id="cb2_close_3" class="selectgroup-input"
                                                                {{ in_array('close_3', old('s_cb2', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">LOG</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_cb2[]" value="close_4"
                                                                id="cb2_close_4" class="selectgroup-input"
                                                                {{ in_array('close_4', old('s_cb2', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">SLD</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_cb2[]" value="close_5"
                                                                id="cb2_close_5" class="selectgroup-input"
                                                                {{ in_array('close_5', old('s_cb2', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">Tidak Uji</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label t-bold">Local</label>
                                                    <div class="selectgroup w-100 flex-wrap">
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" id="lr_local_checkAll"
                                                                class="selectgroup-input" />
                                                            <span class="selectgroup-button">Normal</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_lr[]" value="local_1"
                                                                id="lr_local_1" class="selectgroup-input"
                                                                {{ in_array('local_1', old('s_lr', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">OK</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_lr[]" value="local_2"
                                                                id="lr_local_2" class="selectgroup-input"
                                                                {{ in_array('local_2', old('s_lr', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">NOK</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_lr[]" value="local_3"
                                                                id="lr_local_3" class="selectgroup-input"
                                                                {{ in_array('local_3', old('s_lr', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">LOG</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_lr[]" value="local_4"
                                                                id="lr_local_4" class="selectgroup-input"
                                                                {{ in_array('local_4', old('s_lr', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">SLD</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_lr[]" value="local_5"
                                                                id="lr_local_5" class="selectgroup-input"
                                                                {{ in_array('local_5', old('s_lr', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">Tidak Uji</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label t-bold">Remote</label>
                                                    <div class="selectgroup w-100 flex-wrap">
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" id="lr_remote_checkAll"
                                                                class="selectgroup-input" />
                                                            <span class="selectgroup-button">Normal</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_lr[]" value="remote_1"
                                                                id="lr_remote_1" class="selectgroup-input"
                                                                {{ in_array('remote_1', old('s_lr', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">OK</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_lr[]" value="remote_2"
                                                                id="lr_remote_2" class="selectgroup-input"
                                                                {{ in_array('remote_2', old('s_lr', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">NOK</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_lr[]" value="remote_3"
                                                                id="lr_remote_3" class="selectgroup-input"
                                                                {{ in_array('remote_3', old('s_lr', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">LOG</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_lr[]" value="remote_4"
                                                                id="lr_remote_4" class="selectgroup-input"
                                                                {{ in_array('remote_4', old('s_lr', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">SLD</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_lr[]" value="remote_5"
                                                                id="lr_remote_5" class="selectgroup-input"
                                                                {{ in_array('remote_5', old('s_lr', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">Tidak Uji</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label t-bold">Door Open</label>
                                                    <div class="selectgroup w-100 flex-wrap">
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" id="door_open_checkAll"
                                                                class="selectgroup-input" />
                                                            <span class="selectgroup-button">Normal</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_door[]" value="dropen_1"
                                                                id="door_open_1" class="selectgroup-input"
                                                                {{ in_array('dropen_1', old('s_door', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">OK</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_door[]" value="dropen_2"
                                                                id="door_open_2" class="selectgroup-input"
                                                                {{ in_array('dropen_2', old('s_door', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">NOK</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_door[]" value="dropen_3"
                                                                id="door_open_3" class="selectgroup-input"
                                                                {{ in_array('dropen_3', old('s_door', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">LOG</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_door[]" value="dropen_4"
                                                                id="door_open_4" class="selectgroup-input"
                                                                {{ in_array('dropen_4', old('s_door', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">SLD</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_door[]" value="dropen_5"
                                                                id="door_open_5" class="selectgroup-input"
                                                                {{ in_array('dropen_5', old('s_door', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">Tidak Uji</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label t-bold">Door Close</label>
                                                    <div class="selectgroup w-100 flex-wrap">
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" id="door_close_checkAll"
                                                                class="selectgroup-input" />
                                                            <span class="selectgroup-button">Normal</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_door[]" value="drclose_1"
                                                                id="door_close_1" class="selectgroup-input"
                                                                {{ in_array('drclose_1', old('s_door', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">OK</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_door[]" value="drclose_2"
                                                                id="door_close_2" class="selectgroup-input"
                                                                {{ in_array('drclose_2', old('s_door', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">NOK</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_door[]" value="drclose_3"
                                                                id="door_close_3" class="selectgroup-input"
                                                                {{ in_array('drclose_3', old('s_door', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">LOG</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_door[]" value="drclose_4"
                                                                id="door_close_4" class="selectgroup-input"
                                                                {{ in_array('drclose_4', old('s_door', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">SLD</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_door[]" value="drclose_5"
                                                                id="door_close_5" class="selectgroup-input"
                                                                {{ in_array('drclose_5', old('s_door', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">Tidak Uji</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label t-bold">ACF Normal</label>
                                                    <div class="selectgroup w-100 flex-wrap">
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" id="acf_normal_checkAll"
                                                                class="selectgroup-input" />
                                                            <span class="selectgroup-button">Normal</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_acf[]" value="acnrml_1"
                                                                id="acf_acnrml_1" class="selectgroup-input"
                                                                {{ in_array('acnrml_1', old('s_acf', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">OK</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_acf[]" value="acnrml_2"
                                                                id="acf_acnrml_2" class="selectgroup-input"
                                                                {{ in_array('acnrml_2', old('s_acf', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">NOK</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_acf[]" value="acnrml_3"
                                                                id="acf_acnrml_3" class="selectgroup-input"
                                                                {{ in_array('acnrml_3', old('s_acf', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">LOG</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_acf[]" value="acnrml_4"
                                                                id="acf_acnrml_4" class="selectgroup-input"
                                                                {{ in_array('acnrml_4', old('s_acf', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">SLD</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_acf[]" value="acnrml_5"
                                                                id="acf_acnrml_5" class="selectgroup-input"
                                                                {{ in_array('acnrml_5', old('s_acf', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">Tidak Uji</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label t-bold">ACF Failed</label>
                                                    <div class="selectgroup w-100 flex-wrap">
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" id="acf_failed_checkAll"
                                                                class="selectgroup-input" />
                                                            <span class="selectgroup-button">Normal</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_acf[]" value="acfail_1"
                                                                id="acf_failed_1" class="selectgroup-input"
                                                                {{ in_array('acfail_1', old('s_acf', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">OK</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_acf[]" value="acfail_2"
                                                                id="acf_failed_2" class="selectgroup-input"
                                                                {{ in_array('acfail_2', old('s_acf', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">NOK</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_acf[]" value="acfail_3"
                                                                id="acf_failed_3" class="selectgroup-input"
                                                                {{ in_array('acfail_3', old('s_acf', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">LOG</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_acf[]" value="acfail_4"
                                                                id="acf_failed_4" class="selectgroup-input"
                                                                {{ in_array('acfail_4', old('s_acf', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">SLD</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_acf[]" value="acfail_5"
                                                                id="acf_failed_5" class="selectgroup-input"
                                                                {{ in_array('acfail_5', old('s_acf', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">Tidak Uji</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label t-bold">DCF Normal</label>
                                                    <div class="selectgroup w-100 flex-wrap">
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" id="dcf_normal_checkAll"
                                                                class="selectgroup-input" />
                                                            <span class="selectgroup-button">Normal</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_dcf[]" value="dcfnrml_1"
                                                                id="dcf_dcfnrml_1" class="selectgroup-input"
                                                                {{ in_array('dcfnrml_1', old('s_dcf', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">OK</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_dcf[]" value="dcfnrml_2"
                                                                id="dcf_dcfnrml_2" class="selectgroup-input"
                                                                {{ in_array('dcfnrml_2', old('s_dcf', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">NOK</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_dcf[]" value="dcfnrml_3"
                                                                id="dcf_dcfnrml_3" class="selectgroup-input"
                                                                {{ in_array('dcfnrml_3', old('s_dcf', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">LOG</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_dcf[]" value="dcfnrml_4"
                                                                id="dcf_dcfnrml_4" class="selectgroup-input"
                                                                {{ in_array('dcfnrml_4', old('s_dcf', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">SLD</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_dcf[]" value="dcfnrml_5"
                                                                id="dcf_dcfnrml_5" class="selectgroup-input"
                                                                {{ in_array('dcfnrml_5', old('s_dcf', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">Tidak Uji</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label t-bold">DCF Failed</label>
                                                    <div class="selectgroup w-100 flex-wrap">
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" id="dcf_failed_checkAll"
                                                                class="selectgroup-input" />
                                                            <span class="selectgroup-button">Normal</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_dcf[]" value="dcffail_1"
                                                                id="dcf_dcffail_1" class="selectgroup-input"
                                                                {{ in_array('dcffail_1', old('s_dcf', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">OK</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_dcf[]" value="dcffail_2"
                                                                id="dcf_dcffail_2" class="selectgroup-input"
                                                                {{ in_array('dcffail_2', old('s_dcf', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">NOK</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_dcf[]" value="dcffail_3"
                                                                id="dcf_dcffail_3" class="selectgroup-input"
                                                                {{ in_array('dcffail_3', old('s_dcf', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">LOG</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_dcf[]" value="dcffail_4"
                                                                id="dcf_dcffail_4" class="selectgroup-input"
                                                                {{ in_array('dcffail_4', old('s_dcf', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">SLD</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_dcf[]" value="dcffail_5"
                                                                id="dcf_dcffail_5" class="selectgroup-input"
                                                                {{ in_array('dcffail_5', old('s_dcf', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">Tidak Uji</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label t-bold">DCD Normal</label>
                                                    <div class="selectgroup w-100 flex-wrap">
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" id="dcd_normal_checkAll"
                                                                class="selectgroup-input" />
                                                            <span class="selectgroup-button">Normal</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_dcd[]" value="dcnrml_1"
                                                                id="dcd_dcnrml_1" class="selectgroup-input"
                                                                {{ in_array('dcnrml_1', old('s_dcd', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">OK</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_dcd[]" value="dcnrml_2"
                                                                id="dcd_dcnrml_2" class="selectgroup-input"
                                                                {{ in_array('dcnrml_2', old('s_dcd', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">NOK</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_dcd[]" value="dcnrml_3"
                                                                id="dcd_dcnrml_3" class="selectgroup-input"
                                                                {{ in_array('dcnrml_3', old('s_dcd', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">LOG</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_dcd[]" value="dcnrml_4"
                                                                id="dcd_dcnrml_4" class="selectgroup-input"
                                                                {{ in_array('dcnrml_4', old('s_dcd', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">SLD</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_dcd[]" value="dcnrml_5"
                                                                id="dcd_dcnrml_5" class="selectgroup-input"
                                                                {{ in_array('dcnrml_5', old('s_dcd', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">Tidak Uji</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label t-bold">DCD Failed</label>
                                                    <div class="selectgroup w-100 flex-wrap">
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" id="dcd_failed_checkAll"
                                                                class="selectgroup-input" />
                                                            <span class="selectgroup-button">Normal</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_dcd[]" value="dcfail_1"
                                                                id="dcd_dcfail_1" class="selectgroup-input"
                                                                {{ in_array('dcfail_1', old('s_dcd', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">OK</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_dcd[]" value="dcfail_2"
                                                                id="dcd_dcfail_2" class="selectgroup-input"
                                                                {{ in_array('dcfail_2', old('s_dcd', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">NOK</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_dcd[]" value="dcfail_3"
                                                                id="dcd_dcfail_3" class="selectgroup-input"
                                                                {{ in_array('dcfail_3', old('s_dcd', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">LOG</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_dcd[]" value="dcfail_4"
                                                                id="dcd_dcfail_4" class="selectgroup-input"
                                                                {{ in_array('dcfail_4', old('s_dcd', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">SLD</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_dcd[]" value="dcfail_5"
                                                                id="dcd_dcfail_5" class="selectgroup-input"
                                                                {{ in_array('dcfail_5', old('s_dcd', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">Tidak Uji</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label t-bold">HLT On</label>
                                                    <div class="selectgroup w-100 flex-wrap">
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" id="hlt_on_checkAll"
                                                                class="selectgroup-input" />
                                                            <span class="selectgroup-button">Normal</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_hlt[]" value="hlton_1"
                                                                id="hlt_hlton_1" class="selectgroup-input"
                                                                {{ in_array('hlton_1', old('s_hlt', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">OK</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_hlt[]" value="hlton_2"
                                                                id="hlt_hlton_2" class="selectgroup-input"
                                                                {{ in_array('hlton_2', old('s_hlt', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">NOK</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_hlt[]" value="hlton_3"
                                                                id="hlt_hlton_3" class="selectgroup-input"
                                                                {{ in_array('hlton_3', old('s_hlt', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">LOG</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_hlt[]" value="hlton_4"
                                                                id="hlt_hlton_4" class="selectgroup-input"
                                                                {{ in_array('hlton_4', old('s_hlt', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">SLD</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_hlt[]" value="hlton_5"
                                                                id="hlt_hlton_5" class="selectgroup-input"
                                                                {{ in_array('hlton_5', old('s_hlt', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">Tidak Uji</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label t-bold">HLT Off</label>
                                                    <div class="selectgroup w-100 flex-wrap">
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" id="hlt_off_checkAll"
                                                                class="selectgroup-input" />
                                                            <span class="selectgroup-button">Normal</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_hlt[]" value="hltoff_1"
                                                                id="hlt_hltoff_1" class="selectgroup-input"
                                                                {{ in_array('hltoff_1', old('s_hlt', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">OK</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_hlt[]" value="hltoff_2"
                                                                id="hlt_hltoff_2" class="selectgroup-input"
                                                                {{ in_array('hltoff_2', old('s_hlt', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">NOK</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_hlt[]" value="hltoff_3"
                                                                id="hlt_hltoff_3" class="selectgroup-input"
                                                                {{ in_array('hltoff_3', old('s_hlt', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">LOG</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_hlt[]" value="hltoff_4"
                                                                id="hlt_hltoff_4" class="selectgroup-input"
                                                                {{ in_array('hltoff_4', old('s_hlt', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">SLD</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_hlt[]" value="hltoff_5"
                                                                id="hlt_hltoff_5" class="selectgroup-input"
                                                                {{ in_array('hltoff_5', old('s_hlt', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">Tidak Uji</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label t-bold">SF6 Normal</label>
                                                    <div class="selectgroup w-100 flex-wrap">
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" id="sf6_normal_checkAll"
                                                                class="selectgroup-input" />
                                                            <span class="selectgroup-button">Normal</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_sf6[]" value="sf6nrml_1"
                                                                id="sf6_sf6nrml_1" class="selectgroup-input"
                                                                {{ in_array('sf6nrml_1', old('s_sf6', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">OK</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_sf6[]" value="sf6nrml_2"
                                                                id="sf6_sf6nrml_2" class="selectgroup-input"
                                                                {{ in_array('sf6nrml_2', old('s_sf6', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">NOK</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_sf6[]" value="sf6nrml_3"
                                                                id="sf6_sf6nrml_3" class="selectgroup-input"
                                                                {{ in_array('sf6nrml_3', old('s_sf6', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">LOG</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_sf6[]" value="sf6nrml_4"
                                                                id="sf6_sf6nrml_4" class="selectgroup-input"
                                                                {{ in_array('sf6nrml_4', old('s_sf6', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">SLD</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_sf6[]" value="sf6nrml_5"
                                                                id="sf6_sf6nrml_5" class="selectgroup-input"
                                                                {{ in_array('sf6nrml_5', old('s_sf6', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">Tidak Uji</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label t-bold">SF6 Low</label>
                                                    <div class="selectgroup w-100 flex-wrap">
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" id="sf6_failed_checkAll"
                                                                class="selectgroup-input" />
                                                            <span class="selectgroup-button">Normal</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_sf6[]" value="sf6fail_1"
                                                                id="sf6_sf6fail_1" class="selectgroup-input"
                                                                {{ in_array('sf6fail_1', old('s_sf6', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">OK</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_sf6[]" value="sf6fail_2"
                                                                id="sf6_sf6fail_2" class="selectgroup-input"
                                                                {{ in_array('sf6fail_2', old('s_sf6', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">NOK</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_sf6[]" value="sf6fail_3"
                                                                id="sf6_sf6fail_3" class="selectgroup-input"
                                                                {{ in_array('sf6fail_3', old('s_sf6', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">LOG</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_sf6[]" value="sf6fail_4"
                                                                id="sf6_sf6fail_4" class="selectgroup-input"
                                                                {{ in_array('sf6fail_4', old('s_sf6', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">SLD</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_sf6[]" value="sf6fail_5"
                                                                id="sf6_sf6fail_5" class="selectgroup-input"
                                                                {{ in_array('sf6fail_5', old('s_sf6', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">Tidak Uji</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label t-bold">FIR Normal</label>
                                                    <div class="selectgroup w-100 flex-wrap">
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" id="fir_normal_checkAll"
                                                                class="selectgroup-input" />
                                                            <span class="selectgroup-button">Normal</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_fir[]" value="firnrml_1"
                                                                id="fir_firnrml_1" class="selectgroup-input"
                                                                {{ in_array('firnrml_1', old('s_fir', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">OK</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_fir[]" value="firnrml_2"
                                                                id="fir_firnrml_2" class="selectgroup-input"
                                                                {{ in_array('firnrml_2', old('s_fir', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">NOK</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_fir[]" value="firnrml_3"
                                                                id="fir_firnrml_3" class="selectgroup-input"
                                                                {{ in_array('firnrml_3', old('s_fir', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">LOG</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_fir[]" value="firnrml_4"
                                                                id="fir_firnrml_4" class="selectgroup-input"
                                                                {{ in_array('firnrml_4', old('s_fir', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">SLD</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_fir[]" value="firnrml_5"
                                                                id="fir_firnrml_5" class="selectgroup-input"
                                                                {{ in_array('firnrml_5', old('s_fir', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">Tidak Uji</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label t-bold">FIR Failed</label>
                                                    <div class="selectgroup w-100 flex-wrap">
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" id="fir_failed_checkAll"
                                                                class="selectgroup-input" />
                                                            <span class="selectgroup-button">Normal</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_fir[]" value="firfail_1"
                                                                id="fir_firfail_1" class="selectgroup-input"
                                                                {{ in_array('firfail_1', old('s_fir', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">OK</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_fir[]" value="firfail_2"
                                                                id="fir_firfail_2" class="selectgroup-input"
                                                                {{ in_array('firfail_2', old('s_fir', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">NOK</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_fir[]" value="firfail_3"
                                                                id="fir_firfail_3" class="selectgroup-input"
                                                                {{ in_array('firfail_3', old('s_fir', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">LOG</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_fir[]" value="firfail_4"
                                                                id="fir_firfail_4" class="selectgroup-input"
                                                                {{ in_array('firfail_4', old('s_fir', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">SLD</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_fir[]" value="firfail_5"
                                                                id="fir_firfail_5" class="selectgroup-input"
                                                                {{ in_array('firfail_5', old('s_fir', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">Tidak Uji</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label t-bold">FIS Normal</label>
                                                    <div class="selectgroup w-100 flex-wrap">
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" id="fis_normal_checkAll"
                                                                class="selectgroup-input" />
                                                            <span class="selectgroup-button">Normal</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_fis[]" value="fisnrml_1"
                                                                id="fis_fisnrml_1" class="selectgroup-input"
                                                                {{ in_array('fisnrml_1', old('s_fis', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">OK</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_fis[]" value="fisnrml_2"
                                                                id="fis_fisnrml_2" class="selectgroup-input"
                                                                {{ in_array('fisnrml_2', old('s_fis', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">NOK</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_fis[]" value="fisnrml_3"
                                                                id="fis_fisnrml_3" class="selectgroup-input"
                                                                {{ in_array('fisnrml_3', old('s_fis', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">LOG</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_fis[]" value="fisnrml_4"
                                                                id="fis_fisnrml_4" class="selectgroup-input"
                                                                {{ in_array('fisnrml_4', old('s_fis', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">SLD</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_fis[]" value="fisnrml_5"
                                                                id="fis_fisnrml_5" class="selectgroup-input"
                                                                {{ in_array('fisnrml_5', old('s_fis', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">Tidak Uji</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label t-bold">FIS Failed</label>
                                                    <div class="selectgroup w-100 flex-wrap">
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" id="fis_failed_checkAll"
                                                                class="selectgroup-input" />
                                                            <span class="selectgroup-button">Normal</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_fis[]" value="fisfail_1"
                                                                id="fis_fisfail_1" class="selectgroup-input"
                                                                {{ in_array('fisfail_1', old('s_fis', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">OK</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_fis[]" value="fisfail_2"
                                                                id="fis_fisfail_2" class="selectgroup-input"
                                                                {{ in_array('fisfail_2', old('s_fis', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">NOK</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_fis[]" value="fisfail_3"
                                                                id="fis_fisfail_3" class="selectgroup-input"
                                                                {{ in_array('fisfail_3', old('s_fis', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">LOG</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_fis[]" value="fisfail_4"
                                                                id="fis_fisfail_4" class="selectgroup-input"
                                                                {{ in_array('fisfail_4', old('s_fis', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">SLD</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_fis[]" value="fisfail_5"
                                                                id="fis_fisfail_5" class="selectgroup-input"
                                                                {{ in_array('fisfail_5', old('s_fis', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">Tidak Uji</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label t-bold">FIT Normal</label>
                                                    <div class="selectgroup w-100 flex-wrap">
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" id="fit_normal_checkAll"
                                                                class="selectgroup-input" />
                                                            <span class="selectgroup-button">Normal</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_fit[]" value="fitnrml_1"
                                                                id="fit_fitnrml_1" class="selectgroup-input"
                                                                {{ in_array('fitnrml_1', old('s_fit', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">OK</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_fit[]" value="fitnrml_2"
                                                                id="fit_fitnrml_2" class="selectgroup-input"
                                                                {{ in_array('fitnrml_2', old('s_fit', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">NOK</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_fit[]" value="fitnrml_3"
                                                                id="fit_fitnrml_3" class="selectgroup-input"
                                                                {{ in_array('fitnrml_3', old('s_fit', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">LOG</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_fit[]" value="fitnrml_4"
                                                                id="fit_fitnrml_4" class="selectgroup-input"
                                                                {{ in_array('fitnrml_4', old('s_fit', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">SLD</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_fit[]" value="fitnrml_5"
                                                                id="fit_fitnrml_5" class="selectgroup-input"
                                                                {{ in_array('fitnrml_5', old('s_fit', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">Tidak Uji</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label t-bold">FIT Failed</label>
                                                    <div class="selectgroup w-100 flex-wrap">
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" id="fit_failed_checkAll"
                                                                class="selectgroup-input" />
                                                            <span class="selectgroup-button">Normal</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_fit[]" value="fitfail_1"
                                                                id="fit_fitfail_1" class="selectgroup-input"
                                                                {{ in_array('fitfail_1', old('s_fit', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">OK</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_fit[]" value="fitfail_2"
                                                                id="fit_fitfail_2" class="selectgroup-input"
                                                                {{ in_array('fitfail_2', old('s_fit', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">NOK</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_fit[]" value="fitfail_3"
                                                                id="fit_fitfail_3" class="selectgroup-input"
                                                                {{ in_array('fitfail_3', old('s_fit', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">LOG</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_fit[]" value="fitfail_4"
                                                                id="fit_fitfail_4" class="selectgroup-input"
                                                                {{ in_array('fitfail_4', old('s_fit', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">SLD</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_fit[]" value="fitfail_5"
                                                                id="fit_fitfail_5" class="selectgroup-input"
                                                                {{ in_array('fitfail_5', old('s_fit', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">Tidak Uji</span>
                                                        </label>
                                                    </div>
                                                </div>


                                            </div>
                                            <div class="col-12 col-lg-2 " style="max-height: 800px; overflow-y: auto;">
                                                <div class="form-group ">
                                                    <label for="scb_open_addms">CB Open AddMs</label>
                                                    <div class="input-icon ">
                                                        <input type="text" class="form-control" id="scb_open_addms"
                                                            name="scb_open_addms" placeholder="CB Open AddMs"
                                                            value="{{ old('scb_open_addms') }}" />
                                                        @error('scb_open_addms')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="scb_close_addms">CB Close AddMs</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="scb_close_addms"
                                                            name="scb_close_addms" placeholder="CB Close AddMs"
                                                            value="{{ old('scb_close_addms') }}" />
                                                        @error('scb_close_addms')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="scb2_open_addms">CB2 Open AddMs</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="scb2_open_addms"
                                                            name="scb2_open_addms" placeholder="CB2 Open AddMs"
                                                            value="{{ old('scb2_open_addms') }}" />
                                                        @error('scb2_open_addms')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="scb2_close_addms">CB2 Close AddMs</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="scb2_close_addms"
                                                            name="scb2_close_addms" placeholder="CB2 Close AddMs"
                                                            value="{{ old('scb2_close_addms') }}" />
                                                        @error('scb2_close_addms')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="slr_local_addms">Local AddMs</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="slr_local_addms"
                                                            name="slr_local_addms" placeholder="Local AddMs"
                                                            value="{{ old('slr_local_addms') }}" />
                                                        @error('slr_local_addms')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="slr_remote_addms">Remote AddMs</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="slr_remote_addms"
                                                            name="slr_remote_addms" placeholder="Remote AddMs"
                                                            value="{{ old('slr_remote_addms') }}" />
                                                        @error('slr_remote_addms')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="sdoor_open_addms">Door Open AddMs</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="sdoor_open_addms"
                                                            name="sdoor_open_addms" placeholder="Door Open AddMs"
                                                            value="{{ old('sdoor_open_addms') }}" />
                                                        @error('sdoor_open_addms')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="sdoor_close_addms">Door Close AddMs</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="sdoor_close_addms"
                                                            name="sdoor_close_addms" placeholder="Door Close AddMs"
                                                            value="{{ old('sdoor_close_addms') }}" />
                                                        @error('sdoor_close_addms')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="sacf_normal_addms">AC Normal AddMs</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="sacf_normal_addms"
                                                            name="sacf_normal_addms" placeholder="AC Normal AddMs"
                                                            value="{{ old('sacf_normal_addms') }}" />
                                                        @error('sacf_normal_addms')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="sacf_fail_addms">AC Fail AddMs</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="sacf_fail_addms"
                                                            name="sacf_fail_addms" placeholder="AC Fail AddMs"
                                                            value="{{ old('sacf_fail_addms') }}" />
                                                        @error('sacf_fail_addms')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="sdcf_normal_addms">DCF Normal AddMs</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="sdcf_normal_addms"
                                                            name="sdcf_normal_addms" placeholder="DCF Normal AddMs"
                                                            value="{{ old('sdcf_normal_addms') }}" />
                                                        @error('sdcf_normal_addms')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="sdcf_fail_addms">DCF Fail AddMs</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="sdcf_fail_addms"
                                                            name="sdcf_fail_addms" placeholder="DCF Fail AddMs"
                                                            value="{{ old('sdcf_fail_addms') }}" />
                                                        @error('sdcf_fail_addms')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="sdcd_normal_addms">DCD Normal AddMs</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="sdcd_normal_addms"
                                                            name="sdcd_normal_addms" placeholder="DCD Normal AddMs"
                                                            value="{{ old('sdcd_normal_addms') }}" />
                                                        @error('sdcd_normal_addms')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="sdcd_fail_addms">DCD Fail AddMs</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="sdcd_fail_addms"
                                                            name="sdcd_fail_addms" placeholder="DCD Fail AddMs"
                                                            value="{{ old('sdcd_fail_addms') }}" />
                                                        @error('sdcd_fail_addms')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="shlt_on_addms">HLT On AddMs</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="shlt_on_addms"
                                                            name="shlt_on_addms" placeholder="HLT On AddMs"
                                                            value="{{ old('shlt_on_addms') }}" />
                                                        @error('shlt_on_addms')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="shlt_off_addms">HLT Off AddMs</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="shlt_off_addms"
                                                            name="shlt_off_addms" placeholder="HLT Off AddMs"
                                                            value="{{ old('shlt_off_addms') }}" />
                                                        @error('shlt_off_addms')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="ssf6_normal_addms">SF6 Normal AddMs</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="ssf6_normal_addms"
                                                            name="ssf6_normal_addms" placeholder="SF6 Normal AddMs"
                                                            value="{{ old('ssf6_normal_addms') }}" />
                                                        @error('ssf6_normal_addms')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="ssf6_fail_addms">SF6 Fail AddMs</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="ssf6_fail_addms"
                                                            name="ssf6_fail_addms" placeholder="SF6 Fail AddMs"
                                                            value="{{ old('ssf6_fail_addms') }}" />
                                                        @error('ssf6_fail_addms')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="sfir_normal_addms">FIR Normal AddMs</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="sfir_normal_addms"
                                                            name="sfir_normal_addms" placeholder="FIR Normal AddMs"
                                                            value="{{ old('sfir_normal_addms') }}" />
                                                        @error('sfir_normal_addms')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="sfir_fail_addms">FIR Fail AddMs</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="sfir_fail_addms"
                                                            name="sfir_fail_addms" placeholder="FIR Fail AddMs"
                                                            value="{{ old('sfir_fail_addms') }}" />
                                                        @error('sfir_fail_addms')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="sfis_normal_addms">FIS Normal AddMs</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="sfis_normal_addms"
                                                            name="sfis_normal_addms" placeholder="FIS Normal AddMs"
                                                            value="{{ old('sfis_normal_addms') }}" />
                                                        @error('sfis_normal_addms')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="sfis_fail_addms">FIS Fail AddMs</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="sfis_fail_addms"
                                                            name="sfis_fail_addms" placeholder="FIS Fail AddMs"
                                                            value="{{ old('sfis_fail_addms') }}" />
                                                        @error('sfis_fail_addms')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="sfit_normal_addms">FIT Normal AddMs</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="sfit_normal_addms"
                                                            name="sfit_normal_addms" placeholder="FIT Normal AddMs"
                                                            value="{{ old('sfit_normal_addms') }}" />
                                                        @error('sfit_normal_addms')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="sfit_fail_addms">FIT Fail AddMs</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="sfit_fail_addms"
                                                            name="sfit_fail_addms" placeholder="FIT Fail AddMs"
                                                            value="{{ old('sfit_fail_addms') }}" />
                                                        @error('sfit_fail_addms')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-2" style="max-height: 800px; overflow-y: auto;">
                                                <div class="form-group">
                                                    <label for="scb_open_objfrmt">CB Open OBJ/FRMT</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="scb_open_objfrmt"
                                                            name="scb_open_objfrmt" placeholder="CB Open OBJ/FRMT"
                                                            value="{{ old('scb_open_objfrmt') }}" />
                                                        @error('scb_open_objfrmt')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="scb_close_objfrmt">CB Close OBJ/FRMT</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="scb_close_objfrmt"
                                                            name="scb_close_objfrmt" placeholder="CB Close OBJ/FRMT"
                                                            value="{{ old('scb_close_objfrmt') }}" />
                                                        @error('scb_close_objfrmt')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="scb2_open_objfrmt">CB2 Open OBJ/FRMT</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="scb2_open_objfrmt"
                                                            name="scb2_open_objfrmt" placeholder="CB2 Open OBJ/FRMT"
                                                            value="{{ old('scb2_open_objfrmt') }}" />
                                                        @error('scb2_open_objfrmt')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="scb2_close_objfrmt">CB2 Close OBJ/FRMT</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="scb2_close_objfrmt"
                                                            name="scb2_close_objfrmt" placeholder="CB2 Close OBJ/FRMT"
                                                            value="{{ old('scb2_close_objfrmt') }}" />
                                                        @error('scb2_close_objfrmt')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="slr_local_objfrmt">Local OBJ/FRMT</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="slr_local_objfrmt"
                                                            name="slr_local_objfrmt" placeholder="Local OBJ/FRMT"
                                                            value="{{ old('slr_local_objfrmt') }}" />
                                                        @error('slr_local_objfrmt')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="slr_remote_objfrmt">Remote OBJ/FRMT</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="slr_remote_objfrmt"
                                                            name="slr_remote_objfrmt" placeholder="Remote OBJ/FRMT"
                                                            value="{{ old('slr_remote_objfrmt') }}" />
                                                        @error('slr_remote_objfrmt')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="sdoor_open_objfrmt">Door Open OBJ/FRMT</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="sdoor_open_objfrmt"
                                                            name="sdoor_open_objfrmt" placeholder="Door Open OBJ/FRMT"
                                                            value="{{ old('sdoor_open_objfrmt') }}" />
                                                        @error('sdoor_open_objfrmt')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="sdoor_close_objfrmt">Door Close OBJ/FRMT</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="sdoor_close_objfrmt"
                                                            name="sdoor_close_objfrmt" placeholder="Door Close OBJ/FRMT"
                                                            value="{{ old('sdoor_close_objfrmt') }}" />
                                                        @error('sdoor_close_objfrmt')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="sacf_normal_objfrmt">AC Normal OBJ/FRMT</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="sacf_normal_objfrmt"
                                                            name="sacf_normal_objfrmt" placeholder="AC Normal OBJ/FRMT"
                                                            value="{{ old('sacf_normal_objfrmt') }}" />
                                                        @error('sacf_normal_objfrmt')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="sacf_fail_objfrmt">AC Fail OBJ/FRMT</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="sacf_fail_objfrmt"
                                                            name="sacf_fail_objfrmt" placeholder="AC Fail OBJ/FRMT"
                                                            value="{{ old('sacf_fail_objfrmt') }}" />
                                                        @error('sacf_fail_objfrmt')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="sdcf_normal_objfrmt">DCF Normal OBJ/FRMT</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="sdcf_normal_objfrmt"
                                                            name="sdcf_normal_objfrmt" placeholder="DCF Normal OBJ/FRMT"
                                                            value="{{ old('sdcf_normal_objfrmt') }}" />
                                                        @error('sdcf_normal_objfrmt')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="sdcf_fail_objfrmt">DCF Fail OBJ/FRMT</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="sdcf_fail_objfrmt"
                                                            name="sdcf_fail_objfrmt" placeholder="DC Fail OBJ/FRMT"
                                                            value="{{ old('sdcf_fail_objfrmt') }}" />
                                                        @error('sdcf_fail_objfrmt')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="sdcd_normal_objfrmt">DCD Normal OBJ/FRMT</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="sdcd_normal_objfrmt"
                                                            name="sdcd_normal_objfrmt" placeholder="DCD Normal OBJ/FRMT"
                                                            value="{{ old('sdcd_normal_objfrmt') }}" />
                                                        @error('sdcd_normal_objfrmt')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="sdcd_fail_objfrmt">DCD Fail OBJ/FRMT</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="sdcd_fail_objfrmt"
                                                            name="sdcd_fail_objfrmt" placeholder="DCD Fail OBJ/FRMT"
                                                            value="{{ old('sdcd_fail_objfrmt') }}" />
                                                        @error('sdcd_fail_objfrmt')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="shlt_on_objfrmt">HLT On OBJ/FRMT</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="shlt_on_objfrmt"
                                                            name="shlt_on_objfrmt" placeholder="HLT On OBJ/FRMT"
                                                            value="{{ old('shlt_on_objfrmt') }}" />
                                                        @error('shlt_on_objfrmt')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="shlt_off_objfrmt">HLT Off OBJ/FRMT</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="shlt_off_objfrmt"
                                                            name="shlt_off_objfrmt" placeholder="HLT Off OBJ/FRMT"
                                                            value="{{ old('shlt_off_objfrmt') }}" />
                                                        @error('shlt_off_objfrmt')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="ssf6_normal_objfrmt">SF6 Normal OBJ/FRMT</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="ssf6_normal_objfrmt"
                                                            name="ssf6_normal_objfrmt" placeholder="SF6 Normal OBJ/FRMT"
                                                            value="{{ old('ssf6_normal_objfrmt') }}" />
                                                        @error('ssf6_normal_objfrmt')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="ssf6_fail_objfrmt">SF6 Fail OBJ/FRMT</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="ssf6_fail_objfrmt"
                                                            name="ssf6_fail_objfrmt" placeholder="SF6 Fail OBJ/FRMT"
                                                            value="{{ old('ssf6_fail_objfrmt') }}" />
                                                        @error('ssf6_fail_objfrmt')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="sfir_normal_objfrmt">FIR Normal OBJ/FRMT</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="sfir_normal_objfrmt"
                                                            name="sfir_normal_objfrmt" placeholder="FIR Normal OBJ/FRMT"
                                                            value="{{ old('sfir_normal_objfrmt') }}" />
                                                        @error('sfir_normal_objfrmt')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="sfir_fail_objfrmt">FIR Fail OBJ/FRMT</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="sfir_fail_objfrmt"
                                                            name="sfir_fail_objfrmt" placeholder="FIR Fail OBJ/FRMT"
                                                            value="{{ old('sfir_fail_objfrmt') }}" />
                                                        @error('sfir_fail_objfrmt')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="sfis_normal_objfrmt">FIS Normal OBJ/FRMT</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="sfis_normal_objfrmt"
                                                            name="sfis_normal_objfrmt" placeholder="FIS Normal OBJ/FRMT"
                                                            value="{{ old('sfis_normal_objfrmt') }}" />
                                                        @error('sfis_normal_objfrmt')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="sfis_fail_objfrmt">FIS Fail OBJ/FRMT</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="sfis_fail_objfrmt"
                                                            name="sfis_fail_objfrmt" placeholder="FIS Fail OBJ/FRMT"
                                                            value="{{ old('sfis_fail_objfrmt') }}" />
                                                        @error('sfis_fail_objfrmt')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="sfit_normal_objfrmt">FIT Normal OBJ/FRMT</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="sfit_normal_objfrmt"
                                                            name="sfit_normal_objfrmt" placeholder="FIT Normal OBJ/FRMT"
                                                            value="{{ old('sfit_normal_objfrmt') }}" />
                                                        @error('sfit_normal_objfrmt')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="sfit_fail_objfrmt">FIT Fail OBJ/FRMT</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="sfit_fail_objfrmt"
                                                            name="sfit_fail_objfrmt" placeholder="FIT Fail OBJ/FRMT"
                                                            value="{{ old('sfit_fail_objfrmt') }}" />
                                                        @error('sfit_fail_objfrmt')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-2 " style="max-height: 800px; overflow-y: auto;">
                                                <div class="form-group ">
                                                    <label for="scb_open_addrtu">CB Open AddRtu</label>
                                                    <div class="input-icon ">
                                                        <input type="text" class="form-control" id="scb_open_addrtu"
                                                            name="scb_open_addrtu" placeholder="CB Open AddRtu"
                                                            value="{{ old('scb_open_addrtu') }}" />
                                                        @error('scb_open_addrtu')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="scb_close_addrtu">CB Close AddRtu</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="scb_close_addrtu"
                                                            name="scb_close_addrtu" placeholder="CB Close AddRtu"
                                                            value="{{ old('scb_close_addrtu') }}" />
                                                        @error('scb_close_addrtu')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="scb2_open_addrtu">CB2 Open AddRtu</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="scb2_open_addrtu"
                                                            name="scb2_open_addrtu" placeholder="CB2 Open AddRtu"
                                                            value="{{ old('scb2_open_addrtu') }}" />
                                                        @error('scb2_open_addrtu')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="scb2_close_addrtu">CB2 Close AddRtu</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="scb2_close_addrtu"
                                                            name="scb2_close_addrtu" placeholder="CB2 Close AddRtu"
                                                            value="{{ old('scb2_close_addrtu') }}" />
                                                        @error('scb2_close_addrtu')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="slr_local_addrtu">Local AddRtu</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="slr_local_addrtu"
                                                            name="slr_local_addrtu" placeholder="Local AddRtu"
                                                            value="{{ old('slr_local_addrtu') }}" />
                                                        @error('slr_local_addrtu')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="slr_remote_addrtu">Remote AddRtu</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="slr_remote_addrtu"
                                                            name="slr_remote_addrtu" placeholder="Remote AddRtu"
                                                            value="{{ old('slr_remote_addrtu') }}" />
                                                        @error('slr_remote_addrtu')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="sdoor_open_addrtu">Door Open AddRtu</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="sdoor_open_addrtu"
                                                            name="sdoor_open_addrtu" placeholder="Door Open AddRtu"
                                                            value="{{ old('sdoor_open_addrtu') }}" />
                                                        @error('sdoor_open_addrtu')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="sdoor_close_addrtu">Door Close AddRtu</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="sdoor_close_addrtu"
                                                            name="sdoor_close_addrtu" placeholder="Door Close AddRtu"
                                                            value="{{ old('sdoor_close_addrtu') }}" />
                                                        @error('sdoor_close_addrtu')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="sacf_normal_addrtu">AC Normal AddRtu</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="sacf_normal_addrtu"
                                                            name="sacf_normal_addrtu" placeholder="AC Normal AddRtu"
                                                            value="{{ old('sacf_normal_addrtu') }}" />
                                                        @error('sacf_normal_addrtu')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="sacf_fail_addrtu">AC Fail AddRtu</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="sacf_fail_addrtu"
                                                            name="sacf_fail_addrtu" placeholder="AC Fail AddRtu"
                                                            value="{{ old('sacf_fail_addrtu') }}" />
                                                        @error('sacf_fail_addrtu')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="sdcf_normal_addrtu">DCF Normal AddRtu</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="sdcf_normal_addrtu"
                                                            name="sdcf_normal_addrtu" placeholder="DCF Normal AddRtu"
                                                            value="{{ old('sdcf_normal_addrtu') }}" />
                                                        @error('sdcf_normal_addrtu')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="sdcf_fail_addrtu">DCF Fail AddRtu</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="sdcf_fail_addrtu"
                                                            name="sdcf_fail_addrtu" placeholder="DCF Fail AddRtu"
                                                            value="{{ old('sdcf_fail_addrtu') }}" />
                                                        @error('sdcf_fail_addrtu')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="sdcd_normal_addrtu">DCD Normal AddRtu</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="sdcd_normal_addrtu"
                                                            name="sdcd_normal_addrtu" placeholder="DCD Normal AddRtu"
                                                            value="{{ old('sdcd_normal_addrtu') }}" />
                                                        @error('sdcd_normal_addrtu')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="sdcd_fail_addrtu">DCD Fail AddRtu</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="sdcd_fail_addrtu"
                                                            name="sdcd_fail_addrtu" placeholder="DCD Fail AddRtu"
                                                            value="{{ old('sdcd_fail_addrtu') }}" />
                                                        @error('sdcd_fail_addrtu')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="shlt_on_addrtu">HLT On AddRtu</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="shlt_on_addrtu"
                                                            name="shlt_on_addrtu" placeholder="HLT On AddRtu"
                                                            value="{{ old('shlt_on_addrtu') }}" />
                                                        @error('shlt_on_addrtu')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="shlt_off_addrtu">HLT Off AddRtu</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="shlt_off_addrtu"
                                                            name="shlt_off_addrtu" placeholder="HLT Off AddRtu"
                                                            value="{{ old('shlt_off_addrtu') }}" />
                                                        @error('shlt_off_addrtu')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="ssf6_normal_addrtu">SF6 Normal AddRtu</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="ssf6_normal_addrtu"
                                                            name="ssf6_normal_addrtu" placeholder="SF6 Normal AddRtu"
                                                            value="{{ old('ssf6_normal_addrtu') }}" />
                                                        @error('ssf6_normal_addrtu')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="ssf6_fail_addrtu">SF6 Fail AddRtu</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="ssf6_fail_addrtu"
                                                            name="ssf6_fail_addrtu" placeholder="SF6 Fail AddRtu"
                                                            value="{{ old('ssf6_fail_addrtu') }}" />
                                                        @error('ssf6_fail_addrtu')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="sfir_normal_addrtu">FIR Normal AddRtu</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="sfir_normal_addrtu"
                                                            name="sfir_normal_addrtu" placeholder="FIR Normal AddRtu"
                                                            value="{{ old('sfir_normal_addrtu') }}" />
                                                        @error('sfir_normal_addrtu')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="sfir_fail_addrtu">FIR Fail AddRtu</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="sfir_fail_addrtu"
                                                            name="sfir_fail_addrtu" placeholder="FIR Fail AddRtu"
                                                            value="{{ old('sfir_fail_addrtu') }}" />
                                                        @error('sfir_fail_addrtu')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="sfis_normal_addrtu">FIS Normal AddRtu</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="sfis_normal_addrtu"
                                                            name="sfis_normal_addrtu" placeholder="FIS Normal AddRtu"
                                                            value="{{ old('sfis_normal_addrtu') }}" />
                                                        @error('sfis_normal_addrtu')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="sfis_fail_addrtu">FIS Fail AddRtu</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="sfis_fail_addrtu"
                                                            name="sfis_fail_addrtu" placeholder="FIS Fail AddRtu"
                                                            value="{{ old('sfis_fail_addrtu') }}" />
                                                        @error('sfis_fail_addrtu')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="sfit_normal_addrtu">FIT Normal AddRtu</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="sfit_normal_addrtu"
                                                            name="sfit_normal_addrtu" placeholder="FIT Normal AddRtu"
                                                            value="{{ old('sfit_normal_addrtu') }}" />
                                                        @error('sfit_normal_addrtu')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="sfit_fail_addrtu">FIT Fail AddRtu</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="sfit_fail_addrtu"
                                                            name="sfit_fail_addrtu" placeholder="FIT Fail AddRtu"
                                                            value="{{ old('sfit_fail_addrtu') }}" />
                                                        @error('sfit_fail_addrtu')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="ketfts">Keterangan Form Telestatus</label>
                                                <div class="input-icon">
                                                    <input type="text" class="form-control" id="ketfts" name="ketfts"
                                                        placeholder="Keterangan Form Data"
                                                        value="{{ old('ketfts') }}" />
                                                    @error('ketfts')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <!-- Form Telecontrol Tab -->
                                    <div class="tab-pane fade" id="v-pills-formtelecontrol-nobd" role="tabpanel"
                                        aria-labelledby="v-pills-formtelecontrol-tab-nobd">
                                        <div class="row">
                                            <div class="col-12 col-lg-6">
                                                <div class="form-group">
                                                    <div class="row">
                                                        <label class="form-label t-bold">CB Open</label>
                                                        <div class="selectgroup w-100 flex-wrap">
                                                            <label class="selectgroup-item mb-2 mb-sm-0">
                                                                <input type="checkbox" id="ccb_open_checkAll_ok"
                                                                    class="selectgroup-input" />
                                                                <span class="selectgroup-button">Normal</span>
                                                            </label>
                                                            <label class="selectgroup-item mb-2 mb-sm-0">
                                                                <input type="checkbox" name="c_cb[]" value="cbctrl_op_1"
                                                                    id="ccb_open_1" class="selectgroup-input" />
                                                                <span class="selectgroup-button">OK</span>
                                                            </label>
                                                            <label class="selectgroup-item mb-2 mb-sm-0">
                                                                <input type="checkbox" name="c_cb[]" value="cbctrl_op_2"
                                                                    id="ccb_open_2" class="selectgroup-input" />
                                                                <span class="selectgroup-button">NOK</span>
                                                            </label>
                                                            <label class="selectgroup-item mb-2 mb-sm-0">
                                                                <input type="checkbox" name="c_cb[]" value="cbctrl_op_3"
                                                                    id="ccb_open_3" class="selectgroup-input" />
                                                                <span class="selectgroup-button">LOG</span>
                                                            </label>
                                                            <label class="selectgroup-item mb-2 mb-sm-0">
                                                                <input type="checkbox" name="c_cb[]" value="cbctrl_op_4"
                                                                    id="ccb_open_4" class="selectgroup-input" />
                                                                <span class="selectgroup-button">SLD</span>
                                                            </label>
                                                            <label class="selectgroup-item mb-2 mb-sm-0">
                                                                <input type="checkbox" name="c_cb[]" value="cbctrl_op_5"
                                                                    id="ccb_open_5" class="selectgroup-input" />
                                                                <span class="selectgroup-button">Tidak Uji</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <label class="form-label t-bold">CB Close</label>
                                                        <div class="selectgroup w-100 flex-wrap">
                                                            <label class="selectgroup-item mb-2 mb-sm-0">
                                                                <input type="checkbox" id="ccb_close_checkAll_ok"
                                                                    class="selectgroup-input" />
                                                                <span class="selectgroup-button">Normal</span>
                                                            </label>
                                                            <label class="selectgroup-item mb-2 mb-sm-0">
                                                                <input type="checkbox" name="c_cb[]" value="cbctrl_cl_1"
                                                                    id="ccb_close_1" class="selectgroup-input" />
                                                                <span class="selectgroup-button">OK</span>
                                                            </label>
                                                            <label class="selectgroup-item mb-2 mb-sm-0">
                                                                <input type="checkbox" name="c_cb[]" value="cbctrl_cl_2"
                                                                    id="ccb_close_2" class="selectgroup-input" />
                                                                <span class="selectgroup-button">NOK</span>
                                                            </label>
                                                            <label class="selectgroup-item mb-2 mb-sm-0">
                                                                <input type="checkbox" name="c_cb[]" value="cbctrl_cl_3"
                                                                    id="ccb_close_3" class="selectgroup-input" />
                                                                <span class="selectgroup-button">LOG</span>
                                                            </label>
                                                            <label class="selectgroup-item mb-2 mb-sm-0">
                                                                <input type="checkbox" name="c_cb[]" value="cbctrl_cl_4"
                                                                    id="ccb_close_4" class="selectgroup-input" />
                                                                <span class="selectgroup-button">SLD</span>
                                                            </label>
                                                            <label class="selectgroup-item mb-2 mb-sm-0">
                                                                <input type="checkbox" name="c_cb[]" value="cbctrl_cl_5"
                                                                    id="ccb_close_5" class="selectgroup-input" />
                                                                <span class="selectgroup-button">Tidak Uji</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <label class="form-label t-bold">CB2 Open</label>
                                                        <div class="selectgroup w-100 flex-wrap">
                                                            <label class="selectgroup-item mb-2 mb-sm-0">
                                                                <input type="checkbox" id="ccb2_open_checkAll_ok"
                                                                    class="selectgroup-input" />
                                                                <span class="selectgroup-button">Normal</span>
                                                            </label>
                                                            <label class="selectgroup-item mb-2 mb-sm-0">
                                                                <input type="checkbox" name="c_cb2[]"
                                                                    value="cbctrl2_op_1" id="ccb2_open_1"
                                                                    class="selectgroup-input" />
                                                                <span class="selectgroup-button">OK</span>
                                                            </label>
                                                            <label class="selectgroup-item mb-2 mb-sm-0">
                                                                <input type="checkbox" name="c_cb2[]"
                                                                    value="cbctrl2_op_2" id="ccb2_open_2"
                                                                    class="selectgroup-input" />
                                                                <span class="selectgroup-button">NOK</span>
                                                            </label>
                                                            <label class="selectgroup-item mb-2 mb-sm-0">
                                                                <input type="checkbox" name="c_cb2[]"
                                                                    value="cbctrl2_op_3" id="ccb2_open_3"
                                                                    class="selectgroup-input" />
                                                                <span class="selectgroup-button">LOG</span>
                                                            </label>
                                                            <label class="selectgroup-item mb-2 mb-sm-0">
                                                                <input type="checkbox" name="c_cb2[]"
                                                                    value="cbctrl2_op_4" id="ccb2_open_4"
                                                                    class="selectgroup-input" />
                                                                <span class="selectgroup-button">SLD</span>
                                                            </label>
                                                            <label class="selectgroup-item mb-2 mb-sm-0">
                                                                <input type="checkbox" name="c_cb2[]"
                                                                    value="cbctrl2_op_5" id="ccb2_open_5"
                                                                    class="selectgroup-input" />
                                                                <span class="selectgroup-button">Tidak Uji</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <label class="form-label t-bold">CB2 Close</label>
                                                        <div class="selectgroup w-100 flex-wrap">
                                                            <label class="selectgroup-item mb-2 mb-sm-0">
                                                                <input type="checkbox" id="ccb2_close_checkAll_ok"
                                                                    class="selectgroup-input" />
                                                                <span class="selectgroup-button">Normal</span>
                                                            </label>
                                                            <label class="selectgroup-item mb-2 mb-sm-0">
                                                                <input type="checkbox" name="c_cb2[]"
                                                                    value="cbctrl2_cl_1" id="ccb2_close_1"
                                                                    class="selectgroup-input" />
                                                                <span class="selectgroup-button">OK</span>
                                                            </label>
                                                            <label class="selectgroup-item mb-2 mb-sm-0">
                                                                <input type="checkbox" name="c_cb2[]"
                                                                    value="cbctrl2_cl_2" id="ccb2_close_2"
                                                                    class="selectgroup-input" />
                                                                <span class="selectgroup-button">NOK</span>
                                                            </label>
                                                            <label class="selectgroup-item mb-2 mb-sm-0">
                                                                <input type="checkbox" name="c_cb2[]"
                                                                    value="cbctrl2_cl_3" id="ccb2_close_3"
                                                                    class="selectgroup-input" />
                                                                <span class="selectgroup-button">LOG</span>
                                                            </label>
                                                            <label class="selectgroup-item mb-2 mb-sm-0">
                                                                <input type="checkbox" name="c_cb2[]"
                                                                    value="cbctrl2_cl_4" id="ccb2_close_4"
                                                                    class="selectgroup-input" />
                                                                <span class="selectgroup-button">SLD</span>
                                                            </label>
                                                            <label class="selectgroup-item mb-2 mb-sm-0">
                                                                <input type="checkbox" name="c_cb2[]"
                                                                    value="cbctrl2_cl_5" id="ccb2_close_5"
                                                                    class="selectgroup-input" />
                                                                <span class="selectgroup-button">Tidak Uji</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <label class="form-label t-bold">HLT Off</label>
                                                        <div class="selectgroup w-100 flex-wrap">
                                                            <label class="selectgroup-item mb-2 mb-sm-0">
                                                                <input type="checkbox" id="chlt_off_checkAll_ok"
                                                                    class="selectgroup-input" />
                                                                <span class="selectgroup-button">Normal</span>
                                                            </label>
                                                            <label class="selectgroup-item mb-2 mb-sm-0">
                                                                <input type="checkbox" name="c_hlt[]"
                                                                    value="hltctrl_off_1" id="chlt_off_1"
                                                                    class="selectgroup-input" />
                                                                <span class="selectgroup-button">OK</span>
                                                            </label>
                                                            <label class="selectgroup-item mb-2 mb-sm-0">
                                                                <input type="checkbox" name="c_hlt[]"
                                                                    value="hltctrl_off_2" id="chlt_off_2"
                                                                    class="selectgroup-input" />
                                                                <span class="selectgroup-button">NOK</span>
                                                            </label>
                                                            <label class="selectgroup-item mb-2 mb-sm-0">
                                                                <input type="checkbox" name="c_hlt[]"
                                                                    value="hltctrl_off_3" id="chlt_off_3"
                                                                    class="selectgroup-input" />
                                                                <span class="selectgroup-button">LOG</span>
                                                            </label>
                                                            <label class="selectgroup-item mb-2 mb-sm-0">
                                                                <input type="checkbox" name="c_hlt[]"
                                                                    value="hltctrl_off_4" id="chlt_off_4"
                                                                    class="selectgroup-input" />
                                                                <span class="selectgroup-button">SLD</span>
                                                            </label>
                                                            <label class="selectgroup-item mb-2 mb-sm-0">
                                                                <input type="checkbox" name="c_hlt[]"
                                                                    value="hltctrl_off_5" id="chlt_off_5"
                                                                    class="selectgroup-input" />
                                                                <span class="selectgroup-button">Tidak Uji</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <label class="form-label t-bold">HLT On</label>
                                                        <div class="selectgroup w-100 flex-wrap">
                                                            <label class="selectgroup-item mb-2 mb-sm-0">
                                                                <input type="checkbox" id="chlt_on_checkAll_ok"
                                                                    class="selectgroup-input" />
                                                                <span class="selectgroup-button">Normal</span>
                                                            </label>
                                                            <label class="selectgroup-item mb-2 mb-sm-0">
                                                                <input type="checkbox" name="c_hlt[]"
                                                                    value="hltctrl_on_1" id="chlt_on_1"
                                                                    class="selectgroup-input" />
                                                                <span class="selectgroup-button">OK</span>
                                                            </label>
                                                            <label class="selectgroup-item mb-2 mb-sm-0">
                                                                <input type="checkbox" name="c_hlt[]"
                                                                    value="hltctrl_on_2" id="chlt_on_2"
                                                                    class="selectgroup-input" />
                                                                <span class="selectgroup-button">NOK</span>
                                                            </label>
                                                            <label class="selectgroup-item mb-2 mb-sm-0">
                                                                <input type="checkbox" name="c_hlt[]"
                                                                    value="hltctrl_on_3" id="chlt_on_3"
                                                                    class="selectgroup-input" />
                                                                <span class="selectgroup-button">LOG</span>
                                                            </label>
                                                            <label class="selectgroup-item mb-2 mb-sm-0">
                                                                <input type="checkbox" name="c_hlt[]"
                                                                    value="hltctrl_on_4" id="chlt_on_4"
                                                                    class="selectgroup-input" />
                                                                <span class="selectgroup-button">SLD</span>
                                                            </label>
                                                            <label class="selectgroup-item mb-2 mb-sm-0">
                                                                <input type="checkbox" name="c_hlt[]"
                                                                    value="hltctrl_on_5" id="chlt_on_5"
                                                                    class="selectgroup-input" />
                                                                <span class="selectgroup-button">Tidak Uji</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <label class="form-label t-bold">Reset</label>
                                                        <div class="selectgroup w-100 flex-wrap">
                                                            <label class="selectgroup-item mb-2 mb-sm-0">
                                                                <input type="checkbox" id="crst_on_checkAll_ok"
                                                                    class="selectgroup-input" />
                                                                <span class="selectgroup-button">Normal</span>
                                                            </label>
                                                            <label class="selectgroup-item mb-2 mb-sm-0">
                                                                <input type="checkbox" name="c_rst[]"
                                                                    value="rrctrl_on_1" id="crst_on_1"
                                                                    class="selectgroup-input" />
                                                                <span class="selectgroup-button">OK</span>
                                                            </label>
                                                            <label class="selectgroup-item mb-2 mb-sm-0">
                                                                <input type="checkbox" name="c_rst[]"
                                                                    value="rrctrl_on_2" id="crst_on_2"
                                                                    class="selectgroup-input" />
                                                                <span class="selectgroup-button">NOK</span>
                                                            </label>
                                                            <label class="selectgroup-item mb-2 mb-sm-0">
                                                                <input type="checkbox" name="c_rst[]"
                                                                    value="rrctrl_on_3" id="crst_on_3"
                                                                    class="selectgroup-input" />
                                                                <span class="selectgroup-button">LOG</span>
                                                            </label>
                                                            <label class="selectgroup-item mb-2 mb-sm-0">
                                                                <input type="checkbox" name="c_rst[]"
                                                                    value="rrctrl_on_4" id="crst_on_4"
                                                                    class="selectgroup-input" />
                                                                <span class="selectgroup-button">SLD</span>
                                                            </label>
                                                            <label class="selectgroup-item mb-2 mb-sm-0">
                                                                <input type="checkbox" name="c_rst[]"
                                                                    value="rrctrl_on_5" id="crst_on_5"
                                                                    class="selectgroup-input" />
                                                                <span class="selectgroup-button">Tidak Uji</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-2">
                                                <div class="form-group">
                                                    <label for="ccb_open_addms">CB Open AddMs</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="ccb_open_addms"
                                                            name="ccb_open_addms" placeholder="CB Open AddMs"
                                                            value="{{ old('ccb_open_addms') }}" />
                                                        @error('ccb_open_addms')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="ccb_close_addms">CB Close AddMs</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="ccb_close_addms"
                                                            name="ccb_close_addms" placeholder="CB Close AddMs"
                                                            value="{{ old('ccb_close_addms') }}" />
                                                        @error('ccb_close_addms')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="ccb2_open_addms">CB2 Open AddMs</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="ccb2_open_addms"
                                                            name="ccb2_open_addms" placeholder="CB2 Open AddMs"
                                                            value="{{ old('ccb2_open_addms') }}" />
                                                        @error('ccb2_open_addms')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="ccb2_close_addms">CB2 Close AddMs</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="ccb2_close_addms"
                                                            name="ccb2_close_addms" placeholder="CB2 Close AddMs"
                                                            value="{{ old('ccb2_close_addms') }}" />
                                                        @error('ccb2_close_addms')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="chlt_on_addms">HLT On AddMs</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="chlt_on_addms"
                                                            name="chlt_on_addms" placeholder="HLT On AddMs"
                                                            value="{{ old('chlt_on_addms') }}" />
                                                        @error('chlt_on_addms')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="chlt_off_addms">HLT Off AddMs</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="chlt_off_addms"
                                                            name="chlt_off_addms" placeholder="HLT Off AddMs"
                                                            value="{{ old('chlt_off_addms') }}" />
                                                        @error('chlt_off_addms')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="crst_addms">Reset AddMs</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="crst_addms"
                                                            name="crst_addms" placeholder="Reset AddMs"
                                                            value="{{ old('crst_addms') }}" />
                                                        @error('crst_addms')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-2">
                                                <div class="form-group">
                                                    <label for="ccb_open_addrtu">CB Open AddRtu</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="ccb_open_addrtu"
                                                            name="ccb_open_addrtu" placeholder="CB Open AddRtu"
                                                            value="{{ old('ccb_open_addrtu') }}" />
                                                        @error('ccb_open_addrtu')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="ccb_close_addrtu">CB Close AddRtu</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="ccb_close_addrtu"
                                                            name="ccb_close_addrtu" placeholder="CB Close AddRtu"
                                                            value="{{ old('ccb_close_addrtu') }}" />
                                                        @error('ccb_close_addrtu')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="ccb2_open_addrtu">CB2 Open AddRtu</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="ccb2_open_addrtu"
                                                            name="ccb2_open_addrtu" placeholder="CB2 Open AddRtu"
                                                            value="{{ old('ccb2_open_addrtu') }}" />
                                                        @error('ccb2_open_addrtu')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="ccb2_close_addrtu">CB2 Close AddRtu</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="ccb2_close_addrtu"
                                                            name="ccb2_close_addrtu" placeholder="CB2 Close AddRtu"
                                                            value="{{ old('ccb2_close_addrtu') }}" />
                                                        @error('ccb2_close_addrtu')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="chlt_on_addrtu">HLT On AddRtu</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="chlt_on_addrtu"
                                                            name="chlt_on_addrtu" placeholder="HLT On AddRtu"
                                                            value="{{ old('chlt_on_addrtu') }}" />
                                                        @error('chlt_on_addrtu')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="chlt_off_addrtu">HLT Off AddRtu</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="chlt_off_addrtu"
                                                            name="chlt_off_addrtu" placeholder="HLT Off AddRtu"
                                                            value="{{ old('chlt_off_addrtu') }}" />
                                                        @error('chlt_off_addrtu')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="crst_addrtu">Reset AddRtu</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="crst_addrtu"
                                                            name="crst_addrtu" placeholder="Reset AddRtu"
                                                            value="{{ old('crst_addrtu') }}" />
                                                        @error('crst_addrtu')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-2">
                                                <div class="form-group">
                                                    <label for="ccb_open_objfrmt">CB Open OBJ/FRMT</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="ccb_open_objfrmt"
                                                            name="ccb_open_objfrmt" placeholder="CB Open OBJ/FRMT"
                                                            value="{{ old('ccb_open_objfrmt') }}" />
                                                        @error('ccb_open_objfrmt')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="ccb_close_objfrmt">CB Close OBJ/FRMT</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="ccb_close_objfrmt"
                                                            name="ccb_close_objfrmt" placeholder="CB Close OBJ/FRMT"
                                                            value="{{ old('ccb_close_objfrmt') }}" />
                                                        @error('ccb_close_objfrmt')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="ccb2_open_objfrmt">CB2 Open OBJ/FRMT</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="ccb2_open_objfrmt"
                                                            name="ccb2_open_objfrmt" placeholder="CB2 Open OBJ/FRMT"
                                                            value="{{ old('ccb2_open_objfrmt') }}" />
                                                        @error('ccb2_open_objfrmt')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="ccb2_close_objfrmt">CB2 Close OBJ/FRMT</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="ccb2_close_objfrmt"
                                                            name="ccb2_close_objfrmt" placeholder="CB2 Close OBJ/FRMT"
                                                            value="{{ old('ccb2_close_objfrmt') }}" />
                                                        @error('ccb2_close_objfrmt')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="chlt_on_objfrmt">HLT On OBJ/FRMT</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="chlt_on_objfrmt"
                                                            name="chlt_on_objfrmt" placeholder="HLT On OBJ/FRMT"
                                                            value="{{ old('chlt_on_objfrmt') }}" />
                                                        @error('chlt_on_objfrmt')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="chlt_off_objfrmt">HLT Off OBJ/FRMT</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="chlt_off_objfrmt"
                                                            name="chlt_off_objfrmt" placeholder="HLT Off OBJ/FRMT"
                                                            value="{{ old('chlt_off_objfrmt') }}" />
                                                        @error('chlt_off_objfrmt')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="crst_objfrmt">Reset OBJ/FRMT</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="crst_objfrmt"
                                                            name="crst_objfrmt" placeholder="Reset OBJ/FRMT"
                                                            value="{{ old('crst_objfrmt') }}" />
                                                        @error('crst_objfrmt')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="ketftc">Keterangan Form Telecontrol</label>
                                                <div class="input-icon">
                                                    <input type="text" class="form-control" id="ketftc" name="ketftc"
                                                        placeholder="Keterangan Form Data"
                                                        value="{{ old('ketftc') }}" />
                                                    @error('ketftc')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Form Telemetering Tab -->
                                    <div class="tab-pane fade" id="v-pills-formtelemetering-nobd" role="tabpanel"
                                        aria-labelledby="v-pills-formtelemetering-tab-nobd">
                                        <div class="row">

                                            {{-- 1. DEFINISI HELPER DATA --}}
                                            @php
                                            $fields = [
                                            // GROUP: ARUS
                                            ['key' => 'ir', 'label' => 'Arus Phase R', 'db' => 't_ir'],
                                            ['key' => 'is', 'label' => 'Arus Phase S', 'db' => 't_is'],
                                            ['key' => 'it', 'label' => 'Arus Phase T', 'db' => 't_it'],
                                            ['key' => 'in', 'label' => 'Arus Phase Netral', 'db' => 't_in'],

                                            // GROUP: TEGANGAN INPUT
                                            ['key' => 'vrin', 'label' => 'Teg Input Phase R', 'db' => 't_vrin'],
                                            ['key' => 'vsin', 'label' => 'Teg Input Phase S', 'db' => 't_vsin'],
                                            ['key' => 'vtin', 'label' => 'Teg Input Phase T', 'db' => 't_vtin'],

                                            // GROUP: TEGANGAN OUTPUT
                                            ['key' => 'vrout', 'label' => 'Teg Output Phase R', 'db' => 't_vrout'],
                                            ['key' => 'vsout', 'label' => 'Teg Output Phase S', 'db' => 't_vsout'],
                                            ['key' => 'vtout', 'label' => 'Teg Output Phase T', 'db' => 't_vtout'],

                                            // GROUP: RATA-RATA & LAINNYA
                                            ['key' => 'vavg', 'label' => 'Tegangan Rata Rata', 'db' => 't_vavg'],
                                            ['key' => 'iavg', 'label' => 'Arus Rata Rata', 'db' => 't_iavg'],
                                            ['key' => 'hz', 'label' => 'Frekuensi', 'db' => 't_hz'],
                                            ['key' => 'pf', 'label' => 'Faktor Daya', 'db' => 't_pf'],

                                            // GROUP: ARUS GANGGUAN (FAULT)
                                            ['key' => 'ifr', 'label' => 'Arus Gangguan Phase R', 'db' => 't_ifr'],
                                            ['key' => 'ifs', 'label' => 'Arus Gangguan Phase S', 'db' => 't_ifs'],
                                            ['key' => 'ift', 'label' => 'Arus Gangguan Phase T', 'db' => 't_ift'],
                                            ['key' => 'ifn', 'label' => 'Arus Gangguan Phase N', 'db' => 't_ifn'],

                                            // GROUP: PSEUDO FAULT (Perhatikan ejaan 'psuedo' sesuai DB)
                                            ['key' => 'ifr_psuedo', 'label' => 'Arus Gangguan Phase R (Psuedo)', 'db' =>
                                            't_ifr_psuedo'],
                                            ['key' => 'ifs_psuedo', 'label' => 'Arus Gangguan Phase S (Psuedo)', 'db' =>
                                            't_ifs_psuedo'],
                                            ['key' => 'ift_psuedo', 'label' => 'Arus Gangguan Phase T (Psuedo)', 'db' =>
                                            't_ift_psuedo'],
                                            ['key' => 'ifn_psuedo', 'label' => 'Arus Gangguan Phase N (Psuedo)', 'db' =>
                                            't_ifn_psuedo'],
                                            ];
                                            @endphp

                                            {{-- 2. KOLOM KIRI: CHECKBOX (Selectgroup) --}}
                                            <div class="col-md-6" style="max-height: 800px; overflow-y: auto;">
                                                @foreach($fields as $f)
                                                <div class="form-group border-bottom pb-2">
                                                    <label class="form-label t-bold">{{ $f['label'] }}</label>
                                                    <div class="selectgroup w-100 flex-wrap mb-1">

                                                        {{-- Logic untuk mengambil Value Checkbox (Old input atau dari DB) --}}
                                                        @php
                                                        $dbKey = $f['db'];
                                                        $checkedValues = old($dbKey, isset($keypoint->$dbKey) ?
                                                        explode(',', $keypoint->$dbKey) : []);
                                                        @endphp

                                                        <label class="selectgroup-item mb-1 mb-sm-0">
                                                            <input type="checkbox" name="{{ $dbKey }}[]"
                                                                value="{{ $dbKey }}1" class="selectgroup-input"
                                                                {{ in_array($dbKey.'1', $checkedValues) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">OK</span>
                                                        </label>

                                                        <label class="selectgroup-item mb-1 mb-sm-0">
                                                            <input type="checkbox" name="{{ $dbKey }}[]"
                                                                value="{{ $dbKey }}2" class="selectgroup-input"
                                                                {{ in_array($dbKey.'2', $checkedValues) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">NOK</span>
                                                        </label>

                                                        <label class="selectgroup-item mb-1 mb-sm-0">
                                                            <input type="checkbox" name="{{ $dbKey }}[]"
                                                                value="{{ $dbKey }}5" class="selectgroup-input"
                                                                {{ in_array($dbKey.'5', $checkedValues) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">SLD</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>

                                            {{-- 3. KOLOM TENGAH: RTU, MASTER, SCALE --}}
                                            <div class="col-md-3" style="max-height: 800px; overflow-y: auto;">
                                                @foreach($fields as $f)
                                                <div class="form-group border-bottom pb-2">
                                                    <label class="t-bold text-primary">{{ $f['label'] }}</label>

                                                    {{-- Input RTU --}}
                                                    <input type="text"
                                                        class="form-control mb-1 @error($f['key'].'_rtu') is-invalid @enderror"
                                                        placeholder="{{ strtoupper($f['key']) }} RTU"
                                                        name="{{ $f['key'] }}_rtu"
                                                        value="{{ old($f['key'].'_rtu', $keypoint->{$f['key'].'_rtu'} ?? '') }}">
                                                    @error($f['key'].'_rtu') <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div> @enderror

                                                    {{-- Input Master --}}
                                                    <input type="text"
                                                        class="form-control mb-1 @error($f['key'].'_ms') is-invalid @enderror"
                                                        placeholder="{{ strtoupper($f['key']) }} Master"
                                                        name="{{ $f['key'] }}_ms"
                                                        value="{{ old($f['key'].'_ms', $keypoint->{$f['key'].'_ms'} ?? '') }}">
                                                    @error($f['key'].'_ms') <div class="invalid-feedback">{{ $message }}
                                                    </div> @enderror

                                                    {{-- Input Scale --}}
                                                    <input type="text"
                                                        class="form-control @error($f['key'].'_scale') is-invalid @enderror"
                                                        placeholder="Scale" name="{{ $f['key'] }}_scale"
                                                        value="{{ old($f['key'].'_scale', $keypoint->{$f['key'].'_scale'} ?? '') }}">
                                                    @error($f['key'].'_scale') <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div> @enderror
                                                </div>
                                                @endforeach
                                            </div>

                                            {{-- 4. KOLOM KANAN: ADDMS, ADDRTU, OBJFORMAT --}}
                                            <div class="col-md-3" style="max-height: 800px; overflow-y: auto;">
                                                @foreach($fields as $f)
                                                <div class="form-group border-bottom pb-2">
                                                    <label class="t-bold text-success">{{ $f['label'] }}</label>

                                                    {{-- Logic Cek apakah ini kolom Psuedo --}}
                                                    @php
                                                    $isPsuedo = strpos($f['key'], 'psuedo') !== false;
                                                    @endphp

                                                    {{-- Input Add MS (Readonly jika Psuedo) --}}
                                                    <input type="text"
                                                        class="form-control mb-1 @error($f['key'].'_addms') is-invalid @enderror"
                                                        placeholder="{{ strtoupper($f['key']) }} ADDMS"
                                                        name="{{ $f['key'] }}_addms"
                                                        value="{{ old($f['key'].'_addms', $keypoint->{$f['key'].'_addms'} ?? '') }}"
                                                        {{ $isPsuedo ? 'readonly' : '' }}>
                                                    {{-- Tambahkan atribut readonly di sini --}}

                                                    @error($f['key'].'_addms') <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div> @enderror

                                                    {{-- Input Add RTU --}}
                                                    <input type="text"
                                                        class="form-control mb-1 @error($f['key'].'_addrtu') is-invalid @enderror"
                                                        placeholder="{{ strtoupper($f['key']) }} ADDRTU"
                                                        name="{{ $f['key'] }}_addrtu"
                                                        value="{{ old($f['key'].'_addrtu', $keypoint->{$f['key'].'_addrtu'} ?? '') }}">
                                                    @error($f['key'].'_addrtu') <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div> @enderror

                                                    {{-- Input Obj Format --}}
                                                    <input type="text"
                                                        class="form-control @error($f['key'].'_addobjfrmt') is-invalid @enderror"
                                                        placeholder="OBJECT FORMAT" name="{{ $f['key'] }}_addobjfrmt"
                                                        value="{{ old($f['key'].'_addobjfrmt', $keypoint->{$f['key'].'_addobjfrmt'} ?? '') }}">
                                                    @error($f['key'].'_addobjfrmt') <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div> @enderror
                                                </div>
                                                @endforeach
                                            </div>

                                            {{-- 5. KETERANGAN FORM (Footer) --}}
                                            <div class="col-md-12 mt-3">
                                                <div class="form-group">
                                                    <label for="ketftm">Keterangan Form Telemetering</label>
                                                    <div class="input-icon">
                                                        <input type="text"
                                                            class="form-control @error('ketftm') is-invalid @enderror"
                                                            id="ketftm" name="ketftm" placeholder="Keterangan Form Data"
                                                            value="{{ old('ketftm', $keypoint->ketftm ?? '') }}" />
                                                        @error('ketftm')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                        </div> {{-- End Row --}}
                                    </div>
                                    <!-- HardWare -->
                                    <div class="tab-pane fade show" id="v-pills-formhardware-nobd" role="tabpanel"
                                        aria-labelledby="v-pills-formhardware-tab-nobd">
                                        <div class="row g-3 g-lg-4">
                                            <div class="col-12 col-lg-6">
                                                <div class="form-group">
                                                    <label class="form-label t-bold">Batere</label>
                                                    <div class="selectgroup w-100 flex-wrap">
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="hard_batere[]"
                                                                value="hard_batere1" class="selectgroup-input"
                                                                {{ in_array('hard_batere1', $getOld('hard_batere')) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">OK</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="hard_batere[]"
                                                                value="hard_batere2" class="selectgroup-input"
                                                                {{ in_array('hard_batere2', $getOld('hard_batere')) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">NOK</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="hard_batere[]"
                                                                value="hard_batere5" class="selectgroup-input"
                                                                {{ in_array('hard_batere5', $getOld('hard_batere')) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">Tidak Ada</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label t-bold">PS 220</label>
                                                    <div class="selectgroup w-100 flex-wrap">
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="hard_ps[]" value="hard_ps1"
                                                                class="selectgroup-input"
                                                                {{ in_array('hard_ps1', $getOld('hard_ps')) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">OK</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="hard_ps[]" value="hard_ps2"
                                                                class="selectgroup-input"
                                                                {{ in_array('hard_ps2', $getOld('hard_ps')) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">NOK</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="hard_ps[]" value="hard_ps5"
                                                                class="selectgroup-input"
                                                                {{ in_array('hard_ps5', $getOld('hard_ps')) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">Tidak ada</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label t-bold">Charger</label>
                                                    <div class="selectgroup w-100 flex-wrap">
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="hard_charger[]"
                                                                value="hard_charger1" class="selectgroup-input"
                                                                {{ in_array('hard_charger1', $getOld('hard_charger')) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">OK</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="hard_charger[]"
                                                                value="hard_charger2" class="selectgroup-input"
                                                                {{ in_array('hard_charger2', $getOld('hard_charger')) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">NOK</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="hard_charger[]"
                                                                value="hard_charger5" class="selectgroup-input"
                                                                {{ in_array('hard_charger5', $getOld('hard_charger')) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">Tidak ada</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label t-bold">Limit Switch</label>
                                                    <div class="selectgroup w-100 flex-wrap">
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="hard_limitswith[]"
                                                                value="hard_limitswith1" class="selectgroup-input"
                                                                {{ in_array('hard_limitswith1', $getOld('hard_limitswith')) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">OK</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="hard_limitswith[]"
                                                                value="hard_limitswith2" class="selectgroup-input"
                                                                {{ in_array('hard_limitswith2', $getOld('hard_limitswith')) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">NOK</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="hard_limitswith[]"
                                                                value="hard_limitswith5" class="selectgroup-input"
                                                                {{ in_array('hard_limitswith5', $getOld('hard_limitswith')) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">Tidak ada</span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12 col-lg-4">
                                                <div class="form-group">
                                                    <label for="hard_batere_input">Batere</label>
                                                    <input
                                                        class="form-control @error('hard_batere_input') is-invalid @enderror"
                                                        id="hard_batere_input" placeholder="30 db"
                                                        name="hard_batere_input" value="{{ old('hard_batere_input') }}">
                                                    @error('hard_batere_input')<div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>@enderror
                                                </div>
                                                <div class="form-group">
                                                    <label for="hard_ps_input">PS 220</label>
                                                    <input
                                                        class="form-control @error('hard_ps_input') is-invalid @enderror"
                                                        id="hard_ps_input" placeholder="30 db" name="hard_ps_input"
                                                        value="{{ old('hard_ps_input') }}">
                                                    @error('hard_ps_input')<div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>@enderror
                                                </div>
                                                <div class="form-group">
                                                    <label for="hard_charger_input">Charger</label>
                                                    <input
                                                        class="form-control @error('hard_charger_input') is-invalid @enderror"
                                                        id="hard_charger_input" placeholder="30 db"
                                                        name="hard_charger_input"
                                                        value="{{ old('hard_charger_input') }}">
                                                    @error('hard_charger_input')<div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>@enderror
                                                </div>
                                                <div class="form-group">
                                                    <label for="hard_limitswith_input">Limit Switch</label>
                                                    <input
                                                        class="form-control @error('hard_limitswith_input') is-invalid @enderror"
                                                        id="hard_limitswith_input" placeholder="30 db"
                                                        name="hard_limitswith_input"
                                                        value="{{ old('hard_limitswith_input') }}">
                                                    @error('hard_limitswith_input')<div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>@enderror
                                                </div>
                                                <div class="form-group">
                                                    <label for="kethard">Keterangan Form Hardware</label>
                                                    <input type="text" class="form-control" id="kethard" name="kethard"
                                                        placeholder="Keterangan Form Hardware"
                                                        value="{{ old('kethard') }}" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- System -->
                                    <div class="tab-pane fade show" id="v-pills-formsystem-nobd" role="tabpanel"
                                        aria-labelledby="v-pills-formsystem-tab-nobd">
                                        <div class="row g-3 g-lg-4">
                                            <div class="col-12 col-lg-6">
                                                <div class="form-group">
                                                    <label class="form-label t-bold">COMF</label>
                                                    <div class="selectgroup w-100 flex-wrap">
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="sys_comf[]" value="sys_comf1"
                                                                class="selectgroup-input"
                                                                {{ in_array('sys_comf1', $getOld('sys_comf')) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">OK</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="sys_comf[]" value="sys_comf2"
                                                                class="selectgroup-input"
                                                                {{ in_array('sys_comf2', $getOld('sys_comf')) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">NOK</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="sys_comf[]" value="sys_comf5"
                                                                class="selectgroup-input"
                                                                {{ in_array('sys_comf5', $getOld('sys_comf')) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">Tidak Ada</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label t-bold">LRUF</label>
                                                    <div class="selectgroup w-100 flex-wrap">
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="sys_lruf[]" value="sys_lruf1"
                                                                class="selectgroup-input"
                                                                {{ in_array('sys_lruf1', $getOld('sys_lruf')) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">OK</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="sys_lruf[]" value="sys_lruf2"
                                                                class="selectgroup-input"
                                                                {{ in_array('sys_lruf2', $getOld('sys_lruf')) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">NOK</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="sys_lruf[]" value="sys_lruf5"
                                                                class="selectgroup-input"
                                                                {{ in_array('sys_lruf5', $getOld('sys_lruf')) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">Tidak ada</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label t-bold">Sign Strength</label>
                                                    <div class="selectgroup w-100 flex-wrap">
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="sys_signs[]" value="sys_signs1"
                                                                class="selectgroup-input"
                                                                {{ in_array('sys_signs1', $getOld('sys_signs')) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">OK</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="sys_signs[]" value="sys_signs2"
                                                                class="selectgroup-input"
                                                                {{ in_array('sys_signs2', $getOld('sys_signs')) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">NOK</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="sys_signs[]" value="sys_signs5"
                                                                class="selectgroup-input"
                                                                {{ in_array('sys_signs5', $getOld('sys_signs')) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">Tidak ada</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label t-bold">Limit Switch</label>
                                                    <div class="selectgroup w-100 flex-wrap">
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="sys_limitswith[]"
                                                                value="sys_limitswith1" class="selectgroup-input"
                                                                {{ in_array('sys_limitswith1', $getOld('sys_limitswith')) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">OK</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="sys_limitswith[]"
                                                                value="sys_limitswith2" class="selectgroup-input"
                                                                {{ in_array('sys_limitswith2', $getOld('sys_limitswith')) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">NOK</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="sys_limitswith[]"
                                                                value="sys_limitswith5" class="selectgroup-input"
                                                                {{ in_array('sys_limitswith5', $getOld('sys_limitswith')) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">Tidak ada</span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12 col-lg-4">
                                                <div class="form-group">
                                                    <label for="sys_comf_input">COMF</label>
                                                    <input
                                                        class="form-control @error('sys_comf_input') is-invalid @enderror"
                                                        id="sys_comf_input" placeholder="30 db" name="sys_comf_input"
                                                        value="{{ old('sys_comf_input') }}">
                                                    @error('sys_comf_input')<div class="invalid-feedback">{{ $message }}
                                                    </div>@enderror
                                                </div>

                                                <div class="form-group">
                                                    <label for="sys_lruf_input">LRUF</label>
                                                    <input
                                                        class="form-control @error('sys_lruf_input') is-invalid @enderror"
                                                        id="sys_lruf_input" placeholder="30 db" name="sys_lruf_input"
                                                        value="{{ old('sys_lruf_input') }}">
                                                    @error('sys_lruf_input')<div class="invalid-feedback">{{ $message }}
                                                    </div>@enderror
                                                </div>

                                                <div class="form-group">
                                                    <label for="sys_signs_input">Sign Strength</label>
                                                    <input
                                                        class="form-control @error('sys_signs_input') is-invalid @enderror"
                                                        id="sys_signs_input" placeholder="30 db" name="sys_signs_input"
                                                        value="{{ old('sys_signs_input') }}">
                                                    @error('sys_signs_input')<div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>@enderror
                                                </div>

                                                <div class="form-group">
                                                    <label for="sys_limitswith_input">Limit Switch</label>
                                                    <input
                                                        class="form-control @error('sys_limitswith_input') is-invalid @enderror"
                                                        id="sys_limitswith_input" placeholder="30 db"
                                                        name="sys_limitswith_input"
                                                        value="{{ old('sys_limitswith_input') }}">
                                                    @error('sys_limitswith_input')<div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>@enderror
                                                </div>

                                                <div class="form-group">
                                                    <label for="ketsys">Keterangan Form System</label>
                                                    <input type="text" class="form-control" id="ketsys" name="ketsys"
                                                        placeholder="Keterangan Form System"
                                                        value="{{ old('ketsys') }}" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Recloser -->
                                    <div class="tab-pane fade show" id="v-pills-formrecloser-nobd" role="tabpanel"
                                        aria-labelledby="v-pills-formrecloser-tab-nobd">
                                        <div class="row g-3 g-lg-4">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label class="form-label t-bold">AR ON</label>
                                                    <div class="selectgroup w-100 flex-wrap">
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="re_ar_on[]" value="re_ar_on1"
                                                                class="selectgroup-input"
                                                                {{ in_array('re_ar_on1', $getOld('re_ar_on')) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">OK</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="re_ar_on[]" value="re_ar_on2"
                                                                class="selectgroup-input"
                                                                {{ in_array('re_ar_on2', $getOld('re_ar_on')) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">NOK</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="re_ar_on[]" value="re_ar_on5"
                                                                class="selectgroup-input"
                                                                {{ in_array('re_ar_on5', $getOld('re_ar_on')) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">Tidak Ada</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label t-bold">AR OFF</label>
                                                    <div class="selectgroup w-100 flex-wrap">
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="re_ar_off[]" value="re_ar_off1"
                                                                class="selectgroup-input"
                                                                {{ in_array('re_ar_off1', $getOld('re_ar_off')) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">OK</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="re_ar_off[]" value="re_ar_off2"
                                                                class="selectgroup-input"
                                                                {{ in_array('re_ar_off2', $getOld('re_ar_off')) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">NOK</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="re_ar_off[]" value="re_ar_off5"
                                                                class="selectgroup-input"
                                                                {{ in_array('re_ar_off5', $getOld('re_ar_off')) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">Tidak Ada</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label t-bold">CTRL AR ON</label>
                                                    <div class="selectgroup w-100 flex-wrap">
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="re_ctrl_ar_on[]"
                                                                value="re_ctrl_ar_on1" class="selectgroup-input"
                                                                {{ in_array('re_ctrl_ar_on1', $getOld('re_ctrl_ar_on')) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">OK</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="re_ctrl_ar_on[]"
                                                                value="re_ctrl_ar_on2" class="selectgroup-input"
                                                                {{ in_array('re_ctrl_ar_on2', $getOld('re_ctrl_ar_on')) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">NOK</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="re_ctrl_ar_on[]"
                                                                value="re_ctrl_ar_on5" class="selectgroup-input"
                                                                {{ in_array('re_ctrl_ar_on5', $getOld('re_ctrl_ar_on')) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">Tidak Ada</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label t-bold">CTRL AR OFF</label>
                                                    <div class="selectgroup w-100 flex-wrap">
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="re_ctrl_ar_off[]"
                                                                value="re_ctrl_ar_off1" class="selectgroup-input"
                                                                {{ in_array('re_ctrl_ar_off1', $getOld('re_ctrl_ar_off')) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">OK</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="re_ctrl_ar_off[]"
                                                                value="re_ctrl_ar_off2" class="selectgroup-input"
                                                                {{ in_array('re_ctrl_ar_off2', $getOld('re_ctrl_ar_off')) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">NOK</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="re_ctrl_ar_off[]"
                                                                value="re_ctrl_ar_off5" class="selectgroup-input"
                                                                {{ in_array('re_ctrl_ar_off5', $getOld('re_ctrl_ar_off')) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">Tidak Ada</span>
                                                        </label>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="ketre">Keterangan Form Recloser</label>
                                                    <input type="text" class="form-control" id="ketre" name="ketre"
                                                        placeholder="Keterangan Form Recloser"
                                                        value="{{ old('ketre') }}" />
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
                                        <div class="custom-form-container">
                                            <div class="custom-form-group">
                                                <label for="id_pelms" class="custom-label">Pelaksana Master
                                                    II</label>
                                                <div class="custom-select-wrapper" id="ms-wrapper">
                                                    <div class="selected-items" id="selected-items-ms"></div>
                                                    <input type="hidden" id="id_pelms" name="id_pelms"
                                                        value="{{ old('id_pelms') }}">
                                                    <div class="dropdown" id="dropdown-options-ms">
                                                        @foreach ($pelms as $item)
                                                        <div class="dropdown-item" data-id="{{ $item->id_picmaster }}">
                                                            {{ $item->nama_picmaster }}
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                                <div class="invalid-feedback" id="error-message-ms"
                                                    style="display: none;">
                                                    Please select at least one option.
                                                </div>
                                                @error('id_pelms')
                                                <div class="invalid-feedback" style="display: block;">{{ $message }}
                                                </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="custom-form-container">
                                            <div class="custom-form-group">
                                                <label for="id_pelrtu" class="custom-label">Pelaksana RTU II
                                                    II</label>
                                                <div class="custom-select-wrapper" id="rtu-wrapper">
                                                    <div class="selected-items" id="selected-items-rtu"></div>
                                                    <input type="hidden" id="id_pelrtu" name="id_pelrtu"
                                                        value="{{ old('id_pelrtu') }}">
                                                    <div class="dropdown" id="dropdown-options-rtu">
                                                        @foreach ($pelrtus as $item)
                                                        <div class="dropdown-item" data-id="{{ $item->id_pelrtu }}">
                                                            {{ $item->nama_pelrtu }}
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                                <div class="invalid-feedback" id="error-message-rtu"
                                                    style="display: none;">
                                                    Please select at least one option.
                                                </div>
                                                @error('id_pelrtu')
                                                <div class="invalid-feedback" style="display: block;">{{ $message }}
                                                </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="ketpk">Keterangan PIC Kom</label>
                                            <div class="input-icon">
                                                <input type="text" class="form-control" id="ketpk" name="ketpk"
                                                    placeholder="Keterangan Form Data" value="{{ old('ketpk') }}" />
                                                @error('ketpk')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="catatankp">Catatan</label>
                            <textarea class="form-control text-uppercase @error('catatankp') is-invalid @enderror"
                                id="catatankp" name="catatankp" style="height: 155px;">{{ old('catatankp') }}</textarea>
                            @error('catatankp')
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
function initializeCustomSelect(wrapperId, selectedItemsId, hiddenInputId, dropdownId, errorId) {
    const wrapper = document.getElementById(wrapperId);
    const selectedItems = document.getElementById(selectedItemsId);
    const hiddenInput = document.getElementById(hiddenInputId);
    const dropdown = document.getElementById(dropdownId);
    const errorMessage = document.getElementById(errorId);
    const maxSelections = 2;

    let selectedValues = (hiddenInput.value.split(",").filter(v => v)); // Remove empty strings

    function handleSelection() {
        selectedItems.innerHTML = "";
        hiddenInput.value = selectedValues.join(",");
        selectedValues.forEach((value) => {
            const option = dropdown.querySelector(`.dropdown-item[data-id="${value}"]`);
            if (option) {
                const div = document.createElement("div");
                div.className = "selected-item";
                div.innerHTML = `${option.textContent} <button class="remove-item">×</button>`;
                selectedItems.appendChild(div);
                div.querySelector('.remove-item').addEventListener('click', () => removeSelection(value));
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
        } else if (selectedValues.length < maxSelections) {
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

    // Add click event to dropdown items
    dropdown.addEventListener("click", (e) => {
        const item = e.target.closest(".dropdown-item");
        if (item) {
            const value = item.getAttribute("data-id");
            toggleSelection(value);
        }
    });

    // Initialize
    document.addEventListener("DOMContentLoaded", handleSelection);
}

// For PIC Master II
initializeCustomSelect('ms-wrapper', 'selected-items-ms', 'id_pelms', 'dropdown-options-ms', 'error-message-ms');

// For Pelaksana RTU II
initializeCustomSelect('rtu-wrapper', 'selected-items-rtu', 'id_pelrtu', 'dropdown-options-rtu', 'error-message-rtu');
</script>
<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
<script src="{{ asset('assets/js/core/jquery-3.7.1.min.js') }}"></script>
<script>
$(document).ready(function() {
    var oldGi = "{{ old('id_gi') }}";
    var oldPeny = "{{ old('nama_peny') }}";
    var oldLbs = "{{ old('nama_lbs') }}";
    var oldSec = "{{ old('nama_sec') }}";

    if (oldGi) {
        $('#id_gi').val(oldGi).change();
    }

    // Make checkboxes exclusive and prevent both from being unchecked
    $('#changer_select').change(function() {
        if (this.checked) {
            $('#changer_input').prop('checked', false);
        } else {
            if (!$('#changer_input').is(':checked')) {
                this.checked = true; // Prevent unchecking if the other is not checked
            }
        }
        toggleMode();
    });

    $('#changer_input').change(function() {
        if (this.checked) {
            $('#changer_select').prop('checked', false);
        } else {
            if (!$('#changer_select').is(':checked')) {
                this.checked = true; // Prevent unchecking if the other is not checked
            }
        }
        toggleMode();
    });

    function toggleMode() {
        // Set mode_input value: 1 for input mode (true), 0 for select mode (false)
        $('#mode_input').val($('#changer_input').is(':checked') ? 1 : 0);

        if ($('#changer_input').is(':checked')) {
            // Input mode
            $('#nama_lbs_select_container').hide();
            $('#nama_lbs_input_container').show();
            $('#nama_sec_select_container').hide();
            $('#nama_sec_input_container').show();
            $('#nama_lbs_select').attr('name', '').removeAttr('required');
            $('#nama_lbs_input').attr('name', 'nama_lbs').attr('required', 'required');
            $('#nama_sec_select').attr('name', '').removeAttr('required');
            $('#nama_sec_input').attr('name', 'nama_sec').attr('required', 'required');
            $('#nama_lbs_input').val(oldLbs);
            $('#nama_sec_input').val(oldSec);
        } else {
            // Select mode (default)
            $('#nama_lbs_select_container').show();
            $('#nama_lbs_input_container').hide();
            $('#nama_sec_select_container').show();
            $('#nama_sec_input_container').hide();
            $('#nama_lbs_select').attr('name', 'nama_lbs').attr('required', 'required');
            $('#nama_lbs_input').attr('name', '').removeAttr('required');
            $('#nama_sec_select').attr('name', 'nama_sec').attr('required', 'required');
            $('#nama_sec_input').attr('name', '').removeAttr('required');
            $('#nama_lbs_select').val(oldLbs);
            $('#nama_sec_select').val(oldSec);
        }
    }

    toggleMode(); // Initial toggle
    $('#id_gi').change(function() {
        var garduInduk = $(this).val();
        if (garduInduk) {
            var urlTemplate = '{{ route("get.penyulang", "PLACEHOLDER") }}';
            var url = urlTemplate.replace('PLACEHOLDER', encodeURIComponent(garduInduk));
            $.ajax({
                url: url,
                type: "GET",
                dataType: "json",
                success: function(data) {
                    $('#nama_peny').empty();
                    $('#nama_peny').append(
                        '<option value="">Pilih Nama Penyulangan</option>');
                    $.each(data, function(key, value) {
                        $('#nama_peny').append('<option value="' + value + '">' +
                            value + '</option>');
                    });
                    if (oldPeny) {
                        $('#nama_peny').val(oldPeny).change();
                        oldPeny = '';
                    }
                    $('#nama_lbs_select').empty();
                    $('#nama_lbs_select').append(
                        '<option value="">Pilih Nama Keypoint</option>');
                    $('#nama_sec_select').empty();
                    $('#nama_sec_select').append(
                        '<option value="">Pilih Sectoral</option>');
                },
                error: function(xhr, status, error) {
                    console.log('AJAX error: ' + xhr.status + ' - ' + status + ' - ' +
                        error);
                    console.log(xhr.responseText);
                }
            });
        } else {
            $('#nama_peny').empty();
            $('#nama_peny').append('<option value="">Pilih Nama Penyulangan</option>');
            $('#nama_lbs_select').empty();
            $('#nama_lbs_select').append('<option value="">Pilih Nama Keypoint</option>');
            $('#nama_sec_select').empty();
            $('#nama_sec_select').append('<option value="">Pilih Sectoral</option>');
        }
    });

    $('#nama_peny').change(function() {
        var penyulang = $(this).val();
        var garduInduk = $('#id_gi').val();
        if (penyulang && garduInduk && !$('#changer_input').is(':checked')) {
            var urlTemplateKey =
                '{{ route("get.nama_keypoint", ["gardu_induk" => "GI_PLACEHOLDER", "penyulang" => "PENY_PLACEHOLDER"]) }}';
            var urlKey = urlTemplateKey.replace('GI_PLACEHOLDER', encodeURIComponent(garduInduk))
                .replace('PENY_PLACEHOLDER', encodeURIComponent(penyulang));
            $.ajax({
                url: urlKey,
                type: "GET",
                dataType: "json",
                success: function(data) {
                    $('#nama_lbs_select').empty();
                    $('#nama_lbs_select').append(
                        '<option value="">Pilih Nama Keypoint</option>');
                    $.each(data, function(key, value) {
                        $('#nama_lbs_select').append('<option value="' + key +
                            '">' + value + '</option>');
                    });
                    if (oldLbs) {
                        $('#nama_lbs_select').val(oldLbs);
                        oldLbs = '';
                    }
                },
                error: function(xhr, status, error) {
                    console.log('AJAX error: ' + xhr.status + ' - ' + status + ' - ' +
                        error);
                    console.log(xhr.responseText);
                }
            });

            var urlTemplateSec =
                '{{ route("get.sektoral", ["gardu_induk" => "GI_PLACEHOLDER", "penyulang" => "PENY_PLACEHOLDER"]) }}';
            var urlSec = urlTemplateSec.replace('GI_PLACEHOLDER', encodeURIComponent(garduInduk))
                .replace('PENY_PLACEHOLDER', encodeURIComponent(penyulang));
            $.ajax({
                url: urlSec,
                type: "GET",
                dataType: "json",
                success: function(data) {
                    $('#nama_sec_select').empty();
                    $('#nama_sec_select').append(
                        '<option value="">Pilih Sectoral</option>');
                    $.each(data, function(key, value) {
                        $('#nama_sec_select').append('<option value="' + key +
                            '">' + value + '</option>');
                    });
                    if (oldSec) {
                        $('#nama_sec_select').val(oldSec);
                        oldSec = '';
                    }
                },
                error: function(xhr, status, error) {
                    console.log('AJAX error: ' + xhr.status + ' - ' + status + ' - ' +
                        error);
                    console.log(xhr.responseText);
                }
            });
        } else {
            $('#nama_lbs_select').empty();
            $('#nama_lbs_select').append('<option value="">Pilih Nama Keypoint</option>');
            $('#nama_sec_select').empty();
            $('#nama_sec_select').append('<option value="">Pilih Sectoral</option>');
        }
    });
});
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-notify/0.2.0/js/bootstrap-notify.min.js"></script>
@endsection
