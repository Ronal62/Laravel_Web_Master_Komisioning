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
                                                    <label for="nama_lbs">Nama Keypoint</label>
                                                    <select class="form-select form-control" id="nama_lbs"
                                                        name="nama_lbs" required>
                                                        <option value="">Pilih Nama Keypoint</option>
                                                    </select>
                                                    @error('nama_lbs')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label for="nama_sec">Sectoral</label>
                                                    <select class="form-select form-control" id="nama_sec"
                                                        name="nama_sec" required>
                                                        <option value="">Pilih Sectoral</option>
                                                    </select>
                                                    @error('nama_sec')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
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



                                            </div>
                                        </div>
                                    </div>
                                    <!-- Form Telestatus Tab -->
                                    <div class="tab-pane fade" id="v-pills-formtelestatus-nobd" role="tabpanel"
                                        aria-labelledby="v-pills-formtelestatus-tab-nobd">
                                        <div class="row g-3 g-lg-4">
                                            <div class="col-12 col-lg-6">
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
                                                    <label class="form-label t-bold">AC Normal</label>
                                                    <div class="selectgroup w-100 flex-wrap">
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" id="acf_normal_checkAll"
                                                                class="selectgroup-input" />
                                                            <span class="selectgroup-button">Normal</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_acf[]" value="acnrml_1"
                                                                id="acf_normal_1" class="selectgroup-input"
                                                                {{ in_array('acnrml_1', old('s_acf', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">OK</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_acf[]" value="acnrml_2"
                                                                id="acf_normal_2" class="selectgroup-input"
                                                                {{ in_array('acnrml_2', old('s_acf', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">NOK</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_acf[]" value="acnrml_3"
                                                                id="acf_normal_3" class="selectgroup-input"
                                                                {{ in_array('acnrml_3', old('s_acf', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">LOG</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_acf[]" value="acnrml_4"
                                                                id="acf_normal_4" class="selectgroup-input"
                                                                {{ in_array('acnrml_4', old('s_acf', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">SLD</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_acf[]" value="acnrml_5"
                                                                id="acf_normal_5" class="selectgroup-input"
                                                                {{ in_array('acnrml_5', old('s_acf', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">Tidak Uji</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label t-bold">AC Fail</label>
                                                    <div class="selectgroup w-100 flex-wrap">
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" id="acf_fail_checkAll"
                                                                class="selectgroup-input" />
                                                            <span class="selectgroup-button">Normal</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_acf[]" value="acfail_1"
                                                                id="acf_fail_1" class="selectgroup-input"
                                                                {{ in_array('acfail_1', old('s_acf', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">OK</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_acf[]" value="acfail_2"
                                                                id="acf_fail_2" class="selectgroup-input"
                                                                {{ in_array('acfail_2', old('s_acf', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">NOK</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_acf[]" value="acfail_3"
                                                                id="acf_fail_3" class="selectgroup-input"
                                                                {{ in_array('acfail_3', old('s_acf', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">LOG</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_acf[]" value="acfail_4"
                                                                id="acf_fail_4" class="selectgroup-input"
                                                                {{ in_array('acfail_4', old('s_acf', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">SLD</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_acf[]" value="acfail_5"
                                                                id="acf_fail_5" class="selectgroup-input"
                                                                {{ in_array('acfail_5', old('s_acf', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">Tidak Uji</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label t-bold">DC Normal</label>
                                                    <div class="selectgroup w-100 flex-wrap">
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" id="dcf_normal_checkAll"
                                                                class="selectgroup-input" />
                                                            <span class="selectgroup-button">Normal</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_dcf[]" value="dcnrml_1"
                                                                id="dcf_normal_1" class="selectgroup-input"
                                                                {{ in_array('dcnrml_1', old('s_dcf', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">OK</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_dcf[]" value="dcnrml_2"
                                                                id="dcf_normal_2" class="selectgroup-input"
                                                                {{ in_array('dcnrml_2', old('s_dcf', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">NOK</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_dcf[]" value="dcnrml_3"
                                                                id="dcf_normal_3" class="selectgroup-input"
                                                                {{ in_array('dcnrml_3', old('s_dcf', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">LOG</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_dcf[]" value="dcnrml_4"
                                                                id="dcf_normal_4" class="selectgroup-input"
                                                                {{ in_array('dcnrml_4', old('s_dcf', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">SLD</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_dcf[]" value="dcnrml_5"
                                                                id="dcf_normal_5" class="selectgroup-input"
                                                                {{ in_array('dcnrml_5', old('s_dcf', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">Tidak Uji</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label t-bold">DC Fail</label>
                                                    <div class="selectgroup w-100 flex-wrap">
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" id="dcf_fail_checkAll"
                                                                class="selectgroup-input" />
                                                            <span class="selectgroup-button">Normal</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_dcf[]" value="dcfail_1"
                                                                id="dcf_fail_1" class="selectgroup-input"
                                                                {{ in_array('dcfail_1', old('s_dcf', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">OK</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_dcf[]" value="dcfail_2"
                                                                id="dcf_fail_2" class="selectgroup-input"
                                                                {{ in_array('dcfail_2', old('s_dcf', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">NOK</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_dcf[]" value="dcfail_3"
                                                                id="dcf_fail_3" class="selectgroup-input"
                                                                {{ in_array('dcfail_3', old('s_dcf', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">LOG</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_dcf[]" value="dcfail_4"
                                                                id="dcf_fail_4" class="selectgroup-input"
                                                                {{ in_array('dcfail_4', old('s_dcf', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">SLD</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_dcf[]" value="dcfail_5"
                                                                id="dcf_fail_5" class="selectgroup-input"
                                                                {{ in_array('dcfail_5', old('s_dcf', [])) ? 'checked' : '' }} />
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
                                                            <input type="checkbox" name="s_dcd[]" value="dcfnrml_1"
                                                                id="dcd_normal_1" class="selectgroup-input"
                                                                {{ in_array('dcfnrml_1', old('s_dcd', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">OK</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_dcd[]" value="dcfnrml_2"
                                                                id="dcd_normal_2" class="selectgroup-input"
                                                                {{ in_array('dcfnrml_2', old('s_dcd', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">NOK</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_dcd[]" value="dcfnrml_3"
                                                                id="dcd_normal_3" class="selectgroup-input"
                                                                {{ in_array('dcfnrml_3', old('s_dcd', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">LOG</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_dcd[]" value="dcfnrml_4"
                                                                id="dcd_normal_4" class="selectgroup-input"
                                                                {{ in_array('dcfnrml_4', old('s_dcd', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">SLD</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_dcd[]" value="dcfnrml_5"
                                                                id="dcd_normal_5" class="selectgroup-input"
                                                                {{ in_array('dcfnrml_5', old('s_dcd', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">Tidak Uji</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label t-bold">DCD Fail</label>
                                                    <div class="selectgroup w-100 flex-wrap">
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" id="dcd_fail_checkAll"
                                                                class="selectgroup-input" />
                                                            <span class="selectgroup-button">Normal</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_dcd[]" value="dcffail_1"
                                                                id="dcd_fail_1" class="selectgroup-input"
                                                                {{ in_array('dcffail_1', old('s_dcd', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">OK</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_dcd[]" value="dcffail_2"
                                                                id="dcd_fail_2" class="selectgroup-input"
                                                                {{ in_array('dcffail_2', old('s_dcd', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">NOK</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_dcd[]" value="dcffail_3"
                                                                id="dcd_fail_3" class="selectgroup-input"
                                                                {{ in_array('dcffail_3', old('s_dcd', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">LOG</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_dcd[]" value="dcffail_4"
                                                                id="dcd_fail_4" class="selectgroup-input"
                                                                {{ in_array('dcffail_4', old('s_dcd', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">SLD</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_dcd[]" value="dcffail_5"
                                                                id="dcd_fail_5" class="selectgroup-input"
                                                                {{ in_array('dcffail_5', old('s_dcd', [])) ? 'checked' : '' }} />
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
                                                                id="hlt_on_1" class="selectgroup-input"
                                                                {{ in_array('hlton_1', old('s_hlt', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">OK</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_hlt[]" value="hlton_2"
                                                                id="hlt_on_2" class="selectgroup-input"
                                                                {{ in_array('hlton_2', old('s_hlt', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">NOK</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_hlt[]" value="hlton_3"
                                                                id="hlt_on_3" class="selectgroup-input"
                                                                {{ in_array('hlton_3', old('s_hlt', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">LOG</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_hlt[]" value="hlton_4"
                                                                id="hlt_on_4" class="selectgroup-input"
                                                                {{ in_array('hlton_4', old('s_hlt', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">SLD</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_hlt[]" value="hlton_5"
                                                                id="hlt_on_5" class="selectgroup-input"
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
                                                                id="hlt_off_1" class="selectgroup-input"
                                                                {{ in_array('hltoff_1', old('s_hlt', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">OK</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_hlt[]" value="hltoff_2"
                                                                id="hlt_off_2" class="selectgroup-input"
                                                                {{ in_array('hltoff_2', old('s_hlt', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">NOK</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_hlt[]" value="hltoff_3"
                                                                id="hlt_off_3" class="selectgroup-input"
                                                                {{ in_array('hltoff_3', old('s_hlt', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">LOG</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_hlt[]" value="hltoff_4"
                                                                id="hlt_off_4" class="selectgroup-input"
                                                                {{ in_array('hltoff_4', old('s_hlt', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">SLD</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_hlt[]" value="hltoff_5"
                                                                id="hlt_off_5" class="selectgroup-input"
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
                                                                id="sf6_normal_1" class="selectgroup-input"
                                                                {{ in_array('sf6nrml_1', old('s_sf6', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">OK</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_sf6[]" value="sf6nrml_2"
                                                                id="sf6_normal_2" class="selectgroup-input"
                                                                {{ in_array('sf6nrml_2', old('s_sf6', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">NOK</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_sf6[]" value="sf6nrml_3"
                                                                id="sf6_normal_3" class="selectgroup-input"
                                                                {{ in_array('sf6nrml_3', old('s_sf6', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">LOG</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_sf6[]" value="sf6nrml_4"
                                                                id="sf6_normal_4" class="selectgroup-input"
                                                                {{ in_array('sf6nrml_4', old('s_sf6', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">SLD</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_sf6[]" value="sf6nrml_5"
                                                                id="sf6_normal_5" class="selectgroup-input"
                                                                {{ in_array('sf6nrml_5', old('s_sf6', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">Tidak Uji</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label t-bold">SF6 Fail</label>
                                                    <div class="selectgroup w-100 flex-wrap">
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" id="sf6_fail_checkAll"
                                                                class="selectgroup-input" />
                                                            <span class="selectgroup-button">Normal</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_sf6[]" value="sf6fail_1"
                                                                id="sf6_fail_1" class="selectgroup-input"
                                                                {{ in_array('sf6fail_1', old('s_sf6', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">OK</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_sf6[]" value="sf6fail_2"
                                                                id="sf6_fail_2" class="selectgroup-input"
                                                                {{ in_array('sf6fail_2', old('s_sf6', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">NOK</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_sf6[]" value="sf6fail_3"
                                                                id="sf6_fail_3" class="selectgroup-input"
                                                                {{ in_array('sf6fail_3', old('s_sf6', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">LOG</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_sf6[]" value="sf6fail_4"
                                                                id="sf6_fail_4" class="selectgroup-input"
                                                                {{ in_array('sf6fail_4', old('s_sf6', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">SLD</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_sf6[]" value="sf6fail_5"
                                                                id="sf6_fail_5" class="selectgroup-input"
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
                                                                id="fir_normal_1" class="selectgroup-input"
                                                                {{ in_array('firnrml_1', old('s_fir', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">OK</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_fir[]" value="firnrml_2"
                                                                id="fir_normal_2" class="selectgroup-input"
                                                                {{ in_array('firnrml_2', old('s_fir', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">NOK</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_fir[]" value="firnrml_3"
                                                                id="fir_normal_3" class="selectgroup-input"
                                                                {{ in_array('firnrml_3', old('s_fir', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">LOG</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_fir[]" value="firnrml_4"
                                                                id="fir_normal_4" class="selectgroup-input"
                                                                {{ in_array('firnrml_4', old('s_fir', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">SLD</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_fir[]" value="firnrml_5"
                                                                id="fir_normal_5" class="selectgroup-input"
                                                                {{ in_array('firnrml_5', old('s_fir', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">Tidak Uji</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label t-bold">FIR Fail</label>
                                                    <div class="selectgroup w-100 flex-wrap">
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" id="fir_fail_checkAll"
                                                                class="selectgroup-input" />
                                                            <span class="selectgroup-button">Normal</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_fir[]" value="firfail_1"
                                                                id="fir_fail_1" class="selectgroup-input"
                                                                {{ in_array('firfail_1', old('s_fir', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">OK</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_fir[]" value="firfail_2"
                                                                id="fir_fail_2" class="selectgroup-input"
                                                                {{ in_array('firfail_2', old('s_fir', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">NOK</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_fir[]" value="firfail_3"
                                                                id="fir_fail_3" class="selectgroup-input"
                                                                {{ in_array('firfail_3', old('s_fir', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">LOG</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_fir[]" value="firfail_4"
                                                                id="fir_fail_4" class="selectgroup-input"
                                                                {{ in_array('firfail_4', old('s_fir', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">SLD</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_fir[]" value="firfail_5"
                                                                id="fir_fail_5" class="selectgroup-input"
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
                                                                id="fis_normal_1" class="selectgroup-input"
                                                                {{ in_array('fisnrml_1', old('s_fis', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">OK</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_fis[]" value="fisnrml_2"
                                                                id="fis_normal_2" class="selectgroup-input"
                                                                {{ in_array('fisnrml_2', old('s_fis', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">NOK</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_fis[]" value="fisnrml_3"
                                                                id="fis_normal_3" class="selectgroup-input"
                                                                {{ in_array('fisnrml_3', old('s_fis', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">LOG</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_fis[]" value="fisnrml_4"
                                                                id="fis_normal_4" class="selectgroup-input"
                                                                {{ in_array('fisnrml_4', old('s_fis', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">SLD</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_fis[]" value="fisnrml_5"
                                                                id="fis_normal_5" class="selectgroup-input"
                                                                {{ in_array('fisnrml_5', old('s_fis', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">Tidak Uji</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label t-bold">FIS Fail</label>
                                                    <div class="selectgroup w-100 flex-wrap">
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" id="fis_fail_checkAll"
                                                                class="selectgroup-input" />
                                                            <span class="selectgroup-button">Normal</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_fis[]" value="fisfail_1"
                                                                id="fis_fail_1" class="selectgroup-input"
                                                                {{ in_array('fisfail_1', old('s_fis', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">OK</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_fis[]" value="fisfail_2"
                                                                id="fis_fail_2" class="selectgroup-input"
                                                                {{ in_array('fisfail_2', old('s_fis', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">NOK</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_fis[]" value="fisfail_3"
                                                                id="fis_fail_3" class="selectgroup-input"
                                                                {{ in_array('fisfail_3', old('s_fis', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">LOG</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_fis[]" value="fisfail_4"
                                                                id="fis_fail_4" class="selectgroup-input"
                                                                {{ in_array('fisfail_4', old('s_fis', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">SLD</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_fis[]" value="fisfail_5"
                                                                id="fis_fail_5" class="selectgroup-input"
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
                                                                id="fit_normal_1" class="selectgroup-input"
                                                                {{ in_array('fitnrml_1', old('s_fit', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">OK</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_fit[]" value="fitnrml_2"
                                                                id="fit_normal_2" class="selectgroup-input"
                                                                {{ in_array('fitnrml_2', old('s_fit', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">NOK</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_fit[]" value="fitnrml_3"
                                                                id="fit_normal_3" class="selectgroup-input"
                                                                {{ in_array('fitnrml_3', old('s_fit', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">LOG</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_fit[]" value="fitnrml_4"
                                                                id="fit_normal_4" class="selectgroup-input"
                                                                {{ in_array('fitnrml_4', old('s_fit', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">SLD</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_fit[]" value="fitnrml_5"
                                                                id="fit_normal_5" class="selectgroup-input"
                                                                {{ in_array('fitnrml_5', old('s_fit', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">Tidak Uji</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label t-bold">FIT Fail</label>
                                                    <div class="selectgroup w-100 flex-wrap">
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" id="fit_fail_checkAll"
                                                                class="selectgroup-input" />
                                                            <span class="selectgroup-button">Normal</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_fit[]" value="fitfail_1"
                                                                id="fit_fail_1" class="selectgroup-input"
                                                                {{ in_array('fitfail_1', old('s_fit', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">OK</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_fit[]" value="fitfail_2"
                                                                id="fit_fail_2" class="selectgroup-input"
                                                                {{ in_array('fitfail_2', old('s_fit', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">NOK</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_fit[]" value="fitfail_3"
                                                                id="fit_fail_3" class="selectgroup-input"
                                                                {{ in_array('fitfail_3', old('s_fit', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">LOG</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_fit[]" value="fitfail_4"
                                                                id="fit_fail_4" class="selectgroup-input"
                                                                {{ in_array('fitfail_4', old('s_fit', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">SLD</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_fit[]" value="fitfail_5"
                                                                id="fit_fail_5" class="selectgroup-input"
                                                                {{ in_array('fitfail_5', old('s_fit', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">Tidak Uji</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label t-bold">FIN Normal</label>
                                                    <div class="selectgroup w-100 flex-wrap">
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" id="fin_normal_checkAll"
                                                                class="selectgroup-input" />
                                                            <span class="selectgroup-button">Normal</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_fin[]" value="finnrml_1"
                                                                id="fin_normal_1" class="selectgroup-input"
                                                                {{ in_array('finnrml_1', old('s_fin', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">OK</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_fin[]" value="finnrml_2"
                                                                id="fin_normal_2" class="selectgroup-input"
                                                                {{ in_array('finnrml_2', old('s_fin', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">NOK</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_fin[]" value="finnrml_3"
                                                                id="fin_normal_3" class="selectgroup-input"
                                                                {{ in_array('finnrml_3', old('s_fin', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">LOG</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_fin[]" value="finnrml_4"
                                                                id="fin_normal_4" class="selectgroup-input"
                                                                {{ in_array('finnrml_4', old('s_fin', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">SLD</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_fin[]" value="finnrml_5"
                                                                id="fin_normal_5" class="selectgroup-input"
                                                                {{ in_array('finnrml_5', old('s_fin', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">Tidak Uji</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label t-bold">FIN Fail</label>
                                                    <div class="selectgroup w-100 flex-wrap">
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" id="fin_fail_checkAll"
                                                                class="selectgroup-input" />
                                                            <span class="selectgroup-button">Normal</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_fin[]" value="finfail_1"
                                                                id="fin_fail_1" class="selectgroup-input"
                                                                {{ in_array('finfail_1', old('s_fin', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">OK</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_fin[]" value="finfail_2"
                                                                id="fin_fail_2" class="selectgroup-input"
                                                                {{ in_array('finfail_2', old('s_fin', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">NOK</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_fin[]" value="finfail_3"
                                                                id="fin_fail_3" class="selectgroup-input"
                                                                {{ in_array('finfail_3', old('s_fin', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">LOG</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_fin[]" value="finfail_4"
                                                                id="fin_fail_4" class="selectgroup-input"
                                                                {{ in_array('finfail_4', old('s_fin', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">SLD</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_fin[]" value="finfail_5"
                                                                id="fin_fail_5" class="selectgroup-input"
                                                                {{ in_array('finfail_5', old('s_fin', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">Tidak Uji</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label t-bold">COMF</label>
                                                    <div class="selectgroup w-100 flex-wrap">
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" id="comf_checkAll"
                                                                class="selectgroup-input" />
                                                            <span class="selectgroup-button">Normal</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_comf[]" value="comf_nrml_1"
                                                                id="comf_1" class="selectgroup-input"
                                                                {{ in_array('comf_nrml_1', old('s_comf', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">OK</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_comf[]" value="comf_nrml_2"
                                                                id="comf_2" class="selectgroup-input"
                                                                {{ in_array('comf_nrml_2', old('s_comf', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">NOK</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_comf[]" value="comf_nrml_3"
                                                                id="comf_3" class="selectgroup-input"
                                                                {{ in_array('comf_nrml_3', old('s_comf', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">LOG</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_comf[]" value="comf_nrml_4"
                                                                id="comf_4" class="selectgroup-input"
                                                                {{ in_array('comf_nrml_4', old('s_comf', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">SLD</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_comf[]" value="comf_nrml_5"
                                                                id="comf_5" class="selectgroup-input"
                                                                {{ in_array('comf_nrml_5', old('s_comf', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">Tidak Uji</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label t-bold">LRUF</label>
                                                    <div class="selectgroup w-100 flex-wrap">
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" id="lruf_checkAll"
                                                                class="selectgroup-input" />
                                                            <span class="selectgroup-button">Normal</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_lruf[]" value="lruf_nrml_1"
                                                                id="lruf_1" class="selectgroup-input"
                                                                {{ in_array('lruf_nrml_1', old('s_lruf', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">OK</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_lruf[]" value="lruf_nrml_2"
                                                                id="lruf_2" class="selectgroup-input"
                                                                {{ in_array('lruf_nrml_2', old('s_lruf', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">NOK</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_lruf[]" value="lruf_nrml_3"
                                                                id="lruf_3" class="selectgroup-input"
                                                                {{ in_array('lruf_nrml_3', old('s_lruf', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">LOG</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_lruf[]" value="lruf_nrml_4"
                                                                id="lruf_4" class="selectgroup-input"
                                                                {{ in_array('lruf_nrml_4', old('s_lruf', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">SLD</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_lruf[]" value="lruf_nrml_5"
                                                                id="lruf_5" class="selectgroup-input"
                                                                {{ in_array('lruf_nrml_5', old('s_lruf', [])) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">Tidak Uji</span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-2 ">
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
                                                    <label for="sdcf_normal_addms">DC Normal AddMs</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="sdcf_normal_addms"
                                                            name="sdcf_normal_addms" placeholder="DC Normal AddMs"
                                                            value="{{ old('sdcf_normal_addms') }}" />
                                                        @error('sdcf_normal_addms')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="sdcf_fail_addms">DC Fail AddMs</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="sdcf_fail_addms"
                                                            name="sdcf_fail_addms" placeholder="DC Fail AddMs"
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
                                                <div class="form-group">
                                                    <label for="sfin_normal_addms">FIN Normal AddMs</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="sfin_normal_addms"
                                                            name="sfin_normal_addms" placeholder="FIN Normal AddMs"
                                                            value="{{ old('sfin_normal_addms') }}" />
                                                        @error('sfin_normal_addms')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="sfin_fail_addms">FIN Fail AddMs</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="sfin_fail_addms"
                                                            name="sfin_fail_addms" placeholder="FIN Fail AddMs"
                                                            value="{{ old('sfin_fail_addms') }}" />
                                                        @error('sfin_fail_addms')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="scomf_addms">COMF AddMs</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="scomf_addms"
                                                            name="scomf_addms" placeholder="COMF AddMs"
                                                            value="{{ old('scomf_addms') }}" />
                                                        @error('scomf_addms')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="slruf_addms">LRUF AddMs</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="slruf_addms"
                                                            name="slruf_addms" placeholder="LRUF AddMs"
                                                            value="{{ old('slruf_addms') }}" />
                                                        @error('slruf_addms')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-2">
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
                                                    <label for="sdcf_normal_objfrmt">DC Normal OBJ/FRMT</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="sdcf_normal_objfrmt"
                                                            name="sdcf_normal_objfrmt" placeholder="DC Normal OBJ/FRMT"
                                                            value="{{ old('sdcf_normal_objfrmt') }}" />
                                                        @error('sdcf_normal_objfrmt')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="sdcf_fail_objfrmt">DC Fail OBJ/FRMT</label>
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
                                                <div class="form-group">
                                                    <label for="sfin_normal_objfrmt">FIN Normal OBJ/FRMT</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="sfin_normal_objfrmt"
                                                            name="sfin_normal_objfrmt" placeholder="FIN Normal OBJ/FRMT"
                                                            value="{{ old('sfin_normal_objfrmt') }}" />
                                                        @error('sfin_normal_objfrmt')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="sfin_fail_objfrmt">FIN Fail OBJ/FRMT</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="sfin_fail_objfrmt"
                                                            name="sfin_fail_objfrmt" placeholder="FIN Fail OBJ/FRMT"
                                                            value="{{ old('sfin_fail_objfrmt') }}" />
                                                        @error('sfin_fail_objfrmt')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="scomf_objfrmt">COMF OBJ/FRMT</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="scomf_objfrmt"
                                                            name="scomf_objfrmt" placeholder="COMF OBJ/FRMT"
                                                            value="{{ old('scomf_objfrmt') }}" />
                                                        @error('scomf_objfrmt')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="slruf_objfrmt">LRUF OBJ/FRMT</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="slruf_objfrmt"
                                                            name="slruf_objfrmt" placeholder="LRUF OBJ/FRMT"
                                                            value="{{ old('slruf_objfrmt') }}" />
                                                        @error('slruf_objfrmt')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-2 ">
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
                                                    <label for="sdcf_normal_addrtu">DC Normal AddRtu</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="sdcf_normal_addrtu"
                                                            name="sdcf_normal_addrtu" placeholder="DC Normal AddRtu"
                                                            value="{{ old('sdcf_normal_addrtu') }}" />
                                                        @error('sdcf_normal_addrtu')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="sdcf_fail_addrtu">DC Fail AddRtu</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="sdcf_fail_addrtu"
                                                            name="sdcf_fail_addrtu" placeholder="DC Fail AddRtu"
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
                                                <div class="form-group">
                                                    <label for="sfin_normal_addrtu">FIN Normal AddRtu</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="sfin_normal_addrtu"
                                                            name="sfin_normal_addrtu" placeholder="FIN Normal AddRtu"
                                                            value="{{ old('sfin_normal_addrtu') }}" />
                                                        @error('sfin_normal_addrtu')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="sfin_fail_addrtu">FIN Fail AddRtu</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="sfin_fail_addrtu"
                                                            name="sfin_fail_addrtu" placeholder="FIN Fail AddRtu"
                                                            value="{{ old('sfin_fail_addrtu') }}" />
                                                        @error('sfin_fail_addrtu')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="scomf_addrtu">COMF AddRtu</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="scomf_addrtu"
                                                            name="scomf_addrtu" placeholder="COMF AddRtu"
                                                            value="{{ old('scomf_addrtu') }}" />
                                                        @error('scomf_addrtu')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="slruf_addrtu">LRUF AddRtu</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="slruf_addrtu"
                                                            name="slruf_addrtu" placeholder="LRUF AddRtu"
                                                            value="{{ old('slruf_addrtu') }}" />
                                                        @error('slruf_addrtu')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
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
                                                    <label for="scb_open_addms">CB Open AddMs</label>
                                                    <div class="input-icon">
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
                                                    <label for="srst_addms">Reset AddMs</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="srst_addms"
                                                            name="srst_addms" placeholder="Reset AddMs"
                                                            value="{{ old('srst_addms') }}" />
                                                        @error('srst_addms')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-2">
                                                <div class="form-group">
                                                    <label for="scb_open_addrtu">CB Open AddRtu</label>
                                                    <div class="input-icon">
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
                                                    <label for="srst_addrtu">Reset AddRtu</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="srst_addrtu"
                                                            name="srst_addrtu" placeholder="Reset AddRtu"
                                                            value="{{ old('srst_addrtu') }}" />
                                                        @error('srst_addrtu')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-2">
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
                                                    <label for="srst_objfrmt">Reset OBJ/FRMT</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="srst_objfrmt"
                                                            name="srst_objfrmt" placeholder="Reset OBJ/FRMT"
                                                            value="{{ old('srst_objfrmt') }}" />
                                                        @error('srst_objfrmt')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
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
                                                <label for="id_pelrtu" class="custom-label">Pelaksana RTU
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
                    $('#nama_lbs').empty();
                    $('#nama_lbs').append('<option value="">Pilih Nama Keypoint</option>');
                    $('#nama_sec').empty();
                    $('#nama_sec').append('<option value="">Pilih Sectoral</option>');
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
            $('#nama_lbs').empty();
            $('#nama_lbs').append('<option value="">Pilih Nama Keypoint</option>');
            $('#nama_sec').empty();
            $('#nama_sec').append('<option value="">Pilih Sectoral</option>');
        }
    });

    $('#nama_peny').change(function() {
        var penyulang = $(this).val();
        var garduInduk = $('#id_gi').val();
        if (penyulang && garduInduk) {
            var urlTemplateKey =
                '{{ route("get.nama_keypoint", ["gardu_induk" => "GI_PLACEHOLDER", "penyulang" => "PENY_PLACEHOLDER"]) }}';
            var urlKey = urlTemplateKey.replace('GI_PLACEHOLDER', encodeURIComponent(garduInduk))
                .replace('PENY_PLACEHOLDER', encodeURIComponent(penyulang));
            $.ajax({
                url: urlKey,
                type: "GET",
                dataType: "json",
                success: function(data) {
                    $('#nama_lbs').empty();
                    $('#nama_lbs').append('<option value="">Pilih Nama Keypoint</option>');
                    $.each(data, function(key, value) {
                        $('#nama_lbs').append('<option value="' + key + '">' +
                            value + '</option>');
                    });
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
                    $('#nama_sec').empty();
                    $('#nama_sec').append('<option value="">Pilih Sectoral</option>');
                    $.each(data, function(key, value) {
                        $('#nama_sec').append('<option value="' + key + '">' +
                            value + '</option>');
                    });
                },
                error: function(xhr, status, error) {
                    console.log('AJAX error: ' + xhr.status + ' - ' + status + ' - ' +
                        error);
                    console.log(xhr.responseText);
                }
            });
        } else {
            $('#nama_lbs').empty();
            $('#nama_lbs').append('<option value="">Pilih Nama Keypoint</option>');
            $('#nama_sec').empty();
            $('#nama_sec').append('<option value="">Pilih Sectoral</option>');
        }
    });
});
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-notify/0.2.0/js/bootstrap-notify.min.js"></script>
@endsection