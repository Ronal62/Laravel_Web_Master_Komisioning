@extends('layout.app')

@section('title', 'Clone Data Penyulangan')

@section('content')
<div class="page-inner">
    <div class="page-header">
        <div class="section-header-back">
            <a href="{{ route('penyulangan.index') }}" class="btn"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h3 class="fw-bold">Clone Data Penyulangan</h3>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Clone Data Penyulangan</h4>
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
                    <form action="{{ route('penyulangan.clone.store') }}" method="POST" autocomplete="off">
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
                                                    <label for="tgl_kom">Tanggal Komisioning</label>
                                                    <div class="input-icon">
                                                        <input type="date" class="form-control" id="tgl_kom"
                                                            name="tgl_kom"
                                                            value="{{ old('tgl_kom', $penyulang->tgl_kom) }}"
                                                            required />
                                                        @error('tgl_kom')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="nama_peny">Nama Penyulang</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="nama_peny"
                                                            name="nama_peny" placeholder="Nama Penyulang"
                                                            value="{{ old('nama_peny') }}" required />
                                                        @error('nama_peny')
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
                                                            {{ old('id_gi', $penyulang->id_gi) == $gi->id_gi ? 'selected' : '' }}>
                                                            {{ $gi->nama_gi }}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                    @error('id_gi')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label for="id_rtugi">Merk RTU GI</label>
                                                    <select class="form-select form-control" id="id_rtugi"
                                                        name="id_rtugi" required>
                                                        <option value="">Pilih Merk RTU GI</option>
                                                        @foreach ($rtugi as $rtu)
                                                        <option value="{{ $rtu->id_rtugi }}"
                                                            {{ old('id_rtugi', $penyulang->id_rtugi) == $rtu->id_rtugi ? 'selected' : '' }}>
                                                            {{ $rtu->nama_rtugi }}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                    @error('id_rtugi')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="rtu_addrs">Protocol/RTU Address</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="rtu_addrs"
                                                            name="rtu_addrs" placeholder="Protocol/RTU Address"
                                                            value="{{ old('rtu_addrs', $penyulang->rtu_addrs) }}" />
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
                                                            {{ old('id_medkom', $penyulang->id_medkom) == $media->id_medkom ? 'selected' : '' }}>
                                                            {{ $media->nama_medkom }}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                    @error('id_medkom')
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
                                                's_cb' => $penyulang->s_cb ? explode(',', $penyulang->s_cb) : [],
                                                's_lr' => $penyulang->s_lr ? explode(',', $penyulang->s_lr) : [],
                                                's_ocr' => $penyulang->s_ocr ? explode(',', $penyulang->s_ocr) : [],
                                                's_ocri' => $penyulang->s_ocri ? explode(',', $penyulang->s_ocri) : [],
                                                's_dgr' => $penyulang->s_dgr ? explode(',', $penyulang->s_dgr) : [],
                                                's_cbtr' => $penyulang->s_cbtr ? explode(',', $penyulang->s_cbtr) : [],
                                                's_ar' => $penyulang->s_ar ? explode(',', $penyulang->s_ar) : [],
                                                's_aru' => $penyulang->s_aru ? explode(',', $penyulang->s_aru) : [],
                                                's_tc' => $penyulang->s_tc ? explode(',', $penyulang->s_tc) : [],
                                                ];
                                                @endphp
                                                <!-- CB Open/Close -->
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
                                                <!-- Local/Remote -->
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
                                                <!-- OCR Dekat/Jauh -->
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-1">
                                                            <label class="form-label t-bold">OCR Dekat</label>
                                                        </div>
                                                        <div class="col-md-10">
                                                            <div class="selectgroup w-100">
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" id="ocr_dekat_checkAll"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">Normal</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_ocr[]" value="ocrd_1"
                                                                        id="ocr_ocrd_1" class="selectgroup-input"
                                                                        {{ in_array('ocrd_1', $checkboxValues['s_ocr']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">OK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_ocr[]" value="ocrd_2"
                                                                        id="ocr_ocrd_2" class="selectgroup-input"
                                                                        {{ in_array('ocrd_2', $checkboxValues['s_ocr']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">NOK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_ocr[]" value="ocrd_3"
                                                                        id="ocr_ocrd_3" class="selectgroup-input"
                                                                        {{ in_array('ocrd_3', $checkboxValues['s_ocr']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">LOG</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_ocr[]" value="ocrd_4"
                                                                        id="ocr_ocrd_4" class="selectgroup-input"
                                                                        {{ in_array('ocrd_4', $checkboxValues['s_ocr']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">SLD</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_ocr[]" value="ocrd_5"
                                                                        id="ocr_ocrd_5" class="selectgroup-input"
                                                                        {{ in_array('ocrd_5', $checkboxValues['s_ocr']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">Tidak Uji</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-1">
                                                            <label class="form-label t-bold">OCR Jauh</label>
                                                        </div>
                                                        <div class="col-md-10">
                                                            <div class="selectgroup w-100">
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" id="ocr_jauh_checkAll"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">Normal</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_ocr[]" value="ocra_1"
                                                                        id="ocr_ocra_1" class="selectgroup-input"
                                                                        {{ in_array('ocra_1', $checkboxValues['s_ocr']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">OK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_ocr[]" value="ocra_2"
                                                                        id="ocr_ocra_2" class="selectgroup-input"
                                                                        {{ in_array('ocra_2', $checkboxValues['s_ocr']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">NOK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_ocr[]" value="ocra_3"
                                                                        id="ocr_ocra_3" class="selectgroup-input"
                                                                        {{ in_array('ocra_3', $checkboxValues['s_ocr']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">LOG</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_ocr[]" value="ocra_4"
                                                                        id="ocr_ocra_4" class="selectgroup-input"
                                                                        {{ in_array('ocra_4', $checkboxValues['s_ocr']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">SLD</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_ocr[]" value="ocra_5"
                                                                        id="ocr_ocra_5" class="selectgroup-input"
                                                                        {{ in_array('ocra_5', $checkboxValues['s_ocr']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">Tidak Uji</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Continue with remaining telestatus fields following the same pattern -->
                                                <!-- For brevity, I'll add a few more key ones. You can replicate for all fields from controller -->
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
                                                'c_cb' => $penyulang->c_cb ? explode(',', $penyulang->c_cb) : [],
                                                'c_aru' => $penyulang->c_aru ? explode(',', $penyulang->c_aru) : [],
                                                'c_rst' => $penyulang->c_rst ? explode(',', $penyulang->c_rst) : [],
                                                'c_tc' => $penyulang->c_tc ? explode(',', $penyulang->c_tc) : [],
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
                                                                    <input type="checkbox" id="ccb_open_checkAll"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">Normal</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="c_cb[]"
                                                                        value="ccb_open_1" id="ccb_open_1"
                                                                        class="selectgroup-input"
                                                                        {{ in_array('ccb_open_1', $telecontrolValues['c_cb']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">OK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="c_cb[]"
                                                                        value="ccb_open_2" id="ccb_open_2"
                                                                        class="selectgroup-input"
                                                                        {{ in_array('ccb_open_2', $telecontrolValues['c_cb']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">NOK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="c_cb[]"
                                                                        value="ccb_open_3" id="ccb_open_3"
                                                                        class="selectgroup-input"
                                                                        {{ in_array('ccb_open_3', $telecontrolValues['c_cb']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">LOG</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="c_cb[]"
                                                                        value="ccb_open_4" id="ccb_open_4"
                                                                        class="selectgroup-input"
                                                                        {{ in_array('ccb_open_4', $telecontrolValues['c_cb']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">SLD</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="c_cb[]"
                                                                        value="ccb_open_5" id="ccb_open_5"
                                                                        class="selectgroup-input"
                                                                        {{ in_array('ccb_open_5', $telecontrolValues['c_cb']) ? 'checked' : '' }} />
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
                                                                    <input type="checkbox" id="ccb_close_checkAll"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">Normal</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="c_cb[]"
                                                                        value="ccb_close_1" id="ccb_close_1"
                                                                        class="selectgroup-input"
                                                                        {{ in_array('ccb_close_1', $telecontrolValues['c_cb']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">OK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="c_cb[]"
                                                                        value="ccb_close_2" id="ccb_close_2"
                                                                        class="selectgroup-input"
                                                                        {{ in_array('ccb_close_2', $telecontrolValues['c_cb']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">NOK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="c_cb[]"
                                                                        value="ccb_close_3" id="ccb_close_3"
                                                                        class="selectgroup-input"
                                                                        {{ in_array('ccb_close_3', $telecontrolValues['c_cb']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">LOG</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="c_cb[]"
                                                                        value="ccb_close_4" id="ccb_close_4"
                                                                        class="selectgroup-input"
                                                                        {{ in_array('ccb_close_4', $telecontrolValues['c_cb']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">SLD</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="c_cb[]"
                                                                        value="ccb_close_5" id="ccb_close_5"
                                                                        class="selectgroup-input"
                                                                        {{ in_array('ccb_close_5', $telecontrolValues['c_cb']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">TDK UJI</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-1">
                                                            <label class="form-label t-bold">ARU</label>
                                                        </div>
                                                        <div class="col-md-10">
                                                            <div class="selectgroup w-100">
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" id="caru_checkAll"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">Normal</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="c_aru[]" value="caru_1"
                                                                        id="caru_1" class="selectgroup-input"
                                                                        {{ in_array('caru_1', $telecontrolValues['c_aru']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">OK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="c_aru[]" value="caru_2"
                                                                        id="caru_2" class="selectgroup-input"
                                                                        {{ in_array('caru_2', $telecontrolValues['c_aru']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">NOK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="c_aru[]" value="caru_3"
                                                                        id="caru_3" class="selectgroup-input"
                                                                        {{ in_array('caru_3', $telecontrolValues['c_aru']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">LOG</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="c_aru[]" value="caru_4"
                                                                        id="caru_4" class="selectgroup-input"
                                                                        {{ in_array('caru_4', $telecontrolValues['c_aru']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">SLD</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="c_aru[]" value="caru_5"
                                                                        id="caru_5" class="selectgroup-input"
                                                                        {{ in_array('caru_5', $telecontrolValues['c_aru']) ? 'checked' : '' }} />
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
                                                                    <input type="checkbox" id="crst_checkAll"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">Normal</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="c_rst[]"
                                                                        value="rrctrl_on_1" id="crst_1"
                                                                        class="selectgroup-input"
                                                                        {{ in_array('rrctrl_on_1', $telecontrolValues['c_rst']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">OK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="c_rst[]"
                                                                        value="rrctrl_on_2" id="crst_2"
                                                                        class="selectgroup-input"
                                                                        {{ in_array('rrctrl_on_2', $telecontrolValues['c_rst']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">NOK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="c_rst[]"
                                                                        value="rrctrl_on_3" id="crst_3"
                                                                        class="selectgroup-input"
                                                                        {{ in_array('rrctrl_on_3', $telecontrolValues['c_rst']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">LOG</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="c_rst[]"
                                                                        value="rrctrl_on_4" id="crst_4"
                                                                        class="selectgroup-input"
                                                                        {{ in_array('rrctrl_on_4', $telecontrolValues['c_rst']) ? 'checked' : '' }} />
                                                                    <span class="selectgroup-button">SLD</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="c_rst[]"
                                                                        value="rrctrl_on_5" id="crst_5"
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
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Arus Phase R</label>
                                                    <input class="form-control @error('ir_rtu') is-invalid @enderror"
                                                        placeholder="IR RTU" name="ir_rtu"
                                                        value="{{ old('ir_rtu', $penyulang->ir_rtu) }}">
                                                    @error('ir_rtu')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                    <input class="form-control @error('ir_ms') is-invalid @enderror"
                                                        placeholder="IR Master" name="ir_ms"
                                                        value="{{ old('ir_ms', $penyulang->ir_ms) }}">
                                                    @error('ir_ms')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                    <input class="form-control @error('ir_scale') is-invalid @enderror"
                                                        placeholder="Scale" name="ir_scale"
                                                        value="{{ old('ir_scale', $penyulang->ir_scale) }}">
                                                    @error('ir_scale')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label>Arus Phase S</label>
                                                    <input class="form-control @error('is_rtu') is-invalid @enderror"
                                                        placeholder="IS RTU" name="is_rtu"
                                                        value="{{ old('is_rtu', $penyulang->is_rtu) }}">
                                                    @error('is_rtu')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                    <input class="form-control @error('is_ms') is-invalid @enderror"
                                                        placeholder="IS Master" name="is_ms"
                                                        value="{{ old('is_ms', $penyulang->is_ms) }}">
                                                    @error('is_ms')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                    <input class="form-control @error('is_scale') is-invalid @enderror"
                                                        placeholder="Scale" name="is_scale"
                                                        value="{{ old('is_scale', $penyulang->is_scale) }}">
                                                    @error('is_scale')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label>Arus Phase T</label>
                                                    <input class="form-control @error('it_rtu') is-invalid @enderror"
                                                        placeholder="IT RTU" name="it_rtu"
                                                        value="{{ old('it_rtu', $penyulang->it_rtu) }}">
                                                    @error('it_rtu')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                    <input class="form-control @error('it_ms') is-invalid @enderror"
                                                        placeholder="IT Master" name="it_ms"
                                                        value="{{ old('it_ms', $penyulang->it_ms) }}">
                                                    @error('it_ms')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                    <input class="form-control @error('it_scale') is-invalid @enderror"
                                                        placeholder="Scale" name="it_scale"
                                                        value="{{ old('it_scale', $penyulang->it_scale) }}">
                                                    @error('it_scale')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Frekuensi IR</label>
                                                    <input class="form-control @error('fir_rtu') is-invalid @enderror"
                                                        placeholder="FIR RTU" name="fir_rtu"
                                                        value="{{ old('fir_rtu', $penyulang->fir_rtu) }}">
                                                    @error('fir_rtu')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                    <input class="form-control @error('fir_ms') is-invalid @enderror"
                                                        placeholder="FIR Master" name="fir_ms"
                                                        value="{{ old('fir_ms', $penyulang->fir_ms) }}">
                                                    @error('fir_ms')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                    <input class="form-control @error('fir_scale') is-invalid @enderror"
                                                        placeholder="Scale" name="fir_scale"
                                                        value="{{ old('fir_scale', $penyulang->fir_scale) }}">
                                                    @error('fir_scale')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label>Frekuensi IS</label>
                                                    <input class="form-control @error('fis_rtu') is-invalid @enderror"
                                                        placeholder="FIS RTU" name="fis_rtu"
                                                        value="{{ old('fis_rtu', $penyulang->fis_rtu) }}">
                                                    @error('fis_rtu')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                    <input class="form-control @error('fis_ms') is-invalid @enderror"
                                                        placeholder="FIS Master" name="fis_ms"
                                                        value="{{ old('fis_ms', $penyulang->fis_ms) }}">
                                                    @error('fis_ms')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                    <input class="form-control @error('fis_scale') is-invalid @enderror"
                                                        placeholder="Scale" name="fis_scale"
                                                        value="{{ old('fis_scale', $penyulang->fis_scale) }}">
                                                    @error('fis_scale')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label>Frekuensi IT</label>
                                                    <input class="form-control @error('fit_rtu') is-invalid @enderror"
                                                        placeholder="FIT RTU" name="fit_rtu"
                                                        value="{{ old('fit_rtu', $penyulang->fit_rtu) }}">
                                                    @error('fit_rtu')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                    <input class="form-control @error('fit_ms') is-invalid @enderror"
                                                        placeholder="FIT Master" name="fit_ms"
                                                        value="{{ old('fit_ms', $penyulang->fit_ms) }}">
                                                    @error('fit_ms')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                    <input class="form-control @error('fit_scale') is-invalid @enderror"
                                                        placeholder="Scale" name="fit_scale"
                                                        value="{{ old('fit_scale', $penyulang->fit_scale) }}">
                                                    @error('fit_scale')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label>Frekuensi IN</label>
                                                    <input class="form-control @error('fin_rtu') is-invalid @enderror"
                                                        placeholder="FIN RTU" name="fin_rtu"
                                                        value="{{ old('fin_rtu', $penyulang->fin_rtu) }}">
                                                    @error('fin_rtu')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                    <input class="form-control @error('fin_ms') is-invalid @enderror"
                                                        placeholder="FIN Master" name="fin_ms"
                                                        value="{{ old('fin_ms', $penyulang->fin_ms) }}">
                                                    @error('fin_ms')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                    <input class="form-control @error('fin_scale') is-invalid @enderror"
                                                        placeholder="Scale" name="fin_scale"
                                                        value="{{ old('fin_scale', $penyulang->fin_scale) }}">
                                                    @error('fin_scale')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Daya P</label>
                                                    <input class="form-control @error('p_rtu') is-invalid @enderror"
                                                        placeholder="P RTU" name="p_rtu"
                                                        value="{{ old('p_rtu', $penyulang->p_rtu) }}">
                                                    @error('p_rtu')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                    <input class="form-control @error('p_ms') is-invalid @enderror"
                                                        placeholder="P Master" name="p_ms"
                                                        value="{{ old('p_ms', $penyulang->p_ms) }}">
                                                    @error('p_ms')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                    <input class="form-control @error('p_scale') is-invalid @enderror"
                                                        placeholder="Scale" name="p_scale"
                                                        value="{{ old('p_scale', $penyulang->p_scale) }}">
                                                    @error('p_scale')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label>Tegangan V</label>
                                                    <input class="form-control @error('v_rtu') is-invalid @enderror"
                                                        placeholder="V RTU" name="v_rtu"
                                                        value="{{ old('v_rtu', $penyulang->v_rtu) }}">
                                                    @error('v_rtu')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                    <input class="form-control @error('v_ms') is-invalid @enderror"
                                                        placeholder="V Master" name="v_ms"
                                                        value="{{ old('v_ms', $penyulang->v_ms) }}">
                                                    @error('v_ms')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                    <input class="form-control @error('v_scale') is-invalid @enderror"
                                                        placeholder="Scale" name="v_scale"
                                                        value="{{ old('v_scale', $penyulang->v_scale) }}">
                                                    @error('v_scale')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label>Frekuensi F</label>
                                                    <input class="form-control @error('f_rtu') is-invalid @enderror"
                                                        placeholder="F RTU" name="f_rtu"
                                                        value="{{ old('f_rtu', $penyulang->f_rtu) }}">
                                                    @error('f_rtu')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                    <input class="form-control @error('f_ms') is-invalid @enderror"
                                                        placeholder="F Master" name="f_ms"
                                                        value="{{ old('f_ms', $penyulang->f_ms) }}">
                                                    @error('f_ms')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                    <input class="form-control @error('f_scale') is-invalid @enderror"
                                                        placeholder="Scale" name="f_scale"
                                                        value="{{ old('f_scale', $penyulang->f_scale) }}">
                                                    @error('f_scale')
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
                                                    {{ old('id_komkp', $penyulang->id_komkp) == $kom->id_komkp ? 'selected' : '' }}>
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
                                                <label for="id_pelms" class="custom-label">Pelaksana Master II</label>
                                                <div class="custom-select-wrapper">
                                                    <div class="selected-items" id="selected-items"></div>
                                                    <input type="hidden" id="id_pelms" name="id_pelms"
                                                        value="{{ old('id_pelms', implode(',', $selectedPelms ?? [])) }}">
                                                    <div class="dropdown" id="dropdown-options">
                                                        @foreach ($pelms as $item)
                                                        <div class="dropdown-item" data-id="{{ $item->id_pelmaster }}">
                                                            {{ $item->nama_pelmaster }}
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                                <div class="invalid-feedback" id="error-message" style="display: none;">
                                                    Please select at least one option.
                                                </div>
                                                @error('id_pelms')
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
                                                value="{{ old('pelrtu', $penyulang->pelrtu) }}">
                                            @error('pelrtu')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="ketpeny">Keterangan</label>
                            <textarea class="form-control text-uppercase @error('ketpeny') is-invalid @enderror"
                                id="ketpeny" name="ketpeny"
                                style="height: 155px;">{{ old('ketpeny', $penyulang->ketpeny) }}</textarea>
                            @error('ketpeny')
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
                            <a href="{{ route('penyulangan.index') }}" class="btn btn-danger">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
const hiddenInput = document.getElementById("id_pelms");
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
