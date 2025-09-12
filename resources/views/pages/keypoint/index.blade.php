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
                                <label for="sampai-tanggal" class="form-label">Export Data To :</label>
                                <button class="btn btn-danger">
                                    <span class="btn-label">
                                        <i class="fas fa-file-pdf"></i>
                                    </span>
                                    PDF
                                </button>
                                <button class="btn btn-success">
                                    <span class="btn-label">
                                        <i class="fas fa-file-excel"></i>
                                    </span>
                                    Excel
                                </button>
                            </div>
                        </div>
                        <table id="multi-filter-select" class="display table table-striped table-hover">
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
                            <tfoot>
                                <tr>
                                    <th>Tgl Komisioning</th>
                                    <th>Nama Keypoint</th>
                                    <th>GI & Penyulang</th>
                                    <th>Merk Modem & RTU</th>
                                    <th>Keterangan</th>
                                    <th>Master</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                <tr>
                                    <td>Monday, 10-06-2024</td>
                                    <td>LBSM 3 WAY ASDP (BWI_12)</td>
                                    <td>GI BANYUWANGI - P.KALIPURO/BOSOWA 1</td>
                                    <td>SANXING 4G - ABB REC 615</td>
                                    <td>PEMELIHARAAN</td>
                                    <td>RIZKY</td>
                                    <td>
                                        <a type="button" class="btn btn-icon btn-round btn-primary">
                                            <i class="far fa-clone"></i>
                                        </a>
                                        <a type="button" class="btn btn-icon btn-round btn-warning">
                                            <i class="fa fa-pen"></i>
                                        </a>
                                        <a type="button" class="btn btn-icon btn-round btn-success">
                                            <i class="far fa-sticky-note"></i>
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection

@section('scripts')
<script>
$("#lineChart").sparkline([102, 109, 120, 99, 110, 105, 115], {
    type: "line",
    height: "70",
    width: "100%",
    lineWidth: "2",
    lineColor: "#177dff",
    fillColor: "rgba(23, 125, 255, 0.14)",
});

$("#lineChart2").sparkline([99, 125, 122, 105, 110, 124, 115], {
    type: "line",
    height: "70",
    width: "100%",
    lineWidth: "2",
    lineColor: "#f3545d",
    fillColor: "rgba(243, 84, 93, .14)",
});

$("#lineChart3").sparkline([105, 103, 123, 100, 95, 105, 115], {
    type: "line",
    height: "70",
    width: "100%",
    lineWidth: "2",
    lineColor: "#ffa534",
    fillColor: "rgba(255, 165, 52, .14)",
});
</script>
<script>
$(document).ready(function() {
    $("#multi-filter-select").DataTable({
        pageLength: 5,
        initComplete: function() {
            this.api()
                .columns()
                .every(function() {
                    var column = this;
                    var select = $(
                            '<select class="form-select"><option value=""></option></select>'
                        )
                        .appendTo($(column.footer()).empty())
                        .on("change", function() {
                            var val = $.fn.dataTable.util.escapeRegex($(this).val());

                            column
                                .search(val ? "^" + val + "$" : "", true, false)
                                .draw();
                        });

                    column
                        .data()
                        .unique()
                        .sort()
                        .each(function(d, j) {
                            select.append(
                                '<option value="' + d + '">' + d + "</option>"
                            );
                        });
                });
        },
    });
});
</script>
@endsection
