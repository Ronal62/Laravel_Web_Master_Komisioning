@extends('layout.app')

@section('title', 'Data Keypoint')

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
                            <div class="col-md-4 d-flex align-items-end">
                                <button type="button" id="btn-filter" class="btn btn-primary me-2">
                                    <i class="fas fa-filter"></i> Filter
                                </button>
                                <button type="button" id="btn-reset" class="btn btn-secondary me-2">
                                    <i class="fas fa-undo"></i> Reset
                                </button>

                                {{-- Tombol PDF --}}
                                <button type="button" id="btn-export-pdf" class="btn btn-danger me-2"
                                    onclick="exportByDatePdf()">
                                    <i class="fas fa-file-pdf"></i> PDF
                                </button>

                                {{-- Tombol Excel Baru --}}
                                <button type="button" id="btn-export-excel" class="btn btn-success"
                                    onclick="exportByDateExcel()">
                                    <i class="fas fa-file-excel"></i> Excel
                                </button>
                            </div>
                        </div>

                        <!-- Alert Container -->
                        <div id="alert-container"></div>
                        <table id="keypoint-table" class="display table table-striped table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Tgl Komisioning</th>
                                    <th>Nama Keypoint</th>
                                    <th>GI & Penyulang</th>
                                    <th>Merk Modem & RTU</th>
                                    <th>Keterangan</th>
                                    <th>Master</th>
                                    <th>Pelaksana RTU</th>
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
                                    <th><input type="text" placeholder="Filter Pelaksana RTU" class="form-control" />
                                    </th>
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
function exportByDateExcel() {
    var fromDate = $('#dari-tanggal').val();
    var toDate = $('#sampai-tanggal').val();

    // Validation
    if (!fromDate || !toDate) {
        showAlert('warning', 'Silakan pilih rentang tanggal terlebih dahulu!');
        return;
    }

    if (new Date(fromDate) > new Date(toDate)) {
        showAlert('warning', 'Tanggal awal tidak boleh lebih besar dari tanggal akhir!');
        return;
    }

    // Show loading UI
    var originalBtnContent = $('#btn-export-excel').html();
    $('#btn-export-excel').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Exporting...');

    // Open export URL in new window/tab to trigger download
    var exportUrl = '{{ route("keypoint.exportexcel") }}?from_date=' + fromDate + '&to_date=' + toDate;

    // Redirect logic
    window.location.href = exportUrl;

    // Reset button after delay (give time for request to initiate)
    setTimeout(function() {
        $('#btn-export-excel').prop('disabled', false).html(originalBtnContent);
    }, 3000);
}




function exportByDatePdf() {
    var fromDate = $('#dari-tanggal').val();
    var toDate = $('#sampai-tanggal').val();

    // Validation
    if (!fromDate || !toDate) {
        showAlert('warning', 'Silakan pilih rentang tanggal terlebih dahulu!');
        return;
    }

    if (new Date(fromDate) > new Date(toDate)) {
        showAlert('warning', 'Tanggal awal tidak boleh lebih besar dari tanggal akhir!');
        return;
    }

    // Show loading
    $('#btn-export-pdf').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Exporting...');

    // Open export URL in new window
    var exportUrl = '{{ route("keypoint.exportbydate") }}?from_date=' + fromDate + '&to_date=' + toDate;
    window.location.href = exportUrl;

    // Reset button after delay
    setTimeout(function() {
        $('#btn-export-pdf').prop('disabled', false).html('<i class="fas fa-file-pdf"></i> Export PDF');
    }, 3000);
}

function showAlert(type, message) {
    var alertClass = 'alert-' + type;
    var alertHtml = '<div class="alert ' + alertClass + ' alert-dismissible fade show" role="alert">' +
        message +
        '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' +
        '</div>';
    $('#alert-container').html(alertHtml);

    // Auto dismiss after 5 seconds
    setTimeout(function() {
        $('#alert-container .alert').fadeOut();
    }, 5000);
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
                data: 'pelaksana_rtu',
                name: 'pelaksana_rtu'
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
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

    // Filter button click
    $('#btn-filter').click(function() {
        table.draw();
    });

    // Reset button click
    $('#btn-reset').click(function() {
        $('#dari-tanggal').val('');
        $('#sampai-tanggal').val('');
        table.draw();
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
