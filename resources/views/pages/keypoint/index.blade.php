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
                                @forelse ($keypoints as $keypoint)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($keypoint->tgl_komisioning)->format('l, d-m-Y') }}</td>
                                    <td>{{ $keypoint->nama_keypoint }}</td>
                                    <td>{{ $keypoint->gi_penyulang }}</td>
                                    <td>{{ $keypoint->merk_modem_rtu ?? 'N/A' }}</td> <!-- Handle null values -->
                                    <td>{{ $keypoint->keterangan }}</td>
                                    <td>{{ $keypoint->master }}</td>
                                    <td>
                                        <a href="{{ route('keypoint.clone', $keypoint->id_formkp) }}"
                                            class="btn btn-icon btn-round btn-primary">
                                            <i class="far fa-clone"></i>
                                        </a>
                                        <a href="{{ route('keypoint.edit', $keypoint->id_formkp) }}" type="button"
                                            class="btn btn-icon btn-round btn-warning">
                                            <i class="fa fa-pen"></i>
                                        </a>
                                        <a href="{{ route('keypoint.note', $keypoint->id_formkp) }}" type="button"
                                            class="btn btn-icon btn-round btn-success">
                                            <i class="far fa-sticky-note"></i>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center">No data available</td>
                                </tr>
                                @endforelse
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
