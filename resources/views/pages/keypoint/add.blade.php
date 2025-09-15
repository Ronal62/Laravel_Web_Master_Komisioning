@extends('layout.app')

@section('title', 'Dashboard')

@section('content')
<div class="page-inner">
    <div class="page-header">
        <h3 class="fw-bold">Tambah Data Keypoint</h3>
        <ul class="breadcrumbs mb-3">
            <li class="nav-home">
                <a href="#">
                    <i class="icon-home"></i>
                </a>
            </li>
            <li class="separator">
                <i class="icon-arrow-right"></i>
            </li>
            <li class="nav-item">
                <a href="#">Base</a>
            </li>
            <li class="separator">
                <i class="icon-arrow-right"></i>
            </li>
            <li class="nav-item">
                <a href="#">Tambah Data Keypoint</a>
            </li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Tambah Data Keypoint</h4>
                </div>
                <div class="card-body">
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
                            <form action="{{ route('keypoint.store') }}" method="POST">
                                @csrf
                                <div class="tab-content" id="v-pills-without-border-tabContent">
                                    <!-- Form Data Tab -->
                                    <div class="tab-pane fade show active" id="v-pills-formdata-nobd" role="tabpanel"
                                        aria-labelledby="v-pills-formdata-tab-nobd">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="tanggalkomisioning">Tanggal Komisioning</label>
                                                    <div class="input-icon">
                                                        <input type="date" class="form-control" id="tanggalkomisioning"
                                                            name="tanggal_komisioning" required />
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="namakeypoint">Nama Keypoint</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="namakeypoint"
                                                            name="nama_keypoint" placeholder="Nama Keypoint" required />
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="merkrtu">Merk RTU</label>
                                                    <select class="form-select form-control" id="merkrtu"
                                                        name="merk_rtu">
                                                        <option value="1">Option 1</option>
                                                        <option value="2">Option 2</option>
                                                        <option value="3">Option 3</option>
                                                        <option value="4">Option 4</option>
                                                        <option value="5">Option 5</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="merkmodem">Merk Modem</label>
                                                    <select class="form-select form-control" id="merkmodem"
                                                        name="merk_modem">
                                                        <option value="1">Option 1</option>
                                                        <option value="2">Option 2</option>
                                                        <option value="3">Option 3</option>
                                                        <option value="4">Option 4</option>
                                                        <option value="5">Option 5</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="protocolrtuaddress">Protocol /RTU Address</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="protocolrtuaddress"
                                                            name="protocol_rtu_address"
                                                            placeholder="Protocol /RTU Address" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="mediakomunikasi">Media Komunikasi</label>
                                                    <select class="form-select form-control" id="mediakomunikasi"
                                                        name="media_komunikasi">
                                                        <option value="1">Option 1</option>
                                                        <option value="2">Option 2</option>
                                                        <option value="3">Option 3</option>
                                                        <option value="4">Option 4</option>
                                                        <option value="5">Option 5</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="ipaddress">IP Address/No.Kartu</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="ipaddress"
                                                            name="ip_address" placeholder="IP Address/No.Kartu" />
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="garduinduk">Gardu Induk</label>
                                                    <select class="form-select form-control" id="garduinduk"
                                                        name="gardu_induk">
                                                        <option value="1">Option 1</option>
                                                        <option value="2">Option 2</option>
                                                        <option value="3">Option 3</option>
                                                        <option value="4">Option 4</option>
                                                        <option value="5">Option 5</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="penyulang">Penyulang</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="penyulang"
                                                            name="penyulang" placeholder="Penyulang" />
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="sectoral">Sectoral</label>
                                                    <select class="form-select form-control" id="sectoral"
                                                        name="sectoral">
                                                        <option value="1">Option 1</option>
                                                        <option value="2">Option 2</option>
                                                        <option value="3">Option 3</option>
                                                        <option value="4">Option 4</option>
                                                        <option value="5">Option 5</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="comment_formdata">Keterangan</label>
                                                <textarea class="form-control" id="comment_formdata"
                                                    name="comment_formdata" rows="5"
                                                    placeholder="Masukkan keterangan Anda"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Form Telestatus Tab -->
                                    <div class="tab-pane fade" id="v-pills-formtelestatus-nobd" role="tabpanel"
                                        aria-labelledby="v-pills-formtelestatus-tab-nobd">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <!-- CB Open -->
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-1">
                                                            <label class="form-label t-bold">CB Open</label>
                                                        </div>
                                                        <div class="col-md-10">
                                                            <div class="selectgroup w-100">
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="1"
                                                                        class="selectgroup-input" id="selectAll" />
                                                                    <span class="selectgroup-button">Normal</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="2"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">OK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="3"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">NOK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="4"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">LOG</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="5"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">SLD</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="6"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">Tidak Uji</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- CB Close -->
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-1">
                                                            <label class="form-label t-bold">CB Close</label>
                                                        </div>
                                                        <div class="col-md-10">
                                                            <div class="selectgroup w-100">
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="1"
                                                                        class="selectgroup-input" id="selectAll" />
                                                                    <span class="selectgroup-button">Normal</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="2"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">OK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="3"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">NOK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="4"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">LOG</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="5"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">SLD</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="6"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">Tidak Uji</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- CB 2 Open -->
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-1">
                                                            <label class="form-label t-bold">CB 2 Open</label>
                                                        </div>
                                                        <div class="col-md-10">
                                                            <div class="selectgroup w-100">
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="1"
                                                                        class="selectgroup-input" id="selectAll" />
                                                                    <span class="selectgroup-button">Normal</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="2"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">OK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="3"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">NOK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="4"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">LOG</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="5"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">SLD</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="6"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">Tidak Uji</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- CB 2 Close -->
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-1">
                                                            <label class="form-label t-bold">CB 2 Close</label>
                                                        </div>
                                                        <div class="col-md-10">
                                                            <div class="selectgroup w-100">
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="1"
                                                                        class="selectgroup-input" id="selectAll" />
                                                                    <span class="selectgroup-button">Normal</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="2"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">OK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="3"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">NOK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="4"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">LOG</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="5"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">SLD</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="6"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">Tidak Uji</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Local -->
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-1">
                                                            <label class="form-label t-bold">Local</label>
                                                        </div>
                                                        <div class="col-md-10">
                                                            <div class="selectgroup w-100">
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="1"
                                                                        class="selectgroup-input" id="selectAll" />
                                                                    <span class="selectgroup-button">Normal</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="2"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">OK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="3"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">NOK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="4"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">LOG</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="5"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">SLD</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="6"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">Tidak Uji</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Remote -->
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-1">
                                                            <label class="form-label t-bold">Remote</label>
                                                        </div>
                                                        <div class="col-md-10">
                                                            <div class="selectgroup w-100">
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="1"
                                                                        class="selectgroup-input" id="selectAll" />
                                                                    <span class="selectgroup-button">Normal</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="2"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">OK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="3"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">NOK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="4"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">LOG</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="5"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">SLD</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="6"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">Tidak Uji</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Door Open -->
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-1">
                                                            <label class="form-label t-bold">Door Open</label>
                                                        </div>
                                                        <div class="col-md-10">
                                                            <div class="selectgroup w-100">
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="1"
                                                                        class="selectgroup-input" id="selectAll" />
                                                                    <span class="selectgroup-button">Normal</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="2"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">OK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="3"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">NOK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="4"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">LOG</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="5"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">SLD</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="6"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">Tidak Uji</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Door Close -->
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-1">
                                                            <label class="form-label t-bold">Door Close</label>
                                                        </div>
                                                        <div class="col-md-10">
                                                            <div class="selectgroup w-100">
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="1"
                                                                        class="selectgroup-input" id="selectAll" />
                                                                    <span class="selectgroup-button">Normal</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="2"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">OK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="3"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">NOK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="4"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">LOG</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="5"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">SLD</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="6"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">Tidak Uji</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- ACF Normal -->
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-1">
                                                            <label class="form-label t-bold">ACF Normal</label>
                                                        </div>
                                                        <div class="col-md-10">
                                                            <div class="selectgroup w-100">
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="1"
                                                                        class="selectgroup-input" id="selectAll" />
                                                                    <span class="selectgroup-button">Normal</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="2"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">OK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="3"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">NOK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="4"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">LOG</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="5"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">SLD</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="6"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">Tidak Uji</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- ACF Failed -->
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-1">
                                                            <label class="form-label t-bold">ACF Failed</label>
                                                        </div>
                                                        <div class="col-md-10">
                                                            <div class="selectgroup w-100">
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="1"
                                                                        class="selectgroup-input" id="selectAll" />
                                                                    <span class="selectgroup-button">Normal</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="2"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">OK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="3"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">NOK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="4"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">LOG</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="5"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">SLD</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="6"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">Tidak Uji</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- DCD Normal -->
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-1">
                                                            <label class="form-label t-bold">DCD Normal</label>
                                                        </div>
                                                        <div class="col-md-10">
                                                            <div class="selectgroup w-100">
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="1"
                                                                        class="selectgroup-input" id="selectAll" />
                                                                    <span class="selectgroup-button">Normal</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="2"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">OK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="3"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">NOK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="4"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">LOG</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="5"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">SLD</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="6"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">Tidak Uji</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- DCD Failed -->
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-1">
                                                            <label class="form-label t-bold">DCD Failed</label>
                                                        </div>
                                                        <div class="col-md-10">
                                                            <div class="selectgroup w-100">
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="1"
                                                                        class="selectgroup-input" id="selectAll" />
                                                                    <span class="selectgroup-button">Normal</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="2"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">OK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="3"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">NOK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="4"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">LOG</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="5"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">SLD</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="6"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">Tidak Uji</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- DCF Normal -->
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-1">
                                                            <label class="form-label t-bold">DCF Normal</label>
                                                        </div>
                                                        <div class="col-md-10">
                                                            <div class="selectgroup w-100">
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="1"
                                                                        class="selectgroup-input" id="selectAll" />
                                                                    <span class="selectgroup-button">Normal</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="2"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">OK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="3"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">NOK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="4"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">LOG</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="5"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">SLD</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="6"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">Tidak Uji</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- DCF Failed -->
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-1">
                                                            <label class="form-label t-bold">DCF Failed</label>
                                                        </div>
                                                        <div class="col-md-10">
                                                            <div class="selectgroup w-100">
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="1"
                                                                        class="selectgroup-input" id="selectAll" />
                                                                    <span class="selectgroup-button">Normal</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="2"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">OK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="3"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">NOK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="4"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">LOG</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="5"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">SLD</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="6"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">Tidak Uji</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- HLT OFF -->
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-1">
                                                            <label class="form-label t-bold">HLT OFF</label>
                                                        </div>
                                                        <div class="col-md-10">
                                                            <div class="selectgroup w-100">
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="1"
                                                                        class="selectgroup-input" id="selectAll" />
                                                                    <span class="selectgroup-button">Normal</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="2"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">OK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="3"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">NOK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="4"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">LOG</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="5"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">SLD</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="6"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">Tidak Uji</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- HLT ON -->
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-1">
                                                            <label class="form-label t-bold">HLT ON</label>
                                                        </div>
                                                        <div class="col-md-10">
                                                            <div class="selectgroup w-100">
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="1"
                                                                        class="selectgroup-input" id="selectAll" />
                                                                    <span class="selectgroup-button">Normal</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="2"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">OK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="3"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">NOK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="4"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">LOG</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="5"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">SLD</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="6"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">Tidak Uji</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- SF6 Normal -->
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-1">
                                                            <label class="form-label t-bold">SF6 Normal</label>
                                                        </div>
                                                        <div class="col-md-10">
                                                            <div class="selectgroup w-100">
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="1"
                                                                        class="selectgroup-input" id="selectAll" />
                                                                    <span class="selectgroup-button">Normal</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="2"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">OK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="3"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">NOK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="4"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">LOG</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="5"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">SLD</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="6"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">Tidak Uji</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- SF6 Failed -->
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-1">
                                                            <label class="form-label t-bold">SF6 Failed</label>
                                                        </div>
                                                        <div class="col-md-10">
                                                            <div class="selectgroup w-100">
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="1"
                                                                        class="selectgroup-input" id="selectAll" />
                                                                    <span class="selectgroup-button">Normal</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="2"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">OK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="3"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">NOK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="4"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">LOG</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="5"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">SLD</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="6"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">Tidak Uji</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- FIR Normal -->
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-1">
                                                            <label class="form-label t-bold">FIR Normal</label>
                                                        </div>
                                                        <div class="col-md-10">
                                                            <div class="selectgroup w-100">
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="1"
                                                                        class="selectgroup-input" id="selectAll" />
                                                                    <span class="selectgroup-button">Normal</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="2"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">OK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="3"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">NOK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="4"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">LOG</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="5"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">SLD</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="6"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">Tidak Uji</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- FIR Failed -->
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-1">
                                                            <label class="form-label t-bold">FIR Failed</label>
                                                        </div>
                                                        <div class="col-md-10">
                                                            <div class="selectgroup w-100">
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="1"
                                                                        class="selectgroup-input" id="selectAll" />
                                                                    <span class="selectgroup-button">Normal</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="2"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">OK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="3"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">NOK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="4"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">LOG</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="5"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">SLD</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="6"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">Tidak Uji</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- FIS Normal -->
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-1">
                                                            <label class="form-label t-bold">FIS Normal</label>
                                                        </div>
                                                        <div class="col-md-10">
                                                            <div class="selectgroup w-100">
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="1"
                                                                        class="selectgroup-input" id="selectAll" />
                                                                    <span class="selectgroup-button">Normal</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="2"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">OK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="3"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">NOK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="4"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">LOG</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="5"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">SLD</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="6"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">Tidak Uji</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- FIS Failed -->
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-1">
                                                            <label class="form-label t-bold">FIS Failed</label>
                                                        </div>
                                                        <div class="col-md-10">
                                                            <div class="selectgroup w-100">
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="1"
                                                                        class="selectgroup-input" id="selectAll" />
                                                                    <span class="selectgroup-button">Normal</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="2"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">OK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="3"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">NOK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="4"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">LOG</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="5"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">SLD</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="6"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">Tidak Uji</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- FIT Normal -->
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-1">
                                                            <label class="form-label t-bold">FIT Normal</label>
                                                        </div>
                                                        <div class="col-md-10">
                                                            <div class="selectgroup w-100">
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="1"
                                                                        class="selectgroup-input" id="selectAll" />
                                                                    <span class="selectgroup-button">Normal</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="2"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">OK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="3"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">NOK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="4"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">LOG</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="5"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">SLD</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="6"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">Tidak Uji</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- FIT Failed -->
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-1">
                                                            <label class="form-label t-bold">FIT Failed</label>
                                                        </div>
                                                        <div class="col-md-10">
                                                            <div class="selectgroup w-100">
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="1"
                                                                        class="selectgroup-input" id="selectAll" />
                                                                    <span class="selectgroup-button">Normal</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="2"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">OK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="3"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">NOK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="4"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">LOG</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="5"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">SLD</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="6"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">Tidak Uji</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- FIN Normal -->
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-1">
                                                            <label class="form-label t-bold">FIN Normal</label>
                                                        </div>
                                                        <div class="col-md-10">
                                                            <div class="selectgroup w-100">
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="1"
                                                                        class="selectgroup-input" id="selectAll" />
                                                                    <span class="selectgroup-button">Normal</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="2"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">OK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="3"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">NOK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="4"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">LOG</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="5"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">SLD</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="6"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">Tidak Uji</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- FIN Failed -->
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-1">
                                                            <label class="form-label t-bold">FIN Failed</label>
                                                        </div>
                                                        <div class="col-md-10">
                                                            <div class="selectgroup w-100">
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="1"
                                                                        class="selectgroup-input" id="selectAll" />
                                                                    <span class="selectgroup-button">Normal</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="2"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">OK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="3"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">NOK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="4"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">LOG</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="5"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">SLD</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="6"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">Tidak Uji</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- COMF Normal -->
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-1">
                                                            <label class="form-label t-bold">COMF Normal</label>
                                                        </div>
                                                        <div class="col-md-10">
                                                            <div class="selectgroup w-100">
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="2"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">OK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="3"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">NOK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="6"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">Tidak Ada</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- LRUFNormal -->
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-1">
                                                            <label class="form-label t-bold">LRUFNormal</label>
                                                        </div>
                                                        <div class="col-md-10">
                                                            <div class="selectgroup w-100">
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="2"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">OK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="3"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">NOK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="6"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">Tidak Ada</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="comment_formdata">Keterangan</label>
                                                <textarea class="form-control" id="comment_formdata"
                                                    name="comment_formdata" rows="5"
                                                    placeholder="Masukkan keterangan Anda"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Form Telecontrol Tab -->
                                    <div class="tab-pane fade" id="v-pills-formtelecontrol-nobd" role="tabpanel"
                                        aria-labelledby="v-pills-formtelecontrol-tab-nobd">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <!-- CB Open -->
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-1">
                                                            <label class="form-label t-bold">CB Open</label>
                                                        </div>
                                                        <div class="col-md-10">
                                                            <div class="selectgroup w-100">
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="1"
                                                                        class="selectgroup-input" id="selectAll" />
                                                                    <span class="selectgroup-button">Normal</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="2"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">OK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="3"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">NOK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="4"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">LOG</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="5"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">SLD</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="6"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">Tidak Uji</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- CB Close -->
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-1">
                                                            <label class="form-label t-bold">CB Close</label>
                                                        </div>
                                                        <div class="col-md-10">
                                                            <div class="selectgroup w-100">
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="1"
                                                                        class="selectgroup-input" id="selectAll" />
                                                                    <span class="selectgroup-button">Normal</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="2"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">OK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="3"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">NOK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="4"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">LOG</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="5"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">SLD</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="6"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">Tidak Uji</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- CB 2 Open -->
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-1">
                                                            <label class="form-label t-bold">CB 2 Open</label>
                                                        </div>
                                                        <div class="col-md-10">
                                                            <div class="selectgroup w-100">
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="1"
                                                                        class="selectgroup-input" id="selectAll" />
                                                                    <span class="selectgroup-button">Normal</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="2"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">OK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="3"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">NOK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="4"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">LOG</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="5"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">SLD</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="6"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">Tidak Uji</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- CB 2 Close -->
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-1">
                                                            <label class="form-label t-bold">CB 2 Close</label>
                                                        </div>
                                                        <div class="col-md-10">
                                                            <div class="selectgroup w-100">
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="1"
                                                                        class="selectgroup-input" id="selectAll" />
                                                                    <span class="selectgroup-button">Normal</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="2"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">OK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="3"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">NOK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="4"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">LOG</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="5"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">SLD</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="6"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">Tidak Uji</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- HLT OFF -->
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-1">
                                                            <label class="form-label t-bold">HLT OFF</label>
                                                        </div>
                                                        <div class="col-md-10">
                                                            <div class="selectgroup w-100">
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="1"
                                                                        class="selectgroup-input" id="selectAll" />
                                                                    <span class="selectgroup-button">Normal</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="2"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">OK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="3"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">NOK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="4"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">LOG</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="5"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">SLD</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="6"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">Tidak Uji</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- HLT ON -->
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-1">
                                                            <label class="form-label t-bold">HLT ON</label>
                                                        </div>
                                                        <div class="col-md-10">
                                                            <div class="selectgroup w-100">
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="1"
                                                                        class="selectgroup-input" id="selectAll" />
                                                                    <span class="selectgroup-button">Normal</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="2"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">OK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="3"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">NOK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="4"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">LOG</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="5"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">SLD</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="6"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">Tidak Uji</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Reset -->
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-1">
                                                            <label class="form-label t-bold">Reset</label>
                                                        </div>
                                                        <div class="col-md-10">
                                                            <div class="selectgroup w-100">
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="1"
                                                                        class="selectgroup-input" id="selectAll" />
                                                                    <span class="selectgroup-button">Normal</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="2"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">OK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="3"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">NOK</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="4"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">LOG</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="5"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">SLD</span>
                                                                </label>
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="item" value="6"
                                                                        class="selectgroup-input" />
                                                                    <span class="selectgroup-button">Tidak Uji</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="comment_formdata">Keterangan</label>
                                                <textarea class="form-control" id="comment_formdata"
                                                    name="comment_formdata" rows="5"
                                                    placeholder="Masukkan keterangan Anda"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Form Telemetering Tab -->
                                    <div class="tab-pane fade" id="v-pills-formtelemetering-nobd" role="tabpanel"
                                        aria-labelledby="v-pills-formtelemetering-tab-nobd">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="arusphaser">Arus Phase R</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control mb-2" id="namakeypoint"
                                                            name="ir_rtu" placeholder="Enter IR RTU" required />
                                                    </div>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control mb-2 " id="namakeypoint"
                                                            name="ir_master" placeholder="Enter IR Master" required />
                                                    </div>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control mb-2" id="namakeypoint"
                                                            name="scale" placeholder="Enter Scale" required />
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="arusphaser">Arus Phase S</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control mb-2" id="namakeypoint"
                                                            name="ir_rtu" placeholder="Enter IS RTU" required />
                                                    </div>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control mb-2 " id="namakeypoint"
                                                            name="ir_master" placeholder="Enter IS Master" required />
                                                    </div>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control mb-2" id="namakeypoint"
                                                            name="scale" placeholder="Enter Scale" required />
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="arusphaser">Arus Phase T</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control mb-2" id="namakeypoint"
                                                            name="ir_rtu" placeholder="Enter IT RTU" required />
                                                    </div>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control mb-2 " id="namakeypoint"
                                                            name="ir_master" placeholder="Enter IT Master" required />
                                                    </div>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control mb-2" id="namakeypoint"
                                                            name="scale" placeholder="Enter Scale" required />
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="protocolrtuaddress">Sign Strength</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="protocolrtuaddress"
                                                            name="protocol_rtu_address" placeholder="30db" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="arusphaser">Teg Phase R</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control mb-2" id="namakeypoint"
                                                            name="ir_rtu" placeholder="Enter VR RTU" required />
                                                    </div>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control mb-2 " id="namakeypoint"
                                                            name="ir_master" placeholder="Enter VR Master" required />
                                                    </div>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control mb-2" id="namakeypoint"
                                                            name="scale" placeholder="Enter Scale" required />
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="arusphaser">Teg Phase S</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control mb-2" id="namakeypoint"
                                                            name="ir_rtu" placeholder="Enter VS RTU" required />
                                                    </div>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control mb-2 " id="namakeypoint"
                                                            name="ir_master" placeholder="Enter VS Master" required />
                                                    </div>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control mb-2" id="namakeypoint"
                                                            name="scale" placeholder="Enter Scale" required />
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="arusphaser">Teg Phase T</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control mb-2" id="namakeypoint"
                                                            name="ir_rtu" placeholder="Enter VT RTU" required />
                                                    </div>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control mb-2 " id="namakeypoint"
                                                            name="ir_master" placeholder="Enter VT Master" required />
                                                    </div>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control mb-2" id="namakeypoint"
                                                            name="scale" placeholder="Enter Scale" required />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="comment_formdata">Keterangan</label>
                                                <textarea class="form-control" id="comment_formdata"
                                                    name="comment_formdata" rows="5"
                                                    placeholder="Masukkan keterangan Anda"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- PIC Komisioning Tab -->
                                    <div class="tab-pane fade" id="v-pills-pickomisioning-nobd" role="tabpanel"
                                        aria-labelledby="v-pills-pickomisioning-tab-nobd">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="merkrtu">Jenis Komisioning</label>
                                                    <select class="form-select form-control" id="merkrtu"
                                                        name="merk_rtu">
                                                        <option value="1">Option 1</option>
                                                        <option value="2">Option 2</option>
                                                        <option value="3">Option 3</option>
                                                        <option value="4">Option 4</option>
                                                        <option value="5">Option 5</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="pelaksanamaster">Pelaksana Master</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="pelaksanamaster"
                                                            name="pelaksana_master" placeholder="Nama Pelaksana Master"
                                                            required readonly />
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="pelaksana_master_ii">Pelaksana Master II</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="pelaksana_master_ii"
                                                            name="pelaksana_master_ii"
                                                            placeholder="Nama Pelaksana Master II" required readonly />
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="pelaksana_rtu">Pelaksana RTU</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="pelaksana_rtu"
                                                            name="pelaksana_rtu" placeholder="Nama Pelaksana RTU"
                                                            required readonly />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="comment_formdata">Keterangan</label>
                                                <textarea class="form-control" id="comment_formdata"
                                                    name="comment_formdata" rows="5"
                                                    placeholder="Masukkan keterangan Anda"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </div>
                        <div class="card-action">
                            <button type="submit" class="btn btn-success">
                                <span class="btn-label">
                                    <i class="fas fa-paper-plane"></i>
                                </span>
                                Submit
                            </button>
                            <button type="button" class="btn btn-danger" onclick="window.history.back()">
                                Cancel
                            </button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection

@push('scripts')

<!-- Conditionally load Sparkline and DataTable scripts -->

<script>
try {
    if (document.querySelector('#lineChart')) {
        jQuery("#lineChart").sparkline([102, 109, 120, 99, 110, 105, 115], {
            type: "line",
            height: "70",
            width: "100%",
            lineWidth: "2",
            lineColor: "#177dff",
            fillColor: "rgba(23, 125, 255, 0.14)",
        });
    } else {
        console.warn('Warning: #lineChart element not found, skipping Sparkline initialization');
    }
    if (document.querySelector('#lineChart2')) {
        jQuery("#lineChart2").sparkline([99, 125, 122, 105, 110, 124, 115], {
            type: "line",
            height: "70",
            width: "100%",
            lineWidth: "2",
            lineColor: "#f3545d",
            fillColor: "rgba(243, 84, 93, .14)",
        });
    } else {
        console.warn('Warning: #lineChart2 element not found, skipping Sparkline initialization');
    }
    if (document.querySelector('#lineChart3')) {
        jQuery("#lineChart3").sparkline([105, 103, 123, 100, 95, 105, 115], {
            type: "line",
            height: "70",
            width: "100%",
            lineWidth: "2",
            lineColor: "#ffa534",
            fillColor: "rgba(255, 165, 52, .14)",
        });
    } else {
        console.warn('Warning: #lineChart3 element not found, skipping Sparkline initialization');
    }
} catch (error) {
    console.error('Error in Sparkline initialization:', error);
}
</script>

@endpush
