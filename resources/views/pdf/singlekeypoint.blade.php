@extends('layout.app')

@section('title', 'Keypoint Details')

@section('content')
<div class="page-inner">
    <div class="page-header">
        <h3 class="fw-bold mb-3">Keypoint Details</h3>
    </div>
    <div class="row">
        <div class="col-12 col-md-4 mt-2 mt-md-0">
            <label for="export-options" class="form-label">Export Data To:</label>
            <div class="d-flex flex-column flex-md-row">
                <a href="{{ route('exportpdf', $keypoint->id_formkp) }}" class="btn btn-danger me-md-2 mb-2 mb-md-0 w-100 w-md-auto">
                    <span class="btn-label">
                        <i class="fas fa-file-pdf"></i>
                    </span>
                    PDF
                </a>
                <button class="btn btn-success w-100 w-md-auto">
                    <span class="btn-label">
                        <i class="fas fa-file-excel"></i>
                    </span>
                    Excel
                </button>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Form Komisioning Keypoint</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm">
                            <!-- Empty rows for spacing (rows 1-17) -->
                            @for ($i = 1; $i <= 17; $i++)
                                <tr>
                                @for ($j = 1; $j <= 17; $j++)
                                    <td>
                                    </td>
                                    @endfor
                                    </tr>
                                    @endfor

                                    <!-- Row 18: Header -->
                                    <tr>
                                        <th colspan="17" class="text-center">FORM KOMISIONING KEYPOINT</th>
                                    </tr>

                                    <!-- Row 19: Empty -->
                                    <tr>
                                        <td colspan="17"></td>
                                    </tr>

                                    <!-- Row 20: Nama LBS, Modem, Gardu Induk -->
                                    <tr>
                                        <td>Nama LBS / REC.</td>
                                        <td></td>
                                        <td>:</td>
                                        <td></td>
                                        <td></td>
                                        <td>Modem</td>
                                        <td></td>
                                        <td></td>
                                        <td>:</td>
                                        <td></td>
                                        <td>Gardu Induk / Sectoral</td>
                                        <td></td>
                                        <td>:</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td colspan="5">{{ $keypoint->nama_lbs }}</td>
                                        <td colspan="5">{{ $modem }}</td>
                                        <td colspan="7">{{ $gi }} / {{ $sectoral }}</td>
                                    </tr>

                                    <!-- Row 21: Merk LBS, IP Address, Penyulang -->
                                    <tr>
                                        <td>Merk LBS / REC.</td>
                                        <td></td>
                                        <td>:</td>
                                        <td></td>
                                        <td></td>
                                        <td>IP Address / No. Kartu</td>
                                        <td></td>
                                        <td></td>
                                        <td>:</td>
                                        <td></td>
                                        <td>Penyulang</td>
                                        <td></td>
                                        <td>:</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td colspan="5">{{ $merklbs }}</td>
                                        <td colspan="5">{{ $keypoint->ip_kp }}</td>
                                        <td colspan="7">{{ $keypoint->nama_peny }}</td>
                                    </tr>

                                    <!-- Row 22: Protocol / RTU Address, Koordinat, Tanggal -->
                                    <tr>
                                        <td>Protocol / RTU Address</td>
                                        <td></td>
                                        <td>:</td>
                                        <td></td>
                                        <td></td>
                                        <td>Koordinat</td>
                                        <td></td>
                                        <td></td>
                                        <td>:</td>
                                        <td></td>
                                        <td>Tanggal</td>
                                        <td></td>
                                        <td>:</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">{{ $medkom }}</td>
                                        <td>/</td>
                                        <td colspan="2">{{ $keypoint->rtu_addrs }}</td>
                                        <td colspan="5"></td> <!-- Koordinat not in DB -->
                                        <td colspan="7">{{ \Carbon\Carbon::parse($keypoint->tgl_komisioning)->format('d-m-Y') }}</td>
                                    </tr>

                                    <!-- Row 23: Empty -->
                                    <tr>
                                        <td colspan="17"></td>
                                    </tr>

                                    <!-- Row 24: Status Header -->
                                    <tr>
                                        <th>ADD-MS</th>
                                        <th>ADD-RTU</th>
                                        <th>OBJ/FRMT</th>
                                        <th>STATUS</th>
                                        <th>VALUE</th>
                                        <th>OK</th>
                                        <th>NOK</th>
                                        <th>LOG</th>
                                        <th>SLD</th>
                                        <th>Keterangan</th>
                                        <th></th>
                                        <th>Hardware</th>
                                        <th>OK/NOK</th>
                                        <th>Value</th>
                                        <th>Keterangan</th>
                                        <th></th>
                                        <th></th>
                                    </tr>

                                    <!-- Row 25-48: Status Rows -->
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>CB</td>
                                        <td>Open</td>
                                        <td>{{ in_array('ok', explode(',', $keypoint->s_cb)) ? 'X' : '' }}</td>
                                        <td>{{ in_array('nok', explode(',', $keypoint->s_cb)) ? 'X' : '' }}</td>
                                        <td>{{ in_array('log', explode(',', $keypoint->s_cb)) ? 'X' : '' }}</td>
                                        <td>{{ in_array('sld', explode(',', $keypoint->s_cb)) ? 'X' : '' }}</td>
                                        <td>{{ in_array('tidak_uji', explode(',', $keypoint->s_cb)) ? 'Tidak Uji' : (in_array('normal', explode(',', $keypoint->s_cb)) ? 'Normal' : '') }}</td>
                                        <td></td>
                                        <td>Batere</td>
                                        <td>{{ in_array('ok', explode(',', $keypoint->s_fin)) ? 'OK' : (in_array('nok', explode(',', $keypoint->s_fin)) ? 'NOK' : '') }}</td>
                                        <td>{{ $keypoint->sign_kp }}</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>Close</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>PS 220</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>CB 2</td>
                                        <td>Open</td>
                                        <td>{{ in_array('ok', explode(',', $keypoint->s_cb2)) ? 'X' : '' }}</td>
                                        <td>{{ in_array('nok', explode(',', $keypoint->s_cb2)) ? 'X' : '' }}</td>
                                        <td>{{ in_array('log', explode(',', $keypoint->s_cb2)) ? 'X' : '' }}</td>
                                        <td>{{ in_array('sld', explode(',', $keypoint->s_cb2)) ? 'X' : '' }}</td>
                                        <td>{{ in_array('tidak_uji', explode(',', $keypoint->s_cb2)) ? 'Tidak Uji' : '' }}</td>
                                        <td></td>
                                        <td>Charger</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>Close</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>Limit Switch</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>L / R</td>
                                        <td>Local</td>
                                        <td>{{ in_array('ok', explode(',', $keypoint->s_lr)) ? 'X' : '' }}</td>
                                        <td>{{ in_array('nok', explode(',', $keypoint->s_lr)) ? 'X' : '' }}</td>
                                        <td>{{ in_array('log', explode(',', $keypoint->s_lr)) ? 'X' : '' }}</td>
                                        <td>{{ in_array('sld', explode(',', $keypoint->s_lr)) ? 'X' : '' }}</td>
                                        <td>{{ in_array('tidak_uji', explode(',', $keypoint->s_lr)) ? 'Tidak Uji' : '' }}</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>Remote</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>System</td>
                                        <th>OK/NOK</th>
                                        <th>Value</th>
                                        <th>Keterangan</th>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>DOOR</td>
                                        <td>Open</td>
                                        <td>{{ in_array('ok', explode(',', $keypoint->s_door)) ? 'X' : '' }}</td>
                                        <td>{{ in_array('nok', explode(',', $keypoint->s_door)) ? 'X' : '' }}</td>
                                        <td>{{ in_array('log', explode(',', $keypoint->s_door)) ? 'X' : '' }}</td>
                                        <td>{{ in_array('sld', explode(',', $keypoint->s_door)) ? 'X' : '' }}</td>
                                        <td>{{ in_array('tidak_uji', explode(',', $keypoint->s_door)) ? 'Tidak Uji' : '' }}</td>
                                        <td></td>
                                        <td>COMF</td>
                                        <td>{{ in_array('ok', explode(',', $keypoint->s_comf)) ? 'OK' : (in_array('nok', explode(',', $keypoint->s_comf)) ? 'NOK' : '') }}</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>Close</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>LRUF</td>
                                        <td>{{ in_array('ok', explode(',', $keypoint->s_lruf)) ? 'OK' : (in_array('nok', explode(',', $keypoint->s_lruf)) ? 'NOK' : '') }}</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>ACF</td>
                                        <td>Normal</td>
                                        <td>{{ in_array('ok', explode(',', $keypoint->s_acf)) ? 'X' : '' }}</td>
                                        <td>{{ in_array('nok', explode(',', $keypoint->s_acf)) ? 'X' : '' }}</td>
                                        <td>{{ in_array('log', explode(',', $keypoint->s_acf)) ? 'X' : '' }}</td>
                                        <td>{{ in_array('sld', explode(',', $keypoint->s_acf)) ? 'X' : '' }}</td>
                                        <td>{{ in_array('tidak_uji', explode(',', $keypoint->s_acf)) ? 'Tidak Uji' : (in_array('normal', explode(',', $keypoint->s_acf)) ? 'Normal' : '') }}</td>
                                        <td></td>
                                        <td>SIGN S</td>
                                        <td></td>
                                        <td>{{ $keypoint->sign_kp }}</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>Failed</td>
                                        <td></td>
                                        <td>{{ in_array('failed', explode(',', $keypoint->s_acf)) ? 'X' : '' }}</td>
                                        <td></td>
                                        <td></td>
                                        <td>{{ in_array('failed', explode(',', $keypoint->s_acf)) ? 'Failed' : '' }}</td>
                                        <td></td>
                                        <td>Limit Switch</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>DCF</td>
                                        <td>Normal</td>
                                        <td>{{ in_array('ok', explode(',', $keypoint->s_dcf)) ? 'X' : '' }}</td>
                                        <td>{{ in_array('nok', explode(',', $keypoint->s_dcf)) ? 'X' : '' }}</td>
                                        <td></td>
                                        <td></td>
                                        <td>{{ in_array('tidak_uji', explode(',', $keypoint->s_dcf)) ? 'Tidak Uji' : (in_array('normal', explode(',', $keypoint->s_dcf)) ? 'Normal' : '') }}</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>Failed</td>
                                        <td></td>
                                        <td>{{ in_array('failed', explode(',', $keypoint->s_dcf)) ? 'X' : '' }}</td>
                                        <td></td>
                                        <td></td>
                                        <td>{{ in_array('failed', explode(',', $keypoint->s_dcf)) ? 'Failed' : '' }}</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>DCD</td>
                                        <td>Normal</td>
                                        <td>{{ in_array('ok', explode(',', $keypoint->s_dcd)) ? 'X' : '' }}</td>
                                        <td>{{ in_array('nok', explode(',', $keypoint->s_dcd)) ? 'X' : '' }}</td>
                                        <td></td>
                                        <td></td>
                                        <td>{{ in_array('tidak_uji', explode(',', $keypoint->s_dcd)) ? 'Tidak Uji' : (in_array('normal', explode(',', $keypoint->s_dcd)) ? 'Normal' : '') }}</td>
                                        <td></td>
                                        <td>AR</td>
                                        <td>{{ in_array('on', explode(',', $keypoint->s_comf)) ? 'On' : '' }}</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>Failed</td>
                                        <td></td>
                                        <td>{{ in_array('failed', explode(',', $keypoint->s_dcd)) ? 'X' : '' }}</td>
                                        <td></td>
                                        <td></td>
                                        <td>{{ in_array('failed', explode(',', $keypoint->s_dcd)) ? 'Failed' : '' }}</td>
                                        <td></td>
                                        <td></td>
                                        <td>{{ in_array('off', explode(',', $keypoint->s_comf)) ? 'Off' : '' }}</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>HLT</td>
                                        <td>Active</td>
                                        <td>{{ in_array('ok', explode(',', $keypoint->s_hlt)) ? 'X' : '' }}</td>
                                        <td>{{ in_array('nok', explode(',', $keypoint->s_hlt)) ? 'X' : '' }}</td>
                                        <td></td>
                                        <td></td>
                                        <td>{{ in_array('tidak_uji', explode(',', $keypoint->s_hlt)) ? 'Tidak Uji' : (in_array('active', explode(',', $keypoint->s_hlt)) ? 'Active' : '') }}</td>
                                        <td></td>
                                        <td>CTRL AR</td>
                                        <td>{{ in_array('on', explode(',', $keypoint->s_lruf)) ? 'On' : '' }}</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>Inactive</td>
                                        <td></td>
                                        <td>{{ in_array('inactive', explode(',', $keypoint->s_hlt)) ? 'X' : '' }}</td>
                                        <td></td>
                                        <td></td>
                                        <td>{{ in_array('inactive', explode(',', $keypoint->s_hlt)) ? 'Inactive' : '' }}</td>
                                        <td></td>
                                        <td></td>
                                        <td>{{ in_array('off', explode(',', $keypoint->s_lruf)) ? 'Off' : '' }}</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>SF6</td>
                                        <td>Normal</td>
                                        <td>{{ in_array('ok', explode(',', $keypoint->s_sf6)) ? 'X' : '' }}</td>
                                        <td>{{ in_array('nok', explode(',', $keypoint->s_sf6)) ? 'X' : '' }}</td>
                                        <td></td>
                                        <td></td>
                                        <td>{{ in_array('tidak_uji', explode(',', $keypoint->s_sf6)) ? 'Tidak Uji' : (in_array('normal', explode(',', $keypoint->s_sf6)) ? 'Normal' : '') }}</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>Low</td>
                                        <td></td>
                                        <td>{{ in_array('low', explode(',', $keypoint->s_sf6)) ? 'X' : '' }}</td>
                                        <td></td>
                                        <td></td>
                                        <td>{{ in_array('low', explode(',', $keypoint->s_sf6)) ? 'Low' : '' }}</td>
                                        <td></td>
                                        <td>Catatan :</td>
                                        <td>{{ $keypoint->ketkp }}</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>FIR</td>
                                        <td>Normal</td>
                                        <td>{{ in_array('ok', explode(',', $keypoint->s_fir)) ? 'X' : '' }}</td>
                                        <td>{{ in_array('nok', explode(',', $keypoint->s_fir)) ? 'X' : '' }}</td>
                                        <td></td>
                                        <td></td>
                                        <td>{{ in_array('tidak_uji', explode(',', $keypoint->s_fir)) ? 'Tidak Uji' : (in_array('normal', explode(',', $keypoint->s_fir)) ? 'Normal' : '') }}</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>Failed</td>
                                        <td></td>
                                        <td>{{ in_array('failed', explode(',', $keypoint->s_fir)) ? 'X' : '' }}</td>
                                        <td></td>
                                        <td></td>
                                        <td>{{ in_array('failed', explode(',', $keypoint->s_fir)) ? 'Failed' : '' }}</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>FIS</td>
                                        <td>Normal</td>
                                        <td>{{ in_array('ok', explode(',', $keypoint->s_fis)) ? 'X' : '' }}</td>
                                        <td>{{ in_array('nok', explode(',', $keypoint->s_fis)) ? 'X' : '' }}</td>
                                        <td></td>
                                        <td></td>
                                        <td>{{ in_array('tidak_uji', explode(',', $keypoint->s_fis)) ? 'Tidak Uji' : (in_array('normal', explode(',', $keypoint->s_fis)) ? 'Normal' : '') }}</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>Failed</td>
                                        <td></td>
                                        <td>{{ in_array('failed', explode(',', $keypoint->s_fis)) ? 'X' : '' }}</td>
                                        <td></td>
                                        <td></td>
                                        <td>{{ in_array('failed', explode(',', $keypoint->s_fis)) ? 'Failed' : '' }}</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>FIT</td>
                                        <td>Normal</td>
                                        <td>{{ in_array('ok', explode(',', $keypoint->s_fit)) ? 'X' : '' }}</td>
                                        <td>{{ in_array('nok', explode(',', $keypoint->s_fit)) ? 'X' : '' }}</td>
                                        <td></td>
                                        <td></td>
                                        <td>{{ in_array('tidak_uji', explode(',', $keypoint->s_fit)) ? 'Tidak Uji' : (in_array('normal', explode(',', $keypoint->s_fit)) ? 'Normal' : '') }}</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>Failed</td>
                                        <td></td>
                                        <td>{{ in_array('failed', explode(',', $keypoint->s_fit)) ? 'X' : '' }}</td>
                                        <td></td>
                                        <td></td>
                                        <td>{{ in_array('failed', explode(',', $keypoint->s_fit)) ? 'Failed' : '' }}</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>

                                    <!-- Row 49: Empty -->
                                    <tr>
                                        <td colspan="17"></td>
                                    </tr>

                                    <!-- Row 50: CTRL Header -->
                                    <tr>
                                        <th>ADD-MS</th>
                                        <th>ADD-RTU</th>
                                        <th>OBJ/FRMT</th>
                                        <th>CTRL</th>
                                        <th>VALUE</th>
                                        <th>OK</th>
                                        <th>NOK</th>
                                        <th>LOG</th>
                                        <th>SLD</th>
                                        <th>Keterangan</th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                    </tr>

                                    <!-- Row 51-57: CTRL Rows -->
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>CB</td>
                                        <td>Open</td>
                                        <td>{{ in_array('ok', explode(',', $keypoint->c_cb)) ? 'X' : '' }}</td>
                                        <td>{{ in_array('nok', explode(',', $keypoint->c_cb)) ? 'X' : '' }}</td>
                                        <td>{{ in_array('log', explode(',', $keypoint->c_cb)) ? 'X' : '' }}</td>
                                        <td>{{ in_array('sld', explode(',', $keypoint->c_cb)) ? 'X' : '' }}</td>
                                        <td>{{ in_array('tidak_uji', explode(',', $keypoint->c_cb)) ? 'Tidak Uji' : '' }}</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>Close</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>CB 2</td>
                                        <td>Open</td>
                                        <td>{{ in_array('ok', explode(',', $keypoint->c_cb2)) ? 'X' : '' }}</td>
                                        <td>{{ in_array('nok', explode(',', $keypoint->c_cb2)) ? 'X' : '' }}</td>
                                        <td>{{ in_array('log', explode(',', $keypoint->c_cb2)) ? 'X' : '' }}</td>
                                        <td>{{ in_array('sld', explode(',', $keypoint->c_cb2)) ? 'X' : '' }}</td>
                                        <td>{{ in_array('tidak_uji', explode(',', $keypoint->c_cb2)) ? 'Tidak Uji' : '' }}</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>Close</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>HLT</td>
                                        <td>On</td>
                                        <td>{{ in_array('ok', explode(',', $keypoint->c_hlt)) ? 'X' : '' }}</td>
                                        <td>{{ in_array('nok', explode(',', $keypoint->c_hlt)) ? 'X' : '' }}</td>
                                        <td>{{ in_array('log', explode(',', $keypoint->c_hlt)) ? 'X' : '' }}</td>
                                        <td>{{ in_array('sld', explode(',', $keypoint->c_hlt)) ? 'X' : '' }}</td>
                                        <td>{{ in_array('tidak_uji', explode(',', $keypoint->c_hlt)) ? 'Tidak Uji' : '' }}</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>Off</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>RR</td>
                                        <td>Reset</td>
                                        <td>{{ in_array('ok', explode(',', $keypoint->c_rst)) ? 'X' : '' }}</td>
                                        <td>{{ in_array('nok', explode(',', $keypoint->c_rst)) ? 'X' : '' }}</td>
                                        <td>{{ in_array('log', explode(',', $keypoint->c_rst)) ? 'X' : '' }}</td>
                                        <td>{{ in_array('sld', explode(',', $keypoint->c_rst)) ? 'X' : '' }}</td>
                                        <td>{{ in_array('tidak_uji', explode(',', $keypoint->c_rst)) ? 'Tidak Uji' : '' }}</td>
                                        <td>PELAKSANA :</td>
                                        <td colspan="6">{{ $keypoint->pelrtu }}</td>
                                    </tr>

                                    <!-- Row 58: Empty -->
                                    <tr>
                                        <td colspan="17"></td>
                                    </tr>

                                    <!-- Row 59: Metering Header -->
                                    <tr>
                                        <th>ADD-MS</th>
                                        <th>ADD-RTU</th>
                                        <th>OBJ/FRMT</th>
                                        <th>METERING</th>
                                        <th>FIELD</th>
                                        <th>MS</th>
                                        <th>SCALE</th>
                                        <th>OK/NOK</th>
                                        <th>SLD</th>
                                        <th>Keterangan</th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                    </tr>

                                    <!-- Row 60-81: Metering Rows -->
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>HZ</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>I AVG</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>IR</td>
                                        <td>{{ $keypoint->ir_rtu }}</td>
                                        <td>{{ $keypoint->ir_ms }}</td>
                                        <td>{{ $keypoint->ir_scale }}</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>IS</td>
                                        <td>{{ $keypoint->is_rtu }}</td>
                                        <td>{{ $keypoint->is_ms }}</td>
                                        <td>{{ $keypoint->is_scale }}</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>IT</td>
                                        <td>{{ $keypoint->it_rtu }}</td>
                                        <td>{{ $keypoint->it_ms }}</td>
                                        <td>{{ $keypoint->it_scale }}</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>IN</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>IFR</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>Field Eng. 01</td>
                                        <td>{{ $picms }}</td>
                                        <td></td>
                                        <td>MS Eng. 01</td>
                                        <td>{{ $picms }}</td>
                                        <td>Dispatcher 01</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>IFS</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>IFT</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>IFN</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>Pseudo</td>
                                        <td></td>
                                        <td></td>
                                        <td>IFR</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>Pseudo</td>
                                        <td></td>
                                        <td></td>
                                        <td>IFS</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>Pseudo</td>
                                        <td></td>
                                        <td></td>
                                        <td>IFT</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>Pseudo</td>
                                        <td></td>
                                        <td></td>
                                        <td>IFN</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>PF</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>V AVG</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>V-R_IN</td>
                                        <td>{{ $keypoint->vr_rtu }}</td>
                                        <td>{{ $keypoint->vr_ms }}</td>
                                        <td>{{ $keypoint->vr_scale }}</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>V-S_IN</td>
                                        <td>{{ $keypoint->vs_rtu }}</td>
                                        <td>{{ $keypoint->vs_ms }}</td>
                                        <td>{{ $keypoint->vs_scale }}</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>Field Eng. 02</td>
                                        <td>{{ $picms }}</td>
                                        <td></td>
                                        <td>MS Eng. 02</td>
                                        <td>{{ $picms }}</td>
                                        <td>Dispatcher 02</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>V-T_IN</td>
                                        <td>{{ $keypoint->vt_rtu }}</td>
                                        <td>{{ $keypoint->vt_ms }}</td>
                                        <td>{{ $keypoint->vt_scale }}</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>V-R_OUT</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>V-S_OUT</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>V-T_OUT</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>

                                    <!-- Row 82-83: Empty -->
                                    <tr>
                                        <td colspan="17"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="17"></td>
                                    </tr>

                                    <!-- Row 84: Footer Note -->
                                    <tr>
                                        <td colspan="17">Apabila dokumen ini didownload / dicetak maka akan menjadi "DOKUMEN TIDAK TERKENDALI"</td>
                                    </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section('styles')
<style>
    .table-sm th,
    .table-sm td {
        font-size: 0.8rem;
        /* Smaller font for wide table */
        padding: 0.3rem;
        /* Compact padding for landscape-like display */
    }

    @media (max-width: 576px) {

        .table-sm th,
        .table-sm td {
            font-size: 0.65rem;
            /* Smaller font for mobile */
            padding: 0.2rem;
            /* Reduced padding for mobile */
        }
    }
</style>
@endsection
@endsection                         </tr>

                                    <!-- Row 84: Footer Note -->
                                    <tr>
                                        <td colspan="17">Apabila dokumen ini didownload / dicetak maka akan menjadi
                                            "DOKUMEN TIDAK TERKENDALI"</td>
                                    </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section('styles')
<style>
.table-sm th,
.table-sm td {
    font-size: 0.8rem;
    /* Smaller font for wide table */
    padding: 0.3rem;
    /* Compact padding for landscape-like display */
}

@media (max-width: 576px) {

    .table-sm th,
    .table-sm td {
        font-size: 0.65rem;
        /* Smaller font for mobile */
        padding: 0.2rem;
        /* Reduced padding for mobile */
    }
}
</style>
@endsection
@endsection
