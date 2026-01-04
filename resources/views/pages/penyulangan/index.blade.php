@extends('layout.app')

@section('title', 'Data Penyulangan')

@push('styles')
<style>
.dataTables_processing {
    background: rgba(255, 255, 255, 0.9) !important;
    padding: 10px !important;
}
</style>
@endpush

@section('content')
<div class="page-header">
    <h3 class="fw-bold mb-3">Data Penyulangan</h3>
    <ul class="breadcrumbs mb-3">
        <li class="nav-home">
            <a href="{{ route('dashboard') }}">
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
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title mb-0">Data Penyulangan</h4>
                @if(request('auto_filter'))
                <span class="badge bg-info">
                    <i class="fas fa-filter me-1"></i>
                    Filter dari Dashboard Applied
                </span>
                @endif
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <div class="row mb-3">
                        <div class="col-md-2">
                            <label for="dari-tanggal" class="form-label">Dari Tanggal:</label>
                            <input type="date" id="dari-tanggal" class="form-control"
                                value="{{ request('from_date', '') }}" />
                        </div>
                        <div class="col-md-2">
                            <label for="sampai-tanggal" class="form-label">Sampai Tanggal:</label>
                            <input type="date" id="sampai-tanggal" class="form-control"
                                value="{{ request('to_date', '') }}" />
                        </div>
                        <div class="col-md-2">
                            <label for="filter-category" class="form-label">Kategori:</label>
                            <select id="filter-category" class="form-control">
                                <option value="">Semua</option>
                                <option value="gardu_induk"
                                    {{ request('category') == 'gardu_induk' ? 'selected' : '' }}>
                                    Gardu Induk
                                </option>
                                <option value="rtu_gi" {{ request('category') == 'rtu_gi' ? 'selected' : '' }}>
                                    RTU GI
                                </option>
                            </select>
                        </div>
                        <div class="col-md-4 d-flex align-items-end">
                            <button type="button" id="btn-filter" class="btn btn-primary me-2">
                                <i class="fas fa-filter"></i> Filter
                            </button>
                            <button type="button" id="btn-reset" class="btn btn-secondary me-2">
                                <i class="fas fa-undo"></i> Reset
                            </button>
                            <button type="button" id="btn-export-pdf" class="btn btn-danger me-2">
                                <i class="fas fa-file-pdf"></i> PDF
                            </button>
                            <button type="button" id="btn-export-excel" class="btn btn-success">
                                <i class="fas fa-file-excel"></i> Excel
                            </button>
                        </div>
                    </div>

                    <!-- Alert Container -->
                    <div id="alert-container"></div>

                    <table id="penyulangan-table" class="display table table-striped table-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th>Tgl Komisioning</th>
                                <th>Nama Penyulang</th>
                                <th>Gardu Induk</th>
                                <th>Wilayah DCC</th>
                                <th>Catatan</th>
                                <th>PIC Master</th>
                                <th>PIC RTU</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                        <tfoot>
                            <tr>
                                <th><input type="text" placeholder="Filter Tgl" class="form-control form-control-sm" />
                                </th>
                                <th><input type="text" placeholder="Filter Nama" class="form-control form-control-sm" />
                                </th>
                                <th><input type="text" placeholder="Filter GI" class="form-control form-control-sm" />
                                </th>
                                <th><input type="text" placeholder="Filter DCC" class="form-control form-control-sm" />
                                </th>
                                <th><input type="text" placeholder="Filter Catatan"
                                        class="form-control form-control-sm" /></th>
                                <th><input type="text" placeholder="Filter Master"
                                        class="form-control form-control-sm" /></th>
                                <th><input type="text" placeholder="Filter RTU" class="form-control form-control-sm" />
                                </th>
                                <th></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<input type="hidden" id="auto-filter-flag" value="{{ request('auto_filter') ? '1' : '0' }}">
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    console.log('=== Penyulangan Page Loaded ===');
    console.log('jQuery version:', $.fn.jquery);
    console.log('DataTables available:', typeof $.fn.DataTable);

    var autoFilter = $('#auto-filter-flag').val() === '1';
    var csrfToken = $('meta[name="csrf-token"]').attr('content');

    function showAlert(type, message) {
        var alertClass = 'alert-' + type;
        var alertHtml = '<div class="alert ' + alertClass + ' alert-dismissible fade show" role="alert">' +
            message +
            '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' +
            '</div>';
        $('#alert-container').html(alertHtml);
        setTimeout(function() {
            $('#alert-container .alert').fadeOut();
        }, 5000);
    }

    function exportTo(type) {
        var from = $('#dari-tanggal').val();
        var to = $('#sampai-tanggal').val();
        var category = $('#filter-category').val();

        if (!from || !to) {
            showAlert('warning', 'Silakan pilih rentang tanggal terlebih dahulu!');
            return;
        }

        var url = '/penyulangan/export/' + type + '?from=' + from + '&to=' + to;
        if (category) {
            url += '&category=' + category;
        }
        window.open(url, '_blank');
    }

    $('#btn-export-pdf').click(function() {
        exportTo('pdf');
    });
    $('#btn-export-excel').click(function() {
        exportTo('excel');
    });

    // Destroy existing DataTable if exists
    if ($.fn.DataTable.isDataTable('#penyulangan-table')) {
        $('#penyulangan-table').DataTable().destroy();
    }

    // Initialize DataTable
    var table = $('#penyulangan-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '{{ route("penyulangan.data") }}',
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            data: function(d) {
                d.from_date = $('#dari-tanggal').val();
                d.to_date = $('#sampai-tanggal').val();
                d.category = $('#filter-category').val();
            },
            error: function(xhr, error, thrown) {
                console.error('Ajax Error:', error);
                console.error('Status:', xhr.status);
                console.error('Response:', xhr.responseText);
                showAlert('danger', 'Error loading data: ' + error);
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
                name: 'id_gi',
                defaultContent: '-'
            },
            {
                data: 'id_rtugi',
                name: 'id_rtugi',
                defaultContent: '-'
            },
            {
                data: 'catatanpeny',
                name: 'catatanpeny',
                defaultContent: '-'
            },
            {
                data: 'nama_user',
                name: 'nama_user',
                defaultContent: '-'
            },
            {
                data: 'id_pelrtu',
                name: 'id_pelrtu',
                defaultContent: '-'
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
            processing: '<i class="fas fa-spinner fa-spin fa-2x"></i> Loading...',
            emptyTable: "No data available"
        }
    });

    // Auto filter from dashboard
    if (autoFilter && ($('#dari-tanggal').val() || $('#sampai-tanggal').val() || $('#filter-category').val())) {
        setTimeout(function() {
            table.draw();
            showAlert('info', 'Filter otomatis dari Dashboard telah diterapkan.');
        }, 500);
    }

    // Event handlers
    $('#btn-filter').click(function() {
        table.draw();
    });

    $('#btn-reset').click(function() {
        $('#dari-tanggal').val('');
        $('#sampai-tanggal').val('');
        $('#filter-category').val('');
        window.history.replaceState({}, document.title, window.location.pathname);
        table.draw();
    });

    $('#penyulangan-table tfoot input').on('keyup change clear', function() {
        var column = table.column($(this).closest('th').index());
        column.search(this.value).draw();
    });

    $('#filter-category, #dari-tanggal, #sampai-tanggal').change(function() {
        table.draw();
    });
});
</script>
@endpush
