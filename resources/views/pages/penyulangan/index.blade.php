@extends('layout.app')

@section('title', 'Data Penyulangan')

@section('content')
<div class="page-inner">
    <div class="page-header">
        <h3 class="fw-bold mb-3">Data Penyulangan</h3>
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
                <a href="#">Data Penyulangan</a>
            </li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Data Penyulangan</h4>
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
                        <table id="penyulangan-table" class="display table table-striped table-hover"
                            style="width:100%">
                            <thead>
                                <tr>
                                    <th>Tgl Komisioning</th>
                                    <th>Nama Penyulang</th>
                                    <th>Gardu Induk</th>
                                    <th>Wilayah DCC</th>
                                    <th>Keterangan</th>
                                    <th>PIC Master</th>
                                    <th>PIC RTU</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                            <tfoot>
                                <tr>
                                    <th><input type="text" placeholder="Filter Tgl" class="form-control" /></th>
                                    <th><input type="text" placeholder="Filter Nama" class="form-control" /></th>
                                    <th><input type="text" placeholder="Filter Gardu Induk" class="form-control" /></th>
                                    <th><input type="text" placeholder="Filter Wilayah DCC" class="form-control" /></th>
                                    <th><input type="text" placeholder="Filter Keterangan" class="form-control" /></th>
                                    <th><input type="text" placeholder="Filter PIC Master" class="form-control" /></th>
                                    <th><input type="text" placeholder="Filter PIC RTU" class="form-control" /></th>
                                    <th></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<meta name="csrf-token" content="{{ csrf_token() }}">

<script>
function exportTo(type) {
    var from = $('#dari-tanggal').val();
    var to = $('#sampai-tanggal').val();
    var url = '/penyulangan/export/' + type + '?from=' + from + '&to=' + to;
    window.open(url, '_blank');
}

$(document).ready(function() {
    if ($.fn.DataTable.isDataTable('#penyulangan-table')) {
        $('#penyulangan-table').DataTable().destroy();
    }

    var table = $('#penyulangan-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '{{ route("penyulangan.data") }}',
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
                data: 'tgl_kom',
                name: 'tgl_kom'
            },
            {
                data: 'nama_peny',
                name: 'nama_peny'
            },
            {
                data: 'id_gi',
                name: 'id_gi'
            },
            {
                data: 'id_rtugi',
                name: 'id_rtugi'
            },
            {
                data: 'ketpeny',
                name: 'ketpeny'
            },
            {
                data: 'nama_user',
                name: 'nama_user'
            },
            {
                data: 'id_pelrtu',
                name: 'id_pelrtu'
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false,
                render: function(data, type, row) {
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

    $('#penyulangan-table tfoot input').on('keyup change clear', function() {
        var column = table.column($(this).closest('th').index());
        column.search(this.value).draw();
    });

    $('#dari-tanggal, #sampai-tanggal').change(function() {
        table.draw();
    });
});
</script>
@endsection
