    @extends('layout.app')

    @section('title', 'Data Absensi')

    @section('content')
    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3">Data Absensi</h3>
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
                    <a href="#">Data Absensi</a>
                </li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row mb-6">
                            <div class="col-md-2">
                                <h4 class="card-title">Data Absensi</h4>
                            </div>
                        </div>
                        <form action="{{ route('absen.create') }}" method="GET" style="display:inline;">
                            <button type="submit" class="btn btn-primary ">
                                <span class="btn-label">
                                    <i class="fas fa-plus"></i>
                                </span>
                                Form Absensi
                            </button>
                        </form>
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
                            </div>
                            <table id="absen-table" class="display table table-striped table-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Tgl Absen</th>
                                        <th>Waktu</th>
                                        <th>Nama Pegawai</th>
                                        <th>Jenis Absen</th>
                                        <th>Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                                <tfoot>
                                    <tr>
                                        <th><input type="text" placeholder="Filter Tgl" class="form-control" /></th>
                                        <th><input type="text" placeholder="Filter Waktu" class="form-control" /></th>
                                        <th><input type="text" placeholder="Filter Nama Pegawai" class="form-control" />
                                        </th>
                                        <th><input type="text" placeholder="Filter Jenis Absen" class="form-control" />
                                        </th>
                                        <th><input type="text" placeholder="Filter Keterangan" class="form-control" />
                                        </th>
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
$(document).ready(function() {
    if ($.fn.DataTable.isDataTable('#absen-table')) {
        $('#absen-table').DataTable().destroy();
    }

    var table = $('#absen-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('absen.data') }}",
            type: 'POST',
            data: function(d) {
                d.dari_tanggal = $('#dari-tanggal').val();
                d.sampai_tanggal = $('#sampai_tanggal').val();
                d._token = $('meta[name="csrf-token"]').attr('content');
            },
            error: function(xhr, error, thrown) {
                console.error('AJAX Error:', xhr.responseText);
                alert('An error occurred while loading data. Please try again.');
            }
        },
        columns: [{
                data: 'tgl_absen',
                name: 'tgl_absen'
            },
            {
                data: 'waktu',
                name: 'waktu'
            },
            {
                data: 'nama_absen',
                name: 'nama_absen'
            },
            {
                data: 'jenis_absen',
                name: 'jenis_absen'
            },
            {
                data: 'ket_absen',
                name: 'ket_absen'
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

    $('#absen-table tfoot input').on('keyup change clear', function() {
        var column = table.column($(this).closest('th').index());
        column.search(this.value).draw();
    });

    $('#dari-tanggal, #sampai-tanggal').change(function() {
        table.draw();
    });
});
    </script>
    @endsection
