@extends('layout.app')

@section('title', 'Tambah Data Penyulangan')

@section('content')
<div class="page-inner">
    <div class="page-header">
        <div class="section-header-back">
            <a href="{{ route('penyulangan.index') }}" class="btn"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h3 class="fw-bold">Tambah Data Penyulangan</h3>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Tambah Data Penyulangan</h4>
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
                    <form action="{{ route('penyulangan.store') }}" method="POST" autocomplete="off">
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
                                                    <label for="nama_peny">Nama Penyulangan</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="nama_peny"
                                                            name="nama_peny" placeholder="Nama Penyulangan"
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
                                                            {{ old('id_gi') == $gi->id_gi ? 'selected' : '' }}>
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
                                                <div class="form-group">
                                                    <label for="id_rtugi">Merk RTU</label>
                                                    <select class="form-select form-control" id="id_rtugi"
                                                        name="id_rtugi" required>
                                                        <option value="">Pilih Merk RTU</option>
                                                        @foreach ($rtugi as $merk)
                                                        <option value="{{ $merk->id_rtugi }}"
                                                            {{ old('id_rtugi') == $merk->id_rtugi ? 'selected' : '' }}>
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
                                            <div class="col-md-12">
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
                                                                        id="cb_open_1" class="selectgroup-input" />
                                                                    <span class="selectgroup-button">OK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_cb[]" value="open_2"
                                                                        id="cb_open_2" class="selectgroup-input" />
                                                                    <span class="selectgroup-button">NOK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_cb[]" value="open_3"
                                                                        id="cb_open_3" class="selectgroup-input" />
                                                                    <span class="selectgroup-button">LOG</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_cb[]" value="open_4"
                                                                        id="cb_open_4" class="selectgroup-input" />
                                                                    <span class="selectgroup-button">SLD</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_cb[]" value="open_5"
                                                                        id="cb_open_5" class="selectgroup-input" />
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
                                                                        id="cb_close_1" class="selectgroup-input" />
                                                                    <span class="selectgroup-button">OK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_cb[]" value="close_2"
                                                                        id="cb_close_2" class="selectgroup-input" />
                                                                    <span class="selectgroup-button">NOK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_cb[]" value="close_3"
                                                                        id="cb_close_3" class="selectgroup-input" />
                                                                    <span class="selectgroup-button">LOG</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_cb[]" value="close_4"
                                                                        id="cb_close_4" class="selectgroup-input" />
                                                                    <span class="selectgroup-button">SLD</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_cb[]" value="close_5"
                                                                        id="cb_close_5" class="selectgroup-input" />
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
                                                                        id="lr_local_1" class="selectgroup-input" />
                                                                    <span class="selectgroup-button">OK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_lr[]" value="local_2"
                                                                        id="lr_local_2" class="selectgroup-input" />
                                                                    <span class="selectgroup-button">NOK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_lr[]" value="local_3"
                                                                        id="lr_local_3" class="selectgroup-input" />
                                                                    <span class="selectgroup-button">LOG</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_lr[]" value="local_4"
                                                                        id="lr_local_4" class="selectgroup-input" />
                                                                    <span class="selectgroup-button">SLD</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_lr[]" value="local_5"
                                                                        id="lr_local_5" class="selectgroup-input" />
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
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">OK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_lr[]"
                                                                        value="remote_2" id="lr_remote_2"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">NOK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_lr[]"
                                                                        value="remote_3" id="lr_remote_3"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">LOG</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_lr[]"
                                                                        value="remote_4" id="lr_remote_4"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">SLD</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_lr[]"
                                                                        value="remote_5" id="lr_remote_5"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">Tidak Uji</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-1">
                                                            <label class="form-label t-bold">OCR Dis</label>
                                                        </div>
                                                        <div class="col-md-10">
                                                            <div class="selectgroup w-100">
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" id="s_ocr_dis_checkAll"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">Normal</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_ocr[]" value="ocrd_1"
                                                                        id="s_ocrd_1" class="selectgroup-input" />
                                                                    <span class="selectgroup-button">OK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_ocr[]" value="ocrd_2"
                                                                        id="s_ocrd_2" class="selectgroup-input" />
                                                                    <span class="selectgroup-button">NOK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_ocr[]" value="ocrd_3"
                                                                        id="s_ocrd_3" class="selectgroup-input" />
                                                                    <span class="selectgroup-button">LOG</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_ocr[]" value="ocrd_4"
                                                                        id="s_ocrd_4" class="selectgroup-input" />
                                                                    <span class="selectgroup-button">SLD</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_ocr[]" value="ocrd_5"
                                                                        id="s_ocrd_5" class="selectgroup-input" />
                                                                    <span class="selectgroup-button">Tidak Uji</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-1">
                                                            <label class="form-label t-bold">OCR App</label>
                                                        </div>
                                                        <div class="col-md-10">
                                                            <div class="selectgroup w-100">
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" id="s_ocr_app_checkAll"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">Normal</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_ocr[]" value="ocra_1"
                                                                        id="s_ocra_1" class="selectgroup-input" />
                                                                    <span class="selectgroup-button">OK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_ocr[]" value="ocra_2"
                                                                        id="s_ocra_2" class="selectgroup-input" />
                                                                    <span class="selectgroup-button">NOK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_ocr[]" value="ocra_3"
                                                                        id="s_ocra_3" class="selectgroup-input" />
                                                                    <span class="selectgroup-button">LOG</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_ocr[]" value="ocra_4"
                                                                        id="s_ocra_4" class="selectgroup-input" />
                                                                    <span class="selectgroup-button">SLD</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_ocr[]" value="ocra_5"
                                                                        id="s_ocra_5" class="selectgroup-input" />
                                                                    <span class="selectgroup-button">Tidak Uji</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-1">
                                                            <label class="form-label t-bold">OCRI Dis</label>
                                                        </div>
                                                        <div class="col-md-10">
                                                            <div class="selectgroup w-100">
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" id="s_ocri_dis_checkAll"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">Normal</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_ocri[]"
                                                                        value="ocrid_1" id="s_ocrid_1"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">OK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_ocri[]"
                                                                        value="ocrid_2" id="s_ocrid_2"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">NOK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_ocri[]"
                                                                        value="ocrid_3" id="s_ocrid_3"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">LOG</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_ocri[]"
                                                                        value="ocrid_4" id="s_ocrid_4"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">SLD</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_ocri[]"
                                                                        value="ocrid_5" id="s_ocrid_5"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">Tidak Uji</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-1">
                                                            <label class="form-label t-bold">OCRI App</label>
                                                        </div>
                                                        <div class="col-md-10">
                                                            <div class="selectgroup w-100">
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" id="s_ocri_app_checkAll"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">Normal</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_ocri[]"
                                                                        value="ocria_1" id="s_ocria_1"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">OK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_ocri[]"
                                                                        value="ocria_2" id="s_ocria_2"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">NOK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_ocri[]"
                                                                        value="ocria_3" id="s_ocria_3"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">LOG</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_ocri[]"
                                                                        value="ocria_4" id="s_ocria_4"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">SLD</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_ocri[]"
                                                                        value="ocria_5" id="s_ocria_5"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">Tidak Uji</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-1">
                                                            <label class="form-label t-bold">DGR Dis</label>
                                                        </div>
                                                        <div class="col-md-10">
                                                            <div class="selectgroup w-100">
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" id="s_dgr_dis_checkAll"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">Normal</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_dgr[]" value="dgrd_1"
                                                                        id="s_dgrd_1" class="selectgroup-input" />
                                                                    <span class="selectgroup-button">OK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_dgr[]" value="dgrd_2"
                                                                        id="s_dgrd_2" class="selectgroup-input" />
                                                                    <span class="selectgroup-button">NOK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_dgr[]" value="dgrd_3"
                                                                        id="s_dgrd_3" class="selectgroup-input" />
                                                                    <span class="selectgroup-button">LOG</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_dgr[]" value="dgrd_4"
                                                                        id="s_dgrd_4" class="selectgroup-input" />
                                                                    <span class="selectgroup-button">SLD</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_dgr[]" value="dgrd_5"
                                                                        id="s_dgrd_5" class="selectgroup-input" />
                                                                    <span class="selectgroup-button">Tidak Uji</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-1">
                                                            <label class="form-label t-bold">DGR App</label>
                                                        </div>
                                                        <div class="col-md-10">
                                                            <div class="selectgroup w-100">
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" id="s_dgr_app_checkAll"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">Normal</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_dgr[]" value="dgra_1"
                                                                        id="s_dgra_1" class="selectgroup-input" />
                                                                    <span class="selectgroup-button">OK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_dgr[]" value="dgra_2"
                                                                        id="s_dgra_2" class="selectgroup-input" />
                                                                    <span class="selectgroup-button">NOK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_dgr[]" value="dgra_3"
                                                                        id="s_dgra_3" class="selectgroup-input" />
                                                                    <span class="selectgroup-button">LOG</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_dgr[]" value="dgra_4"
                                                                        id="s_dgra_4" class="selectgroup-input" />
                                                                    <span class="selectgroup-button">SLD</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_dgr[]" value="dgra_5"
                                                                        id="s_dgra_5" class="selectgroup-input" />
                                                                    <span class="selectgroup-button">Tidak Uji</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-1">
                                                            <label class="form-label t-bold">CBTR Dis</label>
                                                        </div>
                                                        <div class="col-md-10">
                                                            <div class="selectgroup w-100">
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" id="s_cbtr_dis_checkAll"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">Normal</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_cbtr[]"
                                                                        value="cbtrd_1" id="s_cbtrd_1"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">OK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_cbtr[]"
                                                                        value="cbtrd_2" id="s_cbtrd_2"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">NOK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_cbtr[]"
                                                                        value="cbtrd_3" id="s_cbtrd_3"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">LOG</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_cbtr[]"
                                                                        value="cbtrd_4" id="s_cbtrd_4"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">SLD</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_cbtr[]"
                                                                        value="cbtrd_5" id="s_cbtrd_5"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">Tidak Uji</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-1">
                                                            <label class="form-label t-bold">CBTR App</label>
                                                        </div>
                                                        <div class="col-md-10">
                                                            <div class="selectgroup w-100">
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" id="s_cbtr_app_checkAll"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">Normal</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_cbtr[]"
                                                                        value="cbtra_1" id="s_cbtra_1"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">OK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_cbtr[]"
                                                                        value="cbtra_2" id="s_cbtra_2"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">NOK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_cbtr[]"
                                                                        value="cbtra_3" id="s_cbtra_3"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">LOG</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_cbtr[]"
                                                                        value="cbtra_4" id="s_cbtra_4"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">SLD</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_cbtr[]"
                                                                        value="cbtra_5" id="s_cbtra_5"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">Tidak Uji</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-1">
                                                            <label class="form-label t-bold">AR Dis</label>
                                                        </div>
                                                        <div class="col-md-10">
                                                            <div class="selectgroup w-100">
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" id="s_ar_dis_checkAll"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">Normal</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_ar[]" value="ard_1"
                                                                        id="s_ard_1" class="selectgroup-input" />
                                                                    <span class="selectgroup-button">OK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_ar[]" value="ard_2"
                                                                        id="s_ard_2" class="selectgroup-input" />
                                                                    <span class="selectgroup-button">NOK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_ar[]" value="ard_3"
                                                                        id="s_ard_3" class="selectgroup-input" />
                                                                    <span class="selectgroup-button">LOG</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_ar[]" value="ard_4"
                                                                        id="s_ard_4" class="selectgroup-input" />
                                                                    <span class="selectgroup-button">SLD</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_ar[]" value="ard_5"
                                                                        id="s_ard_5" class="selectgroup-input" />
                                                                    <span class="selectgroup-button">Tidak Uji</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-1">
                                                            <label class="form-label t-bold">AR App</label>
                                                        </div>
                                                        <div class="col-md-10">
                                                            <div class="selectgroup w-100">
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" id="s_ar_app_checkAll"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">Normal</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_ar[]" value="ara_1"
                                                                        id="s_ara_1" class="selectgroup-input" />
                                                                    <span class="selectgroup-button">OK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_ar[]" value="ara_2"
                                                                        id="s_ara_2" class="selectgroup-input" />
                                                                    <span class="selectgroup-button">NOK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_ar[]" value="ara_3"
                                                                        id="s_ara_3" class="selectgroup-input" />
                                                                    <span class="selectgroup-button">LOG</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_ar[]" value="ara_4"
                                                                        id="s_ara_4" class="selectgroup-input" />
                                                                    <span class="selectgroup-button">SLD</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_ar[]" value="ara_5"
                                                                        id="s_ara_5" class="selectgroup-input" />
                                                                    <span class="selectgroup-button">Tidak Uji</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-1">
                                                            <label class="form-label t-bold">ARU Dis</label>
                                                        </div>
                                                        <div class="col-md-10">
                                                            <div class="selectgroup w-100">
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" id="s_aru_dis_checkAll"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">Normal</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_aru[]" value="arud_1"
                                                                        id="s_arud_1" class="selectgroup-input" />
                                                                    <span class="selectgroup-button">OK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_aru[]" value="arud_2"
                                                                        id="s_arud_2" class="selectgroup-input" />
                                                                    <span class="selectgroup-button">NOK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_aru[]" value="arud_3"
                                                                        id="s_arud_3" class="selectgroup-input" />
                                                                    <span class="selectgroup-button">LOG</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_aru[]" value="arud_4"
                                                                        id="s_arud_4" class="selectgroup-input" />
                                                                    <span class="selectgroup-button">SLD</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_aru[]" value="arud_5"
                                                                        id="s_arud_5" class="selectgroup-input" />
                                                                    <span class="selectgroup-button">Tidak Uji</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-1">
                                                            <label class="form-label t-bold">ARU App</label>
                                                        </div>
                                                        <div class="col-md-10">
                                                            <div class="selectgroup w-100">
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" id="s_aru_app_checkAll"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">Normal</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_aru[]" value="arua_1"
                                                                        id="s_arua_1" class="selectgroup-input" />
                                                                    <span class="selectgroup-button">OK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_aru[]" value="arua_2"
                                                                        id="s_arua_2" class="selectgroup-input" />
                                                                    <span class="selectgroup-button">NOK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_aru[]" value="arua_3"
                                                                        id="s_arua_3" class="selectgroup-input" />
                                                                    <span class="selectgroup-button">LOG</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_aru[]" value="arua_4"
                                                                        id="s_arua_4" class="selectgroup-input" />
                                                                    <span class="selectgroup-button">SLD</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_aru[]" value="arua_5"
                                                                        id="s_arua_5" class="selectgroup-input" />
                                                                    <span class="selectgroup-button">Tidak Uji</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-1">
                                                            <label class="form-label t-bold">TC Dis</label>
                                                        </div>
                                                        <div class="col-md-10">
                                                            <div class="selectgroup w-100">
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" id="s_tc_dis_checkAll"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">Normal</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_tc[]" value="tcd_1"
                                                                        id="s_tcd_1" class="selectgroup-input" />
                                                                    <span class="selectgroup-button">OK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_tc[]" value="tcd_2"
                                                                        id="s_tcd_2" class="selectgroup-input" />
                                                                    <span class="selectgroup-button">NOK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_tc[]" value="tcd_3"
                                                                        id="s_tcd_3" class="selectgroup-input" />
                                                                    <span class="selectgroup-button">LOG</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_tc[]" value="tcd_4"
                                                                        id="s_tcd_4" class="selectgroup-input" />
                                                                    <span class="selectgroup-button">SLD</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_tc[]" value="tcd_5"
                                                                        id="s_tcd_5" class="selectgroup-input" />
                                                                    <span class="selectgroup-button">Tidak Uji</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-1">
                                                            <label class="form-label t-bold">TC App</label>
                                                        </div>
                                                        <div class="col-md-10">
                                                            <div class="selectgroup w-100">
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" id="s_tc_app_checkAll"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">Normal</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_tc[]" value="tca_1"
                                                                        id="s_tca_1" class="selectgroup-input" />
                                                                    <span class="selectgroup-button">OK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_tc[]" value="tca_2"
                                                                        id="s_tca_2" class="selectgroup-input" />
                                                                    <span class="selectgroup-button">NOK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_tc[]" value="tca_3"
                                                                        id="s_tca_3" class="selectgroup-input" />
                                                                    <span class="selectgroup-button">LOG</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_tc[]" value="tca_4"
                                                                        id="s_tca_4" class="selectgroup-input" />
                                                                    <span class="selectgroup-button">SLD</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="s_tc[]" value="tca_5"
                                                                        id="s_tca_5" class="selectgroup-input" />
                                                                    <span class="selectgroup-button">Tidak Uji</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Form Telecontrol Tab -->
                                    <div class="tab-pane fade" id="v-pills-formtelecontrol-nobd" role="tabpanel" +
                                        aria-labelledby="v-pills-formtelecontrol-tab-nobd">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-1">
                                                            <label class="form-label t-bold">CB Open</label>
                                                        </div>
                                                        <div class="col-md-10">
                                                            <div class="selectgroup w-100">
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="ccb_checkall_ok"
                                                                        value="cbctrl_op_checkall_ok"
                                                                        id="ccb_open_checkAll_ok"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">Normal</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="c_cb[]"
                                                                        value="cbctrl_op_1" id="ccb_open_1"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">OK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="c_cb[]"
                                                                        value="cbctrl_op_2" id="ccb_open_2"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">NOK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="c_cb[]"
                                                                        value="cbctrl_op_3" id="ccb_open_3"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">LOG</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="c_cb[]"
                                                                        value="cbctrl_op_4" id="ccb_open_4"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">SLD</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="c_cb[]"
                                                                        value="cbctrl_op_5" id="ccb_open_5"
                                                                        class="selectgroup-input" />
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
                                                                    <input type="checkbox" name="ccb_checkall_ok"
                                                                        value="cbctrl_cl_checkall_ok"
                                                                        id="ccb_close_checkAll_ok"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">Normal</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="c_cb[]"
                                                                        value="cbctrl_cl_1" id="ccb_close_1"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">OK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="c_cb[]"
                                                                        value="cbctrl_cl_2" id="ccb_close_2"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">NOK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="c_cb[]"
                                                                        value="cbctrl_cl_3" id="ccb_close_3"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">LOG</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="c_cb[]"
                                                                        value="cbctrl_cl_4" id="ccb_close_4"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">SLD</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="c_cb[]"
                                                                        value="cbctrl_cl_5" id="ccb_close_5"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">TDK UJI</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-1">
                                                            <label class="form-label t-bold">ARU Use</label>
                                                        </div>
                                                        <div class="col-md-10">
                                                            <div class="selectgroup w-100">
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" id="c_aru_use_checkAll"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">Normal</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="c_aru[]" value="caru_1"
                                                                        id="c_aruu_1" class="selectgroup-input" />
                                                                    <span class="selectgroup-button">OK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="c_aru[]" value="caru_2"
                                                                        id="c_aruu_2" class="selectgroup-input" />
                                                                    <span class="selectgroup-button">NOK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="c_aru[]" value="caru_3"
                                                                        id="c_aruu_3" class="selectgroup-input" />
                                                                    <span class="selectgroup-button">LOG</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="c_aru[]" value="caru_4"
                                                                        id="c_aruu_4" class="selectgroup-input" />
                                                                    <span class="selectgroup-button">SLD</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="c_aru[]" value="caru_5"
                                                                        id="c_aruu_5" class="selectgroup-input" />
                                                                    <span class="selectgroup-button">Tidak Uji</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-1">
                                                            <label class="form-label t-bold">ARU Unuse</label>
                                                        </div>
                                                        <div class="col-md-10">
                                                            <div class="selectgroup w-100">
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" id="c_aru_unuse_checkAll"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">Normal</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="c_aru[]"
                                                                        value="carun_1" id="c_aruun_1"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">OK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="c_aru[]"
                                                                        value="carun_2" id="c_aruun_2"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">NOK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="c_aru[]"
                                                                        value="carun_3" id="c_aruun_3"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">LOG</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="c_aru[]"
                                                                        value="carun_4" id="c_aruun_4"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">SLD</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="c_aru[]"
                                                                        value="carun_5" id="c_aruun_5"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">Tidak Uji</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-1">
                                                            <label class="form-label t-bold">RESET On</label>
                                                        </div>
                                                        <div class="col-md-10">
                                                            <div class="selectgroup w-100">
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" id="c_reset_on_checkAll"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">Normal</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="c_reset_on[]"
                                                                        value="rrctrl_on_1" id="c_rrctrl_on_1"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">OK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="c_reset_on[]"
                                                                        value="rrctrl_on_2" id="c_rrctrl_on_2"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">NOK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="c_reset_on[]"
                                                                        value="rrctrl_on_3" id="c_rrctrl_on_3"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">LOG</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="c_reset_on[]"
                                                                        value="rrctrl_on_4" id="c_rrctrl_on_4"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">SLD</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="c_reset_on[]"
                                                                        value="rrctrl_on_5" id="c_rrctrl_on_5"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">Tidak Uji</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-1">
                                                            <label class="form-label t-bold">TC Raiser</label>
                                                        </div>
                                                        <div class="col-md-10">
                                                            <div class="selectgroup w-100">
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" id="c_tc_raiser_checkAll"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">Normal</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="c_tc_raiser[]"
                                                                        value="ctcr_1" id="c_tcrai_1"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">OK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="c_tc_raiser[]"
                                                                        value="ctcr_2" id="c_tcrai_2"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">NOK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="c_tc_raiser[]"
                                                                        value="ctcr_3" id="c_tcrai_3"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">LOG</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="c_tc_raiser[]"
                                                                        value="ctcr_4" id="c_tcrai_4"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">SLD</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="c_tc_raiser[]"
                                                                        value="ctcr_5" id="c_tcrai_5"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">Tidak Uji</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-1">
                                                            <label class="form-label t-bold">TC Lower</label>
                                                        </div>
                                                        <div class="col-md-10">
                                                            <div class="selectgroup w-100">
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" id="c_tc_lower_checkAll"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">Normal</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="c_tc_lower[]"
                                                                        value="ctcl_1" id="c_tclow_1"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">OK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="c_tc_lower[]"
                                                                        value="ctcl_2" id="c_tclow_2"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">NOK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="c_tc_lower[]"
                                                                        value="ctcl_3" id="c_tclow_3"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">LOG</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="c_tc_lower[]"
                                                                        value="ctcl_4" id="c_tclow_4"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">SLD</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="c_tc_lower[]"
                                                                        value="ctcl_5" id="c_tclow_5"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">Tidak Uji</span>
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
                                                <div class="form-group">
                                                    <label>Daya (P)</label>
                                                    <input class="form-control @error('p_rtu') is-invalid @enderror"
                                                        placeholder="P RTU" name="p_rtu" value="{{ old('p_rtu') }}">
                                                    @error('p_rtu')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                    <input class="form-control @error('p_ms') is-invalid @enderror"
                                                        placeholder="P Master" name="p_ms" value="{{ old('p_ms') }}">
                                                    @error('p_ms')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                    <input class="form-control @error('p_scale') is-invalid @enderror"
                                                        placeholder="Scale" name="p_scale" value="{{ old('p_scale') }}">
                                                    @error('p_scale')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label>Tegangan</label>
                                                    <input class="form-control @error('v_rtu') is-invalid @enderror"
                                                        placeholder="V RTU" name="v_rtu" value="{{ old('v_rtu') }}">
                                                    @error('v_rtu')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                    <input class="form-control @error('v_ms') is-invalid @enderror"
                                                        placeholder="V Master" name="v_ms" value="{{ old('v_ms') }}">
                                                    @error('v_ms')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                    <input class="form-control @error('v_scale') is-invalid @enderror"
                                                        placeholder="Scale" name="v_scale" value="{{ old('v_scale') }}">
                                                    @error('v_scale')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Arus Gangguan Phase R</label>
                                                    <input class="form-control @error('fir_rtu') is-invalid @enderror"
                                                        placeholder="FIR RTU" name="fir_rtu"
                                                        value="{{ old('fir_rtu') }}">
                                                    @error('fir_rtu')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                    <input class="form-control @error('fir_ms') is-invalid @enderror"
                                                        placeholder="FIR Master" name="fir_ms"
                                                        value="{{ old('fir_ms') }}">
                                                    @error('fir_ms')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                    <input class="form-control @error('fir_scale') is-invalid @enderror"
                                                        placeholder="Scale" name="fir_scale"
                                                        value="{{ old('fir_scale') }}">
                                                    @error('fir_scale')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label>Arus Gangguan Phase S</label>
                                                    <input class="form-control @error('fis_rtu') is-invalid @enderror"
                                                        placeholder="FIS RTU" name="fis_rtu"
                                                        value="{{ old('fis_rtu') }}">
                                                    @error('fis_rtu')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                    <input class="form-control @error('fis_ms') is-invalid @enderror"
                                                        placeholder="FIS Master" name="fis_ms"
                                                        value="{{ old('fis_ms') }}">
                                                    @error('fis_ms')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                    <input class="form-control @error('fis_scale') is-invalid @enderror"
                                                        placeholder="Scale" name="fis_scale"
                                                        value="{{ old('fis_scale') }}">
                                                    @error('fis_scale')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label>Arus Gangguan Phase T</label>
                                                    <input class="form-control @error('fit_rtu') is-invalid @enderror"
                                                        placeholder="FIT RTU" name="fit_rtu"
                                                        value="{{ old('fit_rtu') }}">
                                                    @error('fit_rtu')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                    <input class="form-control @error('fit_ms') is-invalid @enderror"
                                                        placeholder="FIT Master" name="fit_ms"
                                                        value="{{ old('fit_ms') }}">
                                                    @error('fit_ms')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                    <input class="form-control @error('fit_scale') is-invalid @enderror"
                                                        placeholder="Scale" name="fit_scale"
                                                        value="{{ old('fit_scale') }}">
                                                    @error('fit_scale')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label>Arus Gangguan Phase N</label>
                                                    <input class="form-control @error('fin_rtu') is-invalid @enderror"
                                                        placeholder="FIN RTU" name="fin_rtu"
                                                        value="{{ old('fin_rtu') }}">
                                                    @error('fin_rtu')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                    <input class="form-control @error('fin_ms') is-invalid @enderror"
                                                        placeholder="FIN Master" name="fin_ms"
                                                        value="{{ old('fin_ms') }}">
                                                    @error('fin_ms')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                    <input class="form-control @error('fin_scale') is-invalid @enderror"
                                                        placeholder="Scale" name="fin_scale"
                                                        value="{{ old('fin_scale') }}">
                                                    @error('fin_scale')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label>Frekuensi</label>
                                                    <input class="form-control @error('f_rtu') is-invalid @enderror"
                                                        placeholder="F RTU" name="f_rtu" value="{{ old('f_rtu') }}">
                                                    @error('f_rtu')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                    <input class="form-control @error('f_ms') is-invalid @enderror"
                                                        placeholder="F Master" name="f_ms" value="{{ old('f_ms') }}">
                                                    @error('f_ms')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                    <input class="form-control @error('f_scale') is-invalid @enderror"
                                                        placeholder="Scale" name="f_scale" value="{{ old('f_scale') }}">
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
                                                @foreach ($kompeny as $kom)
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
                                                <label for="id_picms" class="custom-label">Pelaksana Master II</label>
                                                <div class="custom-select-wrapper">
                                                    <div class="selected-items" id="selected-items"></div>
                                                    <input type="hidden" id="id_picms" name="id_picms"
                                                        value="{{ old('id_picms', implode(',', $selectedPicms ?? [])) }}">
                                                    <div class="dropdown" id="dropdown-options">
                                                        @foreach ($pelms as $item)
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
                            <a href="{{ route('penyulangan.index') }}" class="btn btn-danger">Cancel</a>
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
