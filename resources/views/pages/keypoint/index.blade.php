@extends('layout.app')

@section('title', 'Dashboard')

@section('content')
<div class="page-inner">
    <div class="page-header">
        <h3 class="fw-bold mb-3">Data Keypoint</h3>
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
                <a href="#">Tables</a>
            </li>
            <li class="separator">
                <i class="icon-arrow-right"></i>
            </li>
            <li class="nav-item">
                <a href="#">Data Keypoint</a>
            </li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Data Keypoint</h4>
                </div>
                <div class="card-body">

                    <div class="table-responsive">
                        <div class="row mb-3">
                            <div class="col-md-2">
                                <label for="dari-tanggal" class="form-label">Dari Tanggal:</label>
                                <input type="date" id="dari-tanggal" class="form-control" />
                            </div>
                            <div class="col-md-2">
                                <label for="sampai-tanggal" class="form-label">Sampai Tanggal:</label>
                                <input type="date" id="sampai-tanggal" class="form-control" />
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Export Data To :</label>
                                <button class="btn btn-danger" onclick="exportTo('pdf')">
                                    <span class="btn-label"><i class="fas fa-file-pdf"></i></span> PDF
                                </button>
                                <button class="btn btn-success" onclick="exportTo('excel')">
                                    <span class="btn-label"><i class="fas fa-file-excel"></i></span> Excel
                                </button>
                            </div>
                        </div>
                        <table id="keypoint-table" class="display table table-striped table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Tgl Komisioning</th>
                                    <th>Nama Keypoint</th>
                                    <th>GI & Penyulang</th>
                                    <th>Merk Modem & RTU</th>
                                    <th>Keterangan</th>
                                    <th>Master</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody></tbody> <!-- Ensure this is empty -->
                            <tfoot>
                                <tr>
                                    <th><input type="text" placeholder="Filter Tgl" class="form-control" /></th>
                                    <th><input type="text" placeholder="Filter Nama" class="form-control" /></th>
                                    <th><input type="text" placeholder="Filter GI & Penyulang" class="form-control" />
                                    </th>
                                    <th><input type="text" placeholder="Filter Merk" class="form-control" /></th>
                                    <th><input type="text" placeholder="Filter Keterangan" class="form-control" /></th>
                                    <th><input type="text" placeholder="Filter Master" class="form-control" /></th>
                                    <th></th> <!-- No filter for action -->
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Include DataTables CSS/JS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>

<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<script>
function exportTo(type) {
    var from = $('#dari-tanggal').val();
    var to = $('#sampai-tanggal').val();
    var url = '/keypoint/export/' + type + '?from=' + from + '&to=' + to;
    window.open(url, '_blank');
}

$(document).ready(function() {
    // Destroy existing DataTable if it exists
    if ($.fn.DataTable.isDataTable('#keypoint-table')) {
        $('#keypoint-table').DataTable().destroy();
    }

    var table = $('#keypoint-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '{{ route("keypoint.data") }}',
            type: 'POST',
            data: function(d) {
                d.from_date = $('#dari-tanggal').val();
                d.to_date = $('#sampai-tanggal').val();
                d._token = $('meta[name="csrf-token"]').attr('content');
            },
            error: function(xhr, error, thrown) {
                console.log('Ajax Error: ', xhr.responseText);
            }
        },
        columns: [{
                data: 'tgl_komisioning',
                name: 'tgl_komisioning'
            },
            {
                data: 'nama_keypoint',
                name: 'nama_keypoint'
            },
            {
                data: 'gi_penyulang',
                name: 'gi_penyulang'
            },
            {
                data: 'merk_modem_rtu',
                name: 'merk_modem_rtu'
            },
            {
                data: 'keterangan',
                name: 'keterangan'
            },
            {
                data: 'master',
                name: 'master'
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false,
                render: function(data, type, row) {
                    // Return the action HTML with proper escaping
                    return data;
                }
            }
        ],
        pageLength: 25,
        lengthMenu: [10, 25, 50, 100],
        order: [
            [0, 'desc']
        ],
        language: {
            processing: "Loading data...",
            emptyTable: "No data available"
        }
    });

    // Per-column filtering
    $('#keypoint-table tfoot input').on('keyup change clear', function() {
        var column = table.column($(this).closest('th').index());
        column.search(this.value).draw();
    });

    // Redraw table on date change
    $('#dari-tanggal, #sampai-tanggal').change(function() {
        table.draw();
    });
});
</script>
@endsection