@extends('layout.app')

@section('title', 'Tambah Data Keypoint')

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
                                            <div class="form-group">
                                                <label for="ketkp">Keterangan</label>
                                                <textarea class="form-control" id="ketkp" name="ketkp" rows="5"
                                                    placeholder="Masukkan keterangan Anda"
                                                    required>{{ old('ketkp') }}</textarea>
                                                @error('ketkp')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Form Telestatus Tab -->
                                    <div class="tab-pane fade" id="v-pills-formtelestatus-nobd" role="tabpanel"
                                        aria-labelledby="v-pills-formtelestatus-tab-nobd">
                                        <div class="row">
                                            <div class="col-md-12">
                                                @foreach ([
                                                's_cb' => 'CB',
                                                's_cb2' => 'CB 2',
                                                's_lr' => 'Local/Remote',
                                                's_door' => 'Door',
                                                's_acf' => 'ACF',
                                                's_dcf' => 'DCF',
                                                's_dcd' => 'DCD',
                                                's_hlt' => 'HLT',
                                                's_sf6' => 'SF6',
                                                's_fir' => 'FIR',
                                                's_fis' => 'FIS',
                                                's_fit' => 'FIT',
                                                's_fin' => 'FIN',
                                                's_comf' => 'COMF',
                                                's_lruf' => 'LRUF'
                                                ] as $field => $label)
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-1">
                                                            <label class="form-label t-bold">{{ $label }}</label>
                                                        </div>
                                                        <div class="col-md-10">
                                                            <div class="selectgroup w-100">
                                                                @foreach (['normal' => 'Normal', 'ok' => 'OK', 'nok' =>
                                                                'NOK', 'log' => 'LOG', 'sld' => 'SLD', 'tidak_uji' =>
                                                                'Tidak Uji'] as $value => $display)
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="{{ $field }}[]"
                                                                        value="{{ $value }}" class="selectgroup-input"
                                                                        {{ in_array($value, old($field, [])) ? 'checked' : '' }} />
                                                                    <span
                                                                        class="selectgroup-button">{{ $display }}</span>
                                                                </label>
                                                                @endforeach
                                                            </div>
                                                            @error($field)
                                                            <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Form Telecontrol Tab -->
                                    <div class="tab-pane fade" id="v-pills-formtelecontrol-nobd" role="tabpanel"
                                        aria-labelledby="v-pills-formtelecontrol-tab-nobd">
                                        <div class="row">
                                            <div class="col-md-12">
                                                @foreach ([
                                                'c_cb' => 'CB',
                                                'c_cb2' => 'CB 2',
                                                'c_hlt' => 'HLT',
                                                'c_rst' => 'Reset'
                                                ] as $field => $label)
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-1">
                                                            <label class="form-label t-bold">{{ $label }}</label>
                                                        </div>
                                                        <div class="col-md-10">
                                                            <div class="selectgroup w-100">
                                                                @foreach (['normal' => 'Normal', 'ok' => 'OK', 'nok' =>
                                                                'NOK', 'log' => 'LOG', 'sld' => 'SLD', 'tidak_uji' =>
                                                                'Tidak Uji'] as $value => $display)
                                                                <label class="selectgroup-item">
                                                                    <input type="checkbox" name="{{ $field }}[]"
                                                                        value="{{ $value }}" class="selectgroup-input"
                                                                        {{ in_array($value, old($field, [])) ? 'checked' : '' }} />
                                                                    <span
                                                                        class="selectgroup-button">{{ $display }}</span>
                                                                </label>
                                                                @endforeach
                                                            </div>
                                                            @error($field)
                                                            <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                @endforeach
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
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control mb-2" name="ir_rtu"
                                                            placeholder="IR RTU" value="{{ old('ir_rtu') }}" />
                                                        @error('ir_rtu')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control mb-2" name="ir_ms"
                                                            placeholder="IR Master" value="{{ old('ir_ms') }}" />
                                                        @error('ir_ms')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control mb-2" name="ir_scale"
                                                            placeholder="Scale" value="{{ old('ir_scale') }}" />
                                                        @error('ir_scale')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Arus Phase S</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control mb-2" name="is_rtu"
                                                            placeholder="IS RTU" value="{{ old('is_rtu') }}" />
                                                        @error('is_rtu')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control mb-2" name="is_ms"
                                                            placeholder="IS Master" value="{{ old('is_ms') }}" />
                                                        @error('is_ms')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control mb-2" name="is_scale"
                                                            placeholder="Scale" value="{{ old('is_scale') }}" />
                                                        @error('is_scale')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Arus Phase T</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control mb-2" name="it_rtu"
                                                            placeholder="IT RTU" value="{{ old('it_rtu') }}" />
                                                        @error('it_rtu')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control mb-2" name="it_ms"
                                                            placeholder="IT Master" value="{{ old('it_ms') }}" />
                                                        @error('it_ms')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control mb-2" name="it_scale"
                                                            placeholder="Scale" value="{{ old('it_scale') }}" />
                                                        @error('it_scale')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="sign_kp">Sign Strength</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="sign_kp"
                                                            name="sign_kp" placeholder="30db"
                                                            value="{{ old('sign_kp') }}" />
                                                        @error('sign_kp')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Teg Phase R</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control mb-2" name="vr_rtu"
                                                            placeholder="VR RTU" value="{{ old('vr_rtu') }}" />
                                                        @error('vr_rtu')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control mb-2" name="vr_ms"
                                                            placeholder="VR Master" value="{{ old('vr_ms') }}" />
                                                        @error('vr_ms')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control mb-2" name="vr_scale"
                                                            placeholder="Scale" value="{{ old('vr_scale') }}" />
                                                        @error('vr_scale')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Teg Phase S</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control mb-2" name="vs_rtu"
                                                            placeholder="VS RTU" value="{{ old('vs_rtu') }}" />
                                                        @error('vs_rtu')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control mb-2" name="vs_ms"
                                                            placeholder="VS Master" value="{{ old('vs_ms') }}" />
                                                        @error('vs_ms')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control mb-2" name="vs_scale"
                                                            placeholder="Scale" value="{{ old('vs_scale') }}" />
                                                        @error('vs_scale')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Teg Phase T</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control mb-2" name="vt_rtu"
                                                            placeholder="VT RTU" value="{{ old('vt_rtu') }}" />
                                                        @error('vt_rtu')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control mb-2" name="vt_ms"
                                                            placeholder="VT Master" value="{{ old('vt_ms') }}" />
                                                        @error('vt_ms')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control mb-2" name="vt_scale"
                                                            placeholder="Scale" value="{{ old('vt_scale') }}" />
                                                        @error('vt_scale')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- PIC Komisioning Tab -->
                                    <div class="tab-pane fade" id="v-pills-pickomisioning-nobd" role="tabpanel"
                                        aria-labelledby="v-pills-pickomisioning-tab-nobd">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="id_komkp">Jenis Komisioning</label>
                                                    <select class="form-select form-control" id="id_komkp"
                                                        name="id_komkp" required>
                                                        <option value="">Pilih Jenis Komisioning</option>
                                                        @foreach ($komkp as $kom)
                                                        <option value="{{ $kom->id_komkp }}"
                                                            {{ old('id_komkp') == $kom->id_komkp ? 'selected' : '' }}>
                                                            {{ $kom->jenis_komkp }}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                    @error('id_komkp')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label for="nama_user">Pelaksana Master</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="nama_user"
                                                            name="nama_user"
                                                            value="{{ auth()->user()->nama_admin ?? '' }}" readonly />
                                                        @error('nama_user')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="id_picms">Pelaksana Master II</label>
                                                    <select class="form-select form-control" id="id_picms"
                                                        name="id_picms" required>
                                                        <option value="">Pilih Pelaksana Master II</option>
                                                        @foreach ($picmaster as $pic)
                                                        <option value="{{ $pic->id_picmaster }}"
                                                            {{ old('id_picms') == $pic->id_picmaster ? 'selected' : '' }}>
                                                            {{ $pic->nama_picmaster }}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                    @error('id_picms')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label for="pelrtu">Pelaksana RTU</label>
                                                    <div class="input-icon">
                                                        <input type="text" class="form-control" id="pelrtu"
                                                            name="pelrtu" placeholder="Nama Pelaksana RTU"
                                                            value="{{ old('pelrtu') }}" required />
                                                        @error('pelrtu')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
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
