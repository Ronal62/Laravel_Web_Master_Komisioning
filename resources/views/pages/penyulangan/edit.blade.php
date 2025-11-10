@extends('layout.app')
@section('title', 'Edit Data Penyulangan')
@section('content')
<div class="page-inner">
    <div class="page-header">
        <div class="section-header-back">
            <a href="{{ route('penyulangan.index') }}" class="btn"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h3 class="fw-bold">Edit Data Penyulangan</h3>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Edit Data Penyulangan</h4>
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
                    <form action="{{ route('penyulangan.update', $penyulang->id_peny) }}" method="POST"
                        autocomplete="off">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="id_peny" value="{{ $penyulang->id_peny }}">
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
                                                    <label for="nama_peny">Nama Penyulangan</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="nama_peny"
                                                            name="nama_peny" placeholder="Nama Penyulangan"
                                                            value="{{ old('nama_peny', $penyulang->nama_peny) }}"
                                                            required />
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
                                                <div class="form-group">
                                                    <label for="id_rtugi">Merk RTU</label>
                                                    <select class="form-select form-control" id="id_rtugi"
                                                        name="id_rtugi" required>
                                                        <option value="">Pilih Merk RTU</option>
                                                        @foreach ($rtugi as $merk)
                                                        <option value="{{ $merk->id_rtugi }}"
                                                            {{ old('id_rtugi', $penyulang->id_rtugi) == $merk->id_rtugi ? 'selected' : '' }}>
                                                            {{ $merk->nama_rtugi }}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                    @error('id_rtugi')
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
                                            <div class="col-12 col-lg-6">
                                                @php
                                                $s_cb = old('s_cb', $penyulang->s_cb ?? '');
                                                $s_cb_array = is_array($s_cb) ? $s_cb : explode(',', $s_cb);
                                                $s_lr = old('s_lr', $penyulang->s_lr ?? '');
                                                $s_lr_array = is_array($s_lr) ? $s_lr : explode(',', $s_lr);
                                                $s_ocr = old('s_ocr', $penyulang->s_ocr ?? '');
                                                $s_ocr_array = is_array($s_ocr) ? $s_ocr : explode(',', $s_ocr);
                                                $s_ocri = old('s_ocri', $penyulang->s_ocri ?? '');
                                                $s_ocri_array = is_array($s_ocri) ? $s_ocri : explode(',', $s_ocri);
                                                $s_dgr = old('s_dgr', $penyulang->s_dgr ?? '');
                                                $s_dgr_array = is_array($s_dgr) ? $s_dgr : explode(',', $s_dgr);
                                                $s_cbtr = old('s_cbtr', $penyulang->s_cbtr ?? '');
                                                $s_cbtr_array = is_array($s_cbtr) ? $s_cbtr : explode(',', $s_cbtr);
                                                $s_ar = old('s_ar', $penyulang->s_ar ?? '');
                                                $s_ar_array = is_array($s_ar) ? $s_ar : explode(',', $s_ar);
                                                $s_aru = old('s_aru', $penyulang->s_aru ?? '');
                                                $s_aru_array = is_array($s_aru) ? $s_aru : explode(',', $s_aru);
                                                $s_tc = old('s_tc', $penyulang->s_tc ?? '');
                                                $s_tc_array = is_array($s_tc) ? $s_tc : explode(',', $s_tc);
                                                @endphp
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
                                                                {{ in_array('open_1', $s_cb_array) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">OK</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_cb[]" value="open_2"
                                                                id="cb_open_2" class="selectgroup-input"
                                                                {{ in_array('open_2', $s_cb_array) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">NOK</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_cb[]" value="open_3"
                                                                id="cb_open_3" class="selectgroup-input"
                                                                {{ in_array('open_3', $s_cb_array) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">LOG</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_cb[]" value="open_4"
                                                                id="cb_open_4" class="selectgroup-input"
                                                                {{ in_array('open_4', $s_cb_array) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">SLD</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_cb[]" value="open_5"
                                                                id="cb_open_5" class="selectgroup-input"
                                                                {{ in_array('open_5', $s_cb_array) ? 'checked' : '' }} />
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
                                                                {{ in_array('close_1', $s_cb_array) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">OK</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_cb[]" value="close_2"
                                                                id="cb_close_2" class="selectgroup-input"
                                                                {{ in_array('close_2', $s_cb_array) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">NOK</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_cb[]" value="close_3"
                                                                id="cb_close_3" class="selectgroup-input"
                                                                {{ in_array('close_3', $s_cb_array) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">LOG</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_cb[]" value="close_4"
                                                                id="cb_close_4" class="selectgroup-input"
                                                                {{ in_array('close_4', $s_cb_array) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">SLD</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_cb[]" value="close_5"
                                                                id="cb_close_5" class="selectgroup-input"
                                                                {{ in_array('close_5', $s_cb_array) ? 'checked' : '' }} />
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
                                                                {{ in_array('local_1', $s_lr_array) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">OK</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_lr[]" value="local_2"
                                                                id="lr_local_2" class="selectgroup-input"
                                                                {{ in_array('local_2', $s_lr_array) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">NOK</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_lr[]" value="local_3"
                                                                id="lr_local_3" class="selectgroup-input"
                                                                {{ in_array('local_3', $s_lr_array) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">LOG</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_lr[]" value="local_4"
                                                                id="lr_local_4" class="selectgroup-input"
                                                                {{ in_array('local_4', $s_lr_array) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">SLD</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_lr[]" value="local_5"
                                                                id="lr_local_5" class="selectgroup-input"
                                                                {{ in_array('local_5', $s_lr_array) ? 'checked' : '' }} />
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
                                                                {{ in_array('remote_1', $s_lr_array) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">OK</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_lr[]" value="remote_2"
                                                                id="lr_remote_2" class="selectgroup-input"
                                                                {{ in_array('remote_2', $s_lr_array) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">NOK</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_lr[]" value="remote_3"
                                                                id="lr_remote_3" class="selectgroup-input"
                                                                {{ in_array('remote_3', $s_lr_array) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">LOG</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_lr[]" value="remote_4"
                                                                id="lr_remote_4" class="selectgroup-input"
                                                                {{ in_array('remote_4', $s_lr_array) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">SLD</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_lr[]" value="remote_5"
                                                                id="lr_remote_5" class="selectgroup-input"
                                                                {{ in_array('remote_5', $s_lr_array) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">Tidak Uji</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label t-bold">OCR Dis</label>
                                                    <div class="selectgroup w-100 flex-wrap">
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" id="s_ocr_dis_checkAll"
                                                                class="selectgroup-input" />
                                                            <span class="selectgroup-button">Normal</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_ocr[]" value="ocrd_1"
                                                                id="s_ocrd_1" class="selectgroup-input"
                                                                {{ in_array('ocrd_1', $s_ocr_array) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">OK</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_ocr[]" value="ocrd_2"
                                                                id="s_ocrd_2" class="selectgroup-input"
                                                                {{ in_array('ocrd_2', $s_ocr_array) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">NOK</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_ocr[]" value="ocrd_3"
                                                                id="s_ocrd_3" class="selectgroup-input"
                                                                {{ in_array('ocrd_3', $s_ocr_array) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">LOG</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_ocr[]" value="ocrd_4"
                                                                id="s_ocrd_4" class="selectgroup-input"
                                                                {{ in_array('ocrd_4', $s_ocr_array) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">SLD</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_ocr[]" value="ocrd_5"
                                                                id="s_ocrd_5" class="selectgroup-input"
                                                                {{ in_array('ocrd_5', $s_ocr_array) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">Tidak Uji</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label t-bold">OCR App</label>
                                                    <div class="selectgroup w-100 flex-wrap">
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" id="s_ocr_app_checkAll"
                                                                class="selectgroup-input" />
                                                            <span class="selectgroup-button">Normal</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_ocr[]" value="ocra_1"
                                                                id="s_ocra_1" class="selectgroup-input"
                                                                {{ in_array('ocra_1', $s_ocr_array) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">OK</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_ocr[]" value="ocra_2"
                                                                id="s_ocra_2" class="selectgroup-input"
                                                                {{ in_array('ocra_2', $s_ocr_array) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">NOK</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_ocr[]" value="ocra_3"
                                                                id="s_ocra_3" class="selectgroup-input"
                                                                {{ in_array('ocra_3', $s_ocr_array) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">LOG</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_ocr[]" value="ocra_4"
                                                                id="s_ocra_4" class="selectgroup-input"
                                                                {{ in_array('ocra_4', $s_ocr_array) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">SLD</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_ocr[]" value="ocra_5"
                                                                id="s_ocra_5" class="selectgroup-input"
                                                                {{ in_array('ocra_5', $s_ocr_array) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">Tidak Uji</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label t-bold">OCRI Dis</label>
                                                    <div class="selectgroup w-100 flex-wrap">
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" id="s_ocri_dis_checkAll"
                                                                class="selectgroup-input" />
                                                            <span class="selectgroup-button">Normal</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_ocri[]" value="ocrid_1"
                                                                id="s_ocrid_1" class="selectgroup-input"
                                                                {{ in_array('ocrid_1', $s_ocri_array) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">OK</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_ocri[]" value="ocrid_2"
                                                                id="s_ocrid_2" class="selectgroup-input"
                                                                {{ in_array('ocrid_2', $s_ocri_array) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">NOK</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_ocri[]" value="ocrid_3"
                                                                id="s_ocrid_3" class="selectgroup-input"
                                                                {{ in_array('ocrid_3', $s_ocri_array) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">LOG</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_ocri[]" value="ocrid_4"
                                                                id="s_ocrid_4" class="selectgroup-input"
                                                                {{ in_array('ocrid_4', $s_ocri_array) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">SLD</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_ocri[]" value="ocrid_5"
                                                                id="s_ocrid_5" class="selectgroup-input"
                                                                {{ in_array('ocrid_5', $s_ocri_array) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">Tidak Uji</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label t-bold">OCRI App</label>
                                                    <div class="selectgroup w-100 flex-wrap">
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" id="s_ocri_app_checkAll"
                                                                class="selectgroup-input" />
                                                            <span class="selectgroup-button">Normal</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_ocri[]" value="ocria_1"
                                                                id="s_ocria_1" class="selectgroup-input"
                                                                {{ in_array('ocria_1', $s_ocri_array) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">OK</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_ocri[]" value="ocria_2"
                                                                id="s_ocria_2" class="selectgroup-input"
                                                                {{ in_array('ocria_2', $s_ocri_array) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">NOK</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_ocri[]" value="ocria_3"
                                                                id="s_ocria_3" class="selectgroup-input"
                                                                {{ in_array('ocria_3', $s_ocri_array) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">LOG</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_ocri[]" value="ocria_4"
                                                                id="s_ocria_4" class="selectgroup-input"
                                                                {{ in_array('ocria_4', $s_ocri_array) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">SLD</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_ocri[]" value="ocria_5"
                                                                id="s_ocria_5" class="selectgroup-input"
                                                                {{ in_array('ocria_5', $s_ocri_array) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">Tidak Uji</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label t-bold">DGR Dis</label>
                                                    <div class="selectgroup w-100 flex-wrap">
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" id="s_dgr_dis_checkAll"
                                                                class="selectgroup-input" />
                                                            <span class="selectgroup-button">Normal</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_dgr[]" value="dgrd_1"
                                                                id="s_dgrd_1" class="selectgroup-input"
                                                                {{ in_array('dgrd_1', $s_dgr_array) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">OK</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_dgr[]" value="dgrd_2"
                                                                id="s_dgrd_2" class="selectgroup-input"
                                                                {{ in_array('dgrd_2', $s_dgr_array) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">NOK</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_dgr[]" value="dgrd_3"
                                                                id="s_dgrd_3" class="selectgroup-input"
                                                                {{ in_array('dgrd_3', $s_dgr_array) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">LOG</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_dgr[]" value="dgrd_4"
                                                                id="s_dgrd_4" class="selectgroup-input"
                                                                {{ in_array('dgrd_4', $s_dgr_array) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">SLD</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_dgr[]" value="dgrd_5"
                                                                id="s_dgrd_5" class="selectgroup-input"
                                                                {{ in_array('dgrd_5', $s_dgr_array) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">Tidak Uji</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label t-bold">DGR App</label>
                                                    <div class="selectgroup w-100 flex-wrap">
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" id="s_dgr_app_checkAll"
                                                                class="selectgroup-input" />
                                                            <span class="selectgroup-button">Normal</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_dgr[]" value="dgra_1"
                                                                id="s_dgra_1" class="selectgroup-input"
                                                                {{ in_array('dgra_1', $s_dgr_array) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">OK</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_dgr[]" value="dgra_2"
                                                                id="s_dgra_2" class="selectgroup-input"
                                                                {{ in_array('dgra_2', $s_dgr_array) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">NOK</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_dgr[]" value="dgra_3"
                                                                id="s_dgra_3" class="selectgroup-input"
                                                                {{ in_array('dgra_3', $s_dgr_array) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">LOG</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_dgr[]" value="dgra_4"
                                                                id="s_dgra_4" class="selectgroup-input"
                                                                {{ in_array('dgra_4', $s_dgr_array) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">SLD</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_dgr[]" value="dgra_5"
                                                                id="s_dgra_5" class="selectgroup-input"
                                                                {{ in_array('dgra_5', $s_dgr_array) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">Tidak Uji</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label t-bold">CBTR Dis</label>
                                                    <div class="selectgroup w-100 flex-wrap">
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" id="s_cbtr_dis_checkAll"
                                                                class="selectgroup-input" />
                                                            <span class="selectgroup-button">Normal</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_cbtr[]" value="cbtrd_1"
                                                                id="s_cbtrd_1" class="selectgroup-input"
                                                                {{ in_array('cbtrd_1', $s_cbtr_array) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">OK</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_cbtr[]" value="cbtrd_2"
                                                                id="s_cbtrd_2" class="selectgroup-input"
                                                                {{ in_array('cbtrd_2', $s_cbtr_array) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">NOK</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_cbtr[]" value="cbtrd_3"
                                                                id="s_cbtrd_3" class="selectgroup-input"
                                                                {{ in_array('cbtrd_3', $s_cbtr_array) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">LOG</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_cbtr[]" value="cbtrd_4"
                                                                id="s_cbtrd_4" class="selectgroup-input"
                                                                {{ in_array('cbtrd_4', $s_cbtr_array) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">SLD</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_cbtr[]" value="cbtrd_5"
                                                                id="s_cbtrd_5" class="selectgroup-input"
                                                                {{ in_array('cbtrd_5', $s_cbtr_array) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">Tidak Uji</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label t-bold">CBTR App</label>
                                                    <div class="selectgroup w-100 flex-wrap">
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" id="s_cbtr_app_checkAll"
                                                                class="selectgroup-input" />
                                                            <span class="selectgroup-button">Normal</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_cbtr[]" value="cbtra_1"
                                                                id="s_cbtra_1" class="selectgroup-input"
                                                                {{ in_array('cbtra_1', $s_cbtr_array) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">OK</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_cbtr[]" value="cbtra_2"
                                                                id="s_cbtra_2" class="selectgroup-input"
                                                                {{ in_array('cbtra_2', $s_cbtr_array) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">NOK</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_cbtr[]" value="cbtra_3"
                                                                id="s_cbtra_3" class="selectgroup-input"
                                                                {{ in_array('cbtra_3', $s_cbtr_array) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">LOG</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_cbtr[]" value="cbtra_4"
                                                                id="s_cbtra_4" class="selectgroup-input"
                                                                {{ in_array('cbtra_4', $s_cbtr_array) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">SLD</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_cbtr[]" value="cbtra_5"
                                                                id="s_cbtra_5" class="selectgroup-input"
                                                                {{ in_array('cbtra_5', $s_cbtr_array) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">Tidak Uji</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label t-bold">AR Dis</label>
                                                    <div class="selectgroup w-100 flex-wrap">
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" id="s_ar_dis_checkAll"
                                                                class="selectgroup-input" />
                                                            <span class="selectgroup-button">Normal</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_ar[]" value="ard_1"
                                                                id="s_ard_1" class="selectgroup-input"
                                                                {{ in_array('ard_1', $s_ar_array) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">OK</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_ar[]" value="ard_2"
                                                                id="s_ard_2" class="selectgroup-input"
                                                                {{ in_array('ard_2', $s_ar_array) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">NOK</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_ar[]" value="ard_3"
                                                                id="s_ard_3" class="selectgroup-input"
                                                                {{ in_array('ard_3', $s_ar_array) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">LOG</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_ar[]" value="ard_4"
                                                                id="s_ard_4" class="selectgroup-input"
                                                                {{ in_array('ard_4', $s_ar_array) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">SLD</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_ar[]" value="ard_5"
                                                                id="s_ard_5" class="selectgroup-input"
                                                                {{ in_array('ard_5', $s_ar_array) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">Tidak Uji</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label t-bold">AR App</label>
                                                    <div class="selectgroup w-100 flex-wrap">
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" id="s_ar_app_checkAll"
                                                                class="selectgroup-input" />
                                                            <span class="selectgroup-button">Normal</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_ar[]" value="ara_1"
                                                                id="s_ara_1" class="selectgroup-input"
                                                                {{ in_array('ara_1', $s_ar_array) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">OK</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_ar[]" value="ara_2"
                                                                id="s_ara_2" class="selectgroup-input"
                                                                {{ in_array('ara_2', $s_ar_array) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">NOK</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_ar[]" value="ara_3"
                                                                id="s_ara_3" class="selectgroup-input"
                                                                {{ in_array('ara_3', $s_ar_array) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">LOG</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_ar[]" value="ara_4"
                                                                id="s_ara_4" class="selectgroup-input"
                                                                {{ in_array('ara_4', $s_ar_array) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">SLD</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_ar[]" value="ara_5"
                                                                id="s_ara_5" class="selectgroup-input"
                                                                {{ in_array('ara_5', $s_ar_array) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">Tidak Uji</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label t-bold">ARU Dis</label>
                                                    <div class="selectgroup w-100 flex-wrap">
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" id="s_aru_dis_checkAll"
                                                                class="selectgroup-input" />
                                                            <span class="selectgroup-button">Normal</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_aru[]" value="arud_1"
                                                                id="s_arud_1" class="selectgroup-input"
                                                                {{ in_array('arud_1', $s_aru_array) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">OK</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_aru[]" value="arud_2"
                                                                id="s_arud_2" class="selectgroup-input"
                                                                {{ in_array('arud_2', $s_aru_array) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">NOK</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_aru[]" value="arud_3"
                                                                id="s_arud_3" class="selectgroup-input"
                                                                {{ in_array('arud_3', $s_aru_array) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">LOG</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_aru[]" value="arud_4"
                                                                id="s_arud_4" class="selectgroup-input"
                                                                {{ in_array('arud_4', $s_aru_array) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">SLD</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_aru[]" value="arud_5"
                                                                id="s_arud_5" class="selectgroup-input"
                                                                {{ in_array('arud_5', $s_aru_array) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">Tidak Uji</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label t-bold">ARU App</label>
                                                    <div class="selectgroup w-100 flex-wrap">
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" id="s_aru_app_checkAll"
                                                                class="selectgroup-input" />
                                                            <span class="selectgroup-button">Normal</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_aru[]" value="arua_1"
                                                                id="s_arua_1" class="selectgroup-input"
                                                                {{ in_array('arua_1', $s_aru_array) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">OK</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_aru[]" value="arua_2"
                                                                id="s_arua_2" class="selectgroup-input"
                                                                {{ in_array('arua_2', $s_aru_array) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">NOK</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_aru[]" value="arua_3"
                                                                id="s_arua_3" class="selectgroup-input"
                                                                {{ in_array('arua_3', $s_aru_array) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">LOG</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_aru[]" value="arua_4"
                                                                id="s_arua_4" class="selectgroup-input"
                                                                {{ in_array('arua_4', $s_aru_array) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">SLD</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_aru[]" value="arua_5"
                                                                id="s_arua_5" class="selectgroup-input"
                                                                {{ in_array('arua_5', $s_aru_array) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">Tidak Uji</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label t-bold">TC Dis</label>
                                                    <div class="selectgroup w-100 flex-wrap">
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" id="s_tc_dis_checkAll"
                                                                class="selectgroup-input" />
                                                            <span class="selectgroup-button">Normal</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_tc[]" value="tcd_1"
                                                                id="s_tcd_1" class="selectgroup-input"
                                                                {{ in_array('tcd_1', $s_tc_array) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">OK</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_tc[]" value="tcd_2"
                                                                id="s_tcd_2" class="selectgroup-input"
                                                                {{ in_array('tcd_2', $s_tc_array) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">NOK</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_tc[]" value="tcd_3"
                                                                id="s_tcd_3" class="selectgroup-input"
                                                                {{ in_array('tcd_3', $s_tc_array) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">LOG</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_tc[]" value="tcd_4"
                                                                id="s_tcd_4" class="selectgroup-input"
                                                                {{ in_array('tcd_4', $s_tc_array) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">SLD</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_tc[]" value="tcd_5"
                                                                id="s_tcd_5" class="selectgroup-input"
                                                                {{ in_array('tcd_5', $s_tc_array) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">Tidak Uji</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label t-bold">TC App</label>
                                                    <div class="selectgroup w-100 flex-wrap">
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" id="s_tc_app_checkAll"
                                                                class="selectgroup-input" />
                                                            <span class="selectgroup-button">Normal</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_tc[]" value="tca_1"
                                                                id="s_tca_1" class="selectgroup-input"
                                                                {{ in_array('tca_1', $s_tc_array) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">OK</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_tc[]" value="tca_2"
                                                                id="s_tca_2" class="selectgroup-input"
                                                                {{ in_array('tca_2', $s_tc_array) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">NOK</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_tc[]" value="tca_3"
                                                                id="s_tca_3" class="selectgroup-input"
                                                                {{ in_array('tca_3', $s_tc_array) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">LOG</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_tc[]" value="tca_4"
                                                                id="s_tca_4" class="selectgroup-input"
                                                                {{ in_array('tca_4', $s_tc_array) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">SLD</span>
                                                        </label>
                                                        <label class="selectgroup-item mb-2 mb-sm-0">
                                                            <input type="checkbox" name="s_tc[]" value="tca_5"
                                                                id="s_tca_5" class="selectgroup-input"
                                                                {{ in_array('tca_5', $s_tc_array) ? 'checked' : '' }} />
                                                            <span class="selectgroup-button">Tidak Uji</span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-3">
                                                <div class="form-group">
                                                    <label for="scb_open_address">CB Open Address</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="scb_open_address"
                                                            name="scb_open_address" placeholder="CB Open Address"
                                                            value="{{ old('scb_open_address', $penyulang->scb_open_address) }}" />
                                                        @error('scb_open_address')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="scb_close_address">CB Close Address</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="scb_close_address"
                                                            name="scb_close_address" placeholder="CB Close Address"
                                                            value="{{ old('scb_close_address', $penyulang->scb_close_address) }}" />
                                                        @error('scb_close_address')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="slocal_address">Local Address</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="slocal_address"
                                                            name="slocal_address" placeholder="Local Address"
                                                            value="{{ old('slocal_address', $penyulang->slocal_address) }}" />
                                                        @error('slocal_address')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="sremote_address">Remote Address</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="sremote_address"
                                                            name="sremote_address" placeholder="Remote Address"
                                                            value="{{ old('sremote_address', $penyulang->sremote_address) }}" />
                                                        @error('sremote_address')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="socr_dis_address">OCR Dis Address</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="socr_dis_address"
                                                            name="socr_dis_address" placeholder="OCR Dis Address"
                                                            value="{{ old('socr_dis_address', $penyulang->socr_dis_address) }}" />
                                                        @error('socr_dis_address')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="socr_app_address">OCR App Address</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="socr_app_address"
                                                            name="socr_app_address" placeholder="OCR App Address"
                                                            value="{{ old('socr_app_address', $penyulang->socr_app_address) }}" />
                                                        @error('socr_app_address')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="socri_dis_address">OCRI Dis Address</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="socri_dis_address"
                                                            name="socri_dis_address" placeholder="OCRI Dis Address"
                                                            value="{{ old('socri_dis_address', $penyulang->socri_dis_address) }}" />
                                                        @error('socri_dis_address')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="socri_app_address">OCRI App Address</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="socri_app_address"
                                                            name="socri_app_address" placeholder="OCRI App Address"
                                                            value="{{ old('socri_app_address', $penyulang->socri_app_address) }}" />
                                                        @error('socri_app_address')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="sdgr_dis_address">DGR Dis Address</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="sdgr_dis_address"
                                                            name="sdgr_dis_address" placeholder="DGR Dis Address"
                                                            value="{{ old('sdgr_dis_address', $penyulang->sdgr_dis_address) }}" />
                                                        @error('sdgr_dis_address')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="sdgr_app_address">DGR App Address</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="sdgr_app_address"
                                                            name="sdgr_app_address" placeholder="DGR App Address"
                                                            value="{{ old('sdgr_app_address', $penyulang->sdgr_app_address) }}" />
                                                        @error('sdgr_app_address')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="scbtr_dis_address">CBTR Dis Address</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="scbtr_dis_address"
                                                            name="scbtr_dis_address" placeholder="CBTR Dis Address"
                                                            value="{{ old('scbtr_dis_address', $penyulang->scbtr_dis_address) }}" />
                                                        @error('scbtr_dis_address')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="scbtr_app_address">CBTR App Address</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="scbtr_app_address"
                                                            name="scbtr_app_address" placeholder="CBTR App Address"
                                                            value="{{ old('scbtr_app_address', $penyulang->scbtr_app_address) }}" />
                                                        @error('scbtr_app_address')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="sar_dis_address">AR Dis Address</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="sar_dis_address"
                                                            name="sar_dis_address" placeholder="AR Dis Address"
                                                            value="{{ old('sar_dis_address', $penyulang->sar_dis_address) }}" />
                                                        @error('sar_dis_address')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="sar_app_address">AR App Address</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="sar_app_address"
                                                            name="sar_app_address" placeholder="AR App Address"
                                                            value="{{ old('sar_app_address', $penyulang->sar_app_address) }}" />
                                                        @error('sar_app_address')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="saru_dis_address">ARU Dis Address</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="saru_dis_address"
                                                            name="saru_dis_address" placeholder="ARU Dis Address"
                                                            value="{{ old('saru_dis_address', $penyulang->saru_dis_address) }}" />
                                                        @error('saru_dis_address')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="saru_app_address">ARU App Address</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="saru_app_address"
                                                            name="saru_app_address" placeholder="ARU App Address"
                                                            value="{{ old('saru_app_address', $penyulang->saru_app_address) }}" />
                                                        @error('saru_app_address')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="stc_dis_address">TC Dis Address</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="stc_dis_address"
                                                            name="stc_dis_address" placeholder="TC Dis Address"
                                                            value="{{ old('stc_dis_address', $penyulang->stc_dis_address) }}" />
                                                        @error('stc_dis_address')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="stc_app_address">TC App Address</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="stc_app_address"
                                                            name="stc_app_address" placeholder="TC App Address"
                                                            value="{{ old('stc_app_address', $penyulang->stc_app_address) }}" />
                                                        @error('stc_app_address')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-3">
                                                <div class="form-group">
                                                    <label for="scb_open_objfrmt">CB Open OBJ/FRMT</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="scb_open_objfrmt"
                                                            name="scb_open_objfrmt" placeholder="CB Open OBJ/FRMT"
                                                            value="{{ old('scb_open_objfrmt', $penyulang->scb_open_objfrmt) }}" />
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
                                                            value="{{ old('scb_close_objfrmt', $penyulang->scb_close_objfrmt) }}" />
                                                        @error('scb_close_objfrmt')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="slocal_objfrmt">Local OBJ/FRMT</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="slocal_objfrmt"
                                                            name="slocal_objfrmt" placeholder="Local OBJ/FRMT"
                                                            value="{{ old('slocal_objfrmt', $penyulang->slocal_objfrmt) }}" />
                                                        @error('slocal_objfrmt')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="sremote_objfrmt">Remote OBJ/FRMT</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="sremote_objfrmt"
                                                            name="sremote_objfrmt" placeholder="Remote OBJ/FRMT"
                                                            value="{{ old('sremote_objfrmt', $penyulang->sremote_objfrmt) }}" />
                                                        @error('sremote_objfrmt')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="socr_dis_objfrmt">OCR Dis OBJ/FRMT</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="socr_dis_objfrmt"
                                                            name="socr_dis_objfrmt" placeholder="OCR Dis OBJ/FRMT"
                                                            value="{{ old('socr_dis_objfrmt', $penyulang->socr_dis_objfrmt) }}" />
                                                        @error('socr_dis_objfrmt')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="socr_app_objfrmt">OCR App OBJ/FRMT</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="socr_app_objfrmt"
                                                            name="socr_app_objfrmt" placeholder="OCR App OBJ/FRMT"
                                                            value="{{ old('socr_app_objfrmt', $penyulang->socr_app_objfrmt) }}" />
                                                        @error('socr_app_objfrmt')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="socri_dis_objfrmt">OCRI Dis OBJ/FRMT</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="socri_dis_objfrmt"
                                                            name="socri_dis_objfrmt" placeholder="OCRI Dis OBJ/FRMT"
                                                            value="{{ old('socri_dis_objfrmt', $penyulang->socri_dis_objfrmt) }}" />
                                                        @error('socri_dis_objfrmt')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="socri_app_objfrmt">OCRI App OBJ/FRMT</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="socri_app_objfrmt"
                                                            name="socri_app_objfrmt" placeholder="OCRI App OBJ/FRMT"
                                                            value="{{ old('socri_app_objfrmt', $penyulang->socri_app_objfrmt) }}" />
                                                        @error('socri_app_objfrmt')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="sdgr_dis_objfrmt">DGR Dis OBJ/FRMT</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="sdgr_dis_objfrmt"
                                                            name="sdgr_dis_objfrmt" placeholder="DGR Dis OBJ/FRMT"
                                                            value="{{ old('sdgr_dis_objfrmt', $penyulang->sdgr_dis_objfrmt) }}" />
                                                        @error('sdgr_dis_objfrmt')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="sdgr_app_objfrmt">DGR App OBJ/FRMT</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="sdgr_app_objfrmt"
                                                            name="sdgr_app_objfrmt" placeholder="DGR App OBJ/FRMT"
                                                            value="{{ old('sdgr_app_objfrmt', $penyulang->sdgr_app_objfrmt) }}" />
                                                        @error('sdgr_app_objfrmt')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="scbtr_dis_objfrmt">CBTR Dis OBJ/FRMT</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="scbtr_dis_objfrmt"
                                                            name="scbtr_dis_objfrmt" placeholder="CBTR Dis OBJ/FRMT"
                                                            value="{{ old('scbtr_dis_objfrmt', $penyulang->scbtr_dis_objfrmt) }}" />
                                                        @error('scbtr_dis_objfrmt')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="scbtr_app_objfrmt">CBTR App OBJ/FRMT</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="scbtr_app_objfrmt"
                                                            name="scbtr_app_objfrmt" placeholder="CBTR App OBJ/FRMT"
                                                            value="{{ old('scbtr_app_objfrmt', $penyulang->scbtr_app_objfrmt) }}" />
                                                        @error('scbtr_app_objfrmt')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="sar_dis_objfrmt">AR Dis OBJ/FRMT</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="sar_dis_objfrmt"
                                                            name="sar_dis_objfrmt" placeholder="AR Dis OBJ/FRMT"
                                                            value="{{ old('sar_dis_objfrmt', $penyulang->sar_dis_objfrmt) }}" />
                                                        @error('sar_dis_objfrmt')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="sar_app_objfrmt">AR App OBJ/FRMT</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="sar_app_objfrmt"
                                                            name="sar_app_objfrmt" placeholder="AR App OBJ/FRMT"
                                                            value="{{ old('sar_app_objfrmt', $penyulang->sar_app_objfrmt) }}" />
                                                        @error('sar_app_objfrmt')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="saru_dis_objfrmt">ARU Dis OBJ/FRMT</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="saru_dis_objfrmt"
                                                            name="saru_dis_objfrmt" placeholder="ARU Dis OBJ/FRMT"
                                                            value="{{ old('saru_dis_objfrmt', $penyulang->saru_dis_objfrmt) }}" />
                                                        @error('saru_dis_objfrmt')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="saru_app_objfrmt">ARU App OBJ/FRMT</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="saru_app_objfrmt"
                                                            name="saru_app_objfrmt" placeholder="ARU App OBJ/FRMT"
                                                            value="{{ old('saru_app_objfrmt', $penyulang->saru_app_objfrmt) }}" />
                                                        @error('saru_app_objfrmt')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="stc_dis_objfrmt">TC Dis OBJ/FRMT</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="stc_dis_objfrmt"
                                                            name="stc_dis_objfrmt" placeholder="TC Dis OBJ/FRMT"
                                                            value="{{ old('stc_dis_objfrmt', $penyulang->stc_dis_objfrmt) }}" />
                                                        @error('stc_dis_objfrmt')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="stc_app_objfrmt">TC App OBJ/FRMT</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="stc_app_objfrmt"
                                                            name="stc_app_objfrmt" placeholder="TC App OBJ/FRMT"
                                                            value="{{ old('stc_app_objfrmt', $penyulang->stc_app_objfrmt) }}" />
                                                        @error('stc_app_objfrmt')
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
                                                @php
                                                $c_cb = old('c_cb', $penyulang->c_cb ?? '');
                                                $c_cb_array = is_array($c_cb) ? $c_cb : explode(',', $c_cb);

                                                $c_aru = old('c_aru', $penyulang->c_aru ?? '');
                                                $c_aru_array = is_array($c_aru) ? $c_aru : explode(',', $c_aru);

                                                $c_rst = old('c_rst', $penyulang->c_rst ?? '');
                                                $c_rst_array = is_array($c_rst) ? $c_rst : explode(',', $c_rst);

                                                $c_tc = old('c_tc', $penyulang->c_tc ?? '');
                                                $c_tc_array = is_array($c_tc) ? $c_tc : explode(',', $c_tc);
                                                @endphp
                                                <div class="form-group">
                                                    <div class="row">
                                                        <label class="form-label t-bold">CB Open</label>
                                                        <div class="selectgroup w-100 flex-wrap">
                                                            <label class="selectgroup-item mb-2 mb-sm-0 ">
                                                                <input type="checkbox" id="ccb_open_checkAll_ok"
                                                                    class="selectgroup-input" />
                                                                <span class="selectgroup-button">Normal</span>
                                                            </label>
                                                            <label class="selectgroup-item mb-2 mb-sm-0">
                                                                <input type="checkbox" name="c_cb[]" value="ccb_open_1"
                                                                    id="ccb_open_1" class="selectgroup-input"
                                                                    {{ in_array('ccb_open_1', $c_cb_array) ? 'checked' : '' }} />
                                                                <span class="selectgroup-button">OK</span>
                                                            </label>
                                                            <label class="selectgroup-item mb-2 mb-sm-0">
                                                                <input type="checkbox" name="c_cb[]" value="ccb_open_2"
                                                                    id="ccb_open_2" class="selectgroup-input"
                                                                    {{ in_array('ccb_open_2', $c_cb_array) ? 'checked' : '' }} />
                                                                <span class="selectgroup-button">NOK</span>
                                                            </label>
                                                            <label class="selectgroup-item mb-2 mb-sm-0">
                                                                <input type="checkbox" name="c_cb[]" value="ccb_open_3"
                                                                    id="ccb_open_3" class="selectgroup-input"
                                                                    {{ in_array('ccb_open_3', $c_cb_array) ? 'checked' : '' }} />
                                                                <span class="selectgroup-button">LOG</span>
                                                            </label>
                                                            <label class="selectgroup-item mb-2 mb-sm-0">
                                                                <input type="checkbox" name="c_cb[]" value="ccb_open_4"
                                                                    id="ccb_open_4" class="selectgroup-input"
                                                                    {{ in_array('ccb_open_4', $c_cb_array) ? 'checked' : '' }} />
                                                                <span class="selectgroup-button">SLD</span>
                                                            </label>
                                                            <label class="selectgroup-item mb-2 mb-sm-0">
                                                                <input type="checkbox" name="c_cb[]" value="ccb_open_5"
                                                                    id="ccb_open_5" class="selectgroup-input"
                                                                    {{ in_array('ccb_open_5', $c_cb_array) ? 'checked' : '' }} />
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
                                                                <input type="checkbox" name="c_cb[]" value="ccb_close_1"
                                                                    id="ccb_close_1" class="selectgroup-input"
                                                                    {{ in_array('ccb_close_1', $c_cb_array) ? 'checked' : '' }} />
                                                                <span class="selectgroup-button">OK</span>
                                                            </label>
                                                            <label class="selectgroup-item mb-2 mb-sm-0">
                                                                <input type="checkbox" name="c_cb[]" value="ccb_close_2"
                                                                    id="ccb_close_2" class="selectgroup-input"
                                                                    {{ in_array('ccb_close_2', $c_cb_array) ? 'checked' : '' }} />
                                                                <span class="selectgroup-button">NOK</span>
                                                            </label>
                                                            <label class="selectgroup-item mb-2 mb-sm-0">
                                                                <input type="checkbox" name="c_cb[]" value="ccb_close_3"
                                                                    id="ccb_close_3" class="selectgroup-input"
                                                                    {{ in_array('ccb_close_3', $c_cb_array) ? 'checked' : '' }} />
                                                                <span class="selectgroup-button">LOG</span>
                                                            </label>
                                                            <label class="selectgroup-item mb-2 mb-sm-0">
                                                                <input type="checkbox" name="c_cb[]" value="ccb_close_4"
                                                                    id="ccb_close_4" class="selectgroup-input"
                                                                    {{ in_array('ccb_close_4', $c_cb_array) ? 'checked' : '' }} />
                                                                <span class="selectgroup-button">SLD</span>
                                                            </label>
                                                            <label class="selectgroup-item mb-2 mb-sm-0">
                                                                <input type="checkbox" name="c_cb[]" value="ccb_close_5"
                                                                    id="ccb_close_5" class="selectgroup-input"
                                                                    {{ in_array('ccb_close_5', $c_cb_array) ? 'checked' : '' }} />
                                                                <span class="selectgroup-button">Tidak Uji</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <label class="form-label t-bold">ARU Use</label>
                                                        <div class="selectgroup w-100 flex-wrap">
                                                            <label class="selectgroup-item mb-2 mb-sm-0">
                                                                <input type="checkbox" id="c_aru_use_checkAll"
                                                                    class="selectgroup-input" />
                                                                <span class="selectgroup-button">Normal</span>
                                                            </label>
                                                            <label class="selectgroup-item mb-2 mb-sm-0">
                                                                <input type="checkbox" name="c_aru[]" value="caru_1"
                                                                    id="c_aru_1" class="selectgroup-input"
                                                                    {{ in_array('caru_1', $c_aru_array) ? 'checked' : '' }} />
                                                                <span class="selectgroup-button">OK</span>
                                                            </label>
                                                            <label class="selectgroup-item mb-2 mb-sm-0">
                                                                <input type="checkbox" name="c_aru[]" value="caru_2"
                                                                    id="c_aru_2" class="selectgroup-input"
                                                                    {{ in_array('caru_2', $c_aru_array) ? 'checked' : '' }} />
                                                                <span class="selectgroup-button">NOK</span>
                                                            </label>
                                                            <label class="selectgroup-item mb-2 mb-sm-0">
                                                                <input type="checkbox" name="c_aru[]" value="caru_3"
                                                                    id="c_aru_3" class="selectgroup-input"
                                                                    {{ in_array('caru_3', $c_aru_array) ? 'checked' : '' }} />
                                                                <span class="selectgroup-button">LOG</span>
                                                            </label>
                                                            <label class="selectgroup-item mb-2 mb-sm-0">
                                                                <input type="checkbox" name="c_aru[]" value="caru_4"
                                                                    id="c_aru_4" class="selectgroup-input"
                                                                    {{ in_array('caru_4', $c_aru_array) ? 'checked' : '' }} />
                                                                <span class="selectgroup-button">SLD</span>
                                                            </label>
                                                            <label class="selectgroup-item mb-2 mb-sm-0">
                                                                <input type="checkbox" name="c_aru[]" value="caru_5"
                                                                    id="c_aru_5" class="selectgroup-input"
                                                                    {{ in_array('caru_5', $c_aru_array) ? 'checked' : '' }} />
                                                                <span class="selectgroup-button">Tidak Uji</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <label class="form-label t-bold">ARU Unuse</label>
                                                        <div class="selectgroup w-100 flex-wrap">
                                                            <label class="selectgroup-item mb-2 mb-sm-0 ">
                                                                <input type="checkbox" id="c_aru_unuse_checkAll"
                                                                    class="selectgroup-input" />
                                                                <span class="selectgroup-button">Normal</span>
                                                            </label>
                                                            <label class="selectgroup-item mb-2 mb-sm-0">
                                                                <input type="checkbox" name="c_aru[]" value="carun_1"
                                                                    id="c_aruun_1" class="selectgroup-input"
                                                                    {{ in_array('carun_1', $c_aru_array) ? 'checked' : '' }} />
                                                                <span class="selectgroup-button">OK</span>
                                                            </label>
                                                            <label class="selectgroup-item mb-2 mb-sm-0">
                                                                <input type="checkbox" name="c_aru[]" value="carun_2"
                                                                    id="c_aruun_2" class="selectgroup-input"
                                                                    {{ in_array('carun_2', $c_aru_array) ? 'checked' : '' }} />
                                                                <span class="selectgroup-button">NOK</span>
                                                            </label>
                                                            <label class="selectgroup-item mb-2 mb-sm-0">
                                                                <input type="checkbox" name="c_aru[]" value="carun_3"
                                                                    id="c_aruun_3" class="selectgroup-input"
                                                                    {{ in_array('carun_3', $c_aru_array) ? 'checked' : '' }} />
                                                                <span class="selectgroup-button">LOG</span>
                                                            </label>
                                                            <label class="selectgroup-item mb-2 mb-sm-0">
                                                                <input type="checkbox" name="c_aru[]" value="carun_4"
                                                                    id="c_aruun_4" class="selectgroup-input"
                                                                    {{ in_array('carun_4', $c_aru_array) ? 'checked' : '' }} />
                                                                <span class="selectgroup-button">SLD</span>
                                                            </label>
                                                            <label class="selectgroup-item mb-2 mb-sm-0">
                                                                <input type="checkbox" name="c_aru[]" value="carun_5"
                                                                    id="c_aruun_5" class="selectgroup-input"
                                                                    {{ in_array('carun_5', $c_aru_array) ? 'checked' : '' }} />
                                                                <span class="selectgroup-button">Tidak Uji</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <label class="form-label t-bold">RESET On</label>
                                                        <div class="selectgroup w-100 flex-wrap">
                                                            <label class="selectgroup-item mb-2 mb-sm-0">
                                                                <input type="checkbox" id="crst_on_checkAll_ok"
                                                                    class="selectgroup-input" />
                                                                <span class="selectgroup-button">Normal</span>
                                                            </label>
                                                            <label class="selectgroup-item mb-2 mb-sm-0">
                                                                <input type="checkbox" name="c_rst[]"
                                                                    value="rrctrl_on_1" id="crst_on_1"
                                                                    class="selectgroup-input"
                                                                    {{ in_array('rrctrl_on_1', $c_rst_array) ? 'checked' : '' }} />
                                                                <span class="selectgroup-button">OK</span>
                                                            </label>
                                                            <label class="selectgroup-item mb-2 mb-sm-0">
                                                                <input type="checkbox" name="c_rst[]"
                                                                    value="rrctrl_on_2" id="crst_on_2"
                                                                    class="selectgroup-input"
                                                                    {{ in_array('rrctrl_on_2', $c_rst_array) ? 'checked' : '' }} />
                                                                <span class="selectgroup-button">NOK</span>
                                                            </label>
                                                            <label class="selectgroup-item mb-2 mb-sm-0">
                                                                <input type="checkbox" name="c_rst[]"
                                                                    value="rrctrl_on_3" id="crst_on_3"
                                                                    class="selectgroup-input"
                                                                    {{ in_array('rrctrl_on_3', $c_rst_array) ? 'checked' : '' }} />
                                                                <span class="selectgroup-button">LOG</span>
                                                            </label>
                                                            <label class="selectgroup-item mb-2 mb-sm-0">
                                                                <input type="checkbox" name="c_rst[]"
                                                                    value="rrctrl_on_4" id="crst_on_4"
                                                                    class="selectgroup-input"
                                                                    {{ in_array('rrctrl_on_4', $c_rst_array) ? 'checked' : '' }} />
                                                                <span class="selectgroup-button">SLD</span>
                                                            </label>
                                                            <label class="selectgroup-item mb-2 mb-sm-0">
                                                                <input type="checkbox" name="c_rst[]"
                                                                    value="rrctrl_on_5" id="crst_on_5"
                                                                    class="selectgroup-input"
                                                                    {{ in_array('rrctrl_on_5', $c_rst_array) ? 'checked' : '' }} />
                                                                <span class="selectgroup-button">Tidak Uji</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <label class="form-label t-bold">TC Raiser</label>
                                                        <div class="selectgroup w-100 flex-wrap">
                                                            <label class="selectgroup-item mb-2 mb-sm-0">
                                                                <input type="checkbox" id="c_tc_raiser_checkAll"
                                                                    class="selectgroup-input" />
                                                                <span class="selectgroup-button">Normal</span>
                                                            </label>
                                                            <label class="selectgroup-item mb-2 mb-sm-0">
                                                                <input type="checkbox" name="c_tc[]" value="ctcr_1"
                                                                    id="c_tcrai_1" class="selectgroup-input"
                                                                    {{ in_array('ctcr_1', $c_tc_array) ? 'checked' : '' }} />
                                                                <span class="selectgroup-button">OK</span>
                                                            </label>
                                                            <label class="selectgroup-item mb-2 mb-sm-0">
                                                                <input type="checkbox" name="c_tc[]" value="ctcr_2"
                                                                    id="c_tcrai_2" class="selectgroup-input"
                                                                    {{ in_array('ctcr_2', $c_tc_array) ? 'checked' : '' }} />
                                                                <span class="selectgroup-button">NOK</span>
                                                            </label>
                                                            <label class="selectgroup-item mb-2 mb-sm-0">
                                                                <input type="checkbox" name="c_tc[]" value="ctcr_3"
                                                                    id="c_tcrai_3" class="selectgroup-input"
                                                                    {{ in_array('ctcr_3', $c_tc_array) ? 'checked' : '' }} />
                                                                <span class="selectgroup-button">LOG</span>
                                                            </label>
                                                            <label class="selectgroup-item mb-2 mb-sm-0">
                                                                <input type="checkbox" name="c_tc[]" value="ctcr_4"
                                                                    id="c_tcrai_4" class="selectgroup-input"
                                                                    {{ in_array('ctcr_4', $c_tc_array) ? 'checked' : '' }} />
                                                                <span class="selectgroup-button">SLD</span>
                                                            </label>
                                                            <label class="selectgroup-item mb-2 mb-sm-0">
                                                                <input type="checkbox" name="c_tc[]" value="ctcr_5"
                                                                    id="c_tcrai_5" class="selectgroup-input"
                                                                    {{ in_array('ctcr_5', $c_tc_array) ? 'checked' : '' }} />
                                                                <span class="selectgroup-button">Tidak Uji</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <label class="form-label t-bold">TC Lower</label>
                                                        <div class="selectgroup w-100 flex-wrap">
                                                            <label class="selectgroup-item mb-2 mb-sm-0">
                                                                <input type="checkbox" id="c_tc_lower_checkAll"
                                                                    class="selectgroup-input" />
                                                                <span class="selectgroup-button">Normal</span>
                                                            </label>
                                                            <label class="selectgroup-item mb-2 mb-sm-0">
                                                                <input type="checkbox" name="c_tc[]" value="ctcl_1"
                                                                    id="c_tclow_1" class="selectgroup-input"
                                                                    {{ in_array('ctcl_1', $c_tc_array) ? 'checked' : '' }} />
                                                                <span class="selectgroup-button">OK</span>
                                                            </label>
                                                            <label class="selectgroup-item mb-2 mb-sm-0">
                                                                <input type="checkbox" name="c_tc[]" value="ctcl_2"
                                                                    id="c_tclow_2" class="selectgroup-input"
                                                                    {{ in_array('ctcl_2', $c_tc_array) ? 'checked' : '' }} />
                                                                <span class="selectgroup-button">NOK</span>
                                                            </label>
                                                            <label class="selectgroup-item mb-2 mb-sm-0">
                                                                <input type="checkbox" name="c_tc[]" value="ctcl_3"
                                                                    id="c_tclow_3" class="selectgroup-input"
                                                                    {{ in_array('ctcl_3', $c_tc_array) ? 'checked' : '' }} />
                                                                <span class="selectgroup-button">LOG</span>
                                                            </label>
                                                            <label class="selectgroup-item mb-2 mb-sm-0">
                                                                <input type="checkbox" name="c_tc[]" value="ctcl_4"
                                                                    id="c_tclow_4" class="selectgroup-input"
                                                                    {{ in_array('ctcl_4', $c_tc_array) ? 'checked' : '' }} />
                                                                <span class="selectgroup-button">SLD</span>
                                                            </label>
                                                            <label class="selectgroup-item mb-2 mb-sm-0">
                                                                <input type="checkbox" name="c_tc[]" value="ctcl_5"
                                                                    id="c_tclow_5" class="selectgroup-input"
                                                                    {{ in_array('ctcl_5', $c_tc_array) ? 'checked' : '' }} />
                                                                <span class="selectgroup-button">Tidak Uji</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-3">
                                                <div class="form-group">
                                                    <label for="ccb_open_address">CB Open Address</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="ccb_open_address"
                                                            name="ccb_open_address" placeholder="CB Open Address"
                                                            value="{{ $penyulang->ccb_open_address ?? old('ccb_open_address') }}" />
                                                        @error('ccb_open_address')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="ccb_close_address">CB Close Address</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="ccb_close_address"
                                                            name="ccb_close_address" placeholder="CB Close Address"
                                                            value="{{ $penyulang->ccb_close_address ?? old('ccb_close_address') }}" />
                                                        @error('ccb_close_address')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="caru_use_address">ARU Use Address</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="caru_use_address"
                                                            name="caru_use_address" placeholder="ARU Use Address"
                                                            value="{{ $penyulang->caru_use_address ?? old('caru_use_address') }}" />
                                                        @error('caru_use_address')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="caru_unuse_address">ARU Unuse Address</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="caru_unuse_address"
                                                            name="caru_unuse_address" placeholder="ARU Unuse Address"
                                                            value="{{ $penyulang->caru_unuse_address ?? old('caru_unuse_address') }}" />
                                                        @error('caru_unuse_address')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="creset_on_address">Reset On Address</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="creset_on_address"
                                                            name="creset_on_address" placeholder="Reset On Address"
                                                            value="{{ $penyulang->creset_on_address ?? old('creset_on_address') }}" />
                                                        @error('creset_on_address')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="ctc_raiser_address">TC Raiser Address</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="ctc_raiser_address"
                                                            name="ctc_raiser_address" placeholder="TC Raiser Address"
                                                            value="{{ $penyulang->ctc_raiser_address ?? old('ctc_raiser_address') }}" />
                                                        @error('ctc_raiser_address')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="ctc_lower_address">TC Lower Address</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="ctc_lower_address"
                                                            name="ctc_lower_address" placeholder="TC Lower Address"
                                                            value="{{ $penyulang->ctc_lower_address ?? old('ctc_lower_address') }}" />
                                                        @error('ctc_lower_address')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-3">
                                                <div class="form-group">
                                                    <label for="ccb_open_objfrmt">CB Open OBJ/FRMT</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="ccb_open_objfrmt"
                                                            name="ccb_open_objfrmt" placeholder="CB Open OBJ/FRMT"
                                                            value="{{ $penyulang->ccb_open_objfrmt ?? old('ccb_open_objfrmt') }}" />
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
                                                            value="{{ $penyulang->ccb_close_objfrmt ?? old('ccb_close_objfrmt') }}" />
                                                        @error('ccb_close_objfrmt')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="caru_use_objfrmt">ARU Use OBJ/FRMT</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="caru_use_objfrmt"
                                                            name="caru_use_objfrmt" placeholder="ARU Use OBJ/FRMT"
                                                            value="{{ $penyulang->caru_use_objfrmt ?? old('caru_use_objfrmt') }}" />
                                                        @error('caru_use_objfrmt')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="caru_unuse_objfrmt">ARU Unuse OBJ/FRMT</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="caru_unuse_objfrmt"
                                                            name="caru_unuse_objfrmt" placeholder="ARU Unuse OBJ/FRMT"
                                                            value="{{ $penyulang->caru_unuse_objfrmt ?? old('caru_unuse_objfrmt') }}" />
                                                        @error('caru_unuse_objfrmt')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="creset_on_objfrmt">Reset On OBJ/FRMT</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="creset_on_objfrmt"
                                                            name="creset_on_objfrmt" placeholder="Reset On OBJ/FRMT"
                                                            value="{{ $penyulang->creset_on_objfrmt ?? old('creset_on_objfrmt') }}" />
                                                        @error('creset_on_objfrmt')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="ctc_raiser_objfrmt">TC Raiser OBJ/FRMT</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="ctc_raiser_objfrmt"
                                                            name="ctc_raiser_objfrmt" placeholder="TC Raiser OBJ/FRMT"
                                                            value="{{ $penyulang->ctc_raiser_objfrmt ?? old('ctc_raiser_objfrmt') }}" />
                                                        @error('ctc_raiser_objfrmt')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="ctc_lower_objfrmt">TC Lower OBJ/FRMT</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="ctc_lower_objfrmt"
                                                            name="ctc_lower_objfrmt" placeholder="TC Lower OBJ/FRMT"
                                                            value="{{ $penyulang->ctc_lower_objfrmt ?? old('ctc_lower_objfrmt') }}" />
                                                        @error('ctc_lower_objfrmt')
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
                                            <div class="col-md-3">
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
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Arus Gangguan Phase R</label>
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
                                                    <label>Arus Gangguan Phase S</label>
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
                                                    <label>Arus Gangguan Phase T</label>
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
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Arus Gangguan Phase N</label>
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
                                                <div class="form-group">
                                                    <label>Tegangan</label>
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
                                                <div class="custom-select-wrapper" id="ms-wrapper">
                                                    <div class="selected-items" id="selected-items-ms"></div>
                                                    <input type="hidden" id="id_pelms" name="id_pelms"
                                                        value="{{ old('id_pelms', implode(',', $selectedPelms)) }}">
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
                                                <label for="id_pelrtu" class="custom-label">Pelaksana RTU II</label>
                                                <div class="custom-select-wrapper" id="rtu-wrapper">
                                                    <div class="selected-items" id="selected-items-rtu"></div>
                                                    <input type="hidden" id="id_pelrtu" name="id_pelrtu"
                                                        value="{{ old('id_pelrtu', implode(',', $selectedPelrtus)) }}">
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
                                Update
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
@endsection
