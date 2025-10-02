@extends('layout.app')

@section('title', 'Merk LBS')

@section('content')
<div class="page-inner">
    <div class="page-header">
        <h3 class="fw-bold mb-3">Data Merk LBS</h3>
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
                <a href="{{ route('merk.index') }}">Data Merk LBS</a>
            </li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Data Merk LBS</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <form action="{{ route('merk.add') }}" method="GET" style="display:inline;">
                                    <button type="submit" class="btn btn-primary">
                                        <span class="btn-label">
                                            <i class="fas fa-plus"></i>
                                        </span>
                                        Tambah Merk LBS
                                    </button>
                                </form>
                            </div>
                        </div>
                        <table id="multi-filter-select" class="display table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Merk LBS</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Merk LBS</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @isset($merklbs)
                                @forelse ($merklbs as $index => $merklbs)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $merklbs->nama_merklbs }}</td>
                                    <td>
                                        </a>
                                        <a href="{{ route('merk.edit', $merklbs->id_merkrtu) }}" type="button"
                                            class="btn btn-icon btn-round btn-warning">
                                            <i class="fa fa-pen"></i>
                                        </a>
                                        <form action="{{ route('merk.destroy', $merklbs->id_merkrtu) }}" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-icon btn-round btn-danger"
                                                onclick="return confirm('Are you sure you want to delete this merk?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center">No data available</td>
                                </tr>
                                @endforelse
                                @else
                                <tr>
                                    <td colspan="7" class="text-center">No data available</td>
                                </tr>
                                @endisset
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
$(document).ready(function() {
    // Initialize DataTable with pageLength: 5
    var table = $("#multi-filter-select").DataTable({
        pageLength: 5,
        initComplete: function() {
            this.api()
                .columns()
                .every(function() {
                    var column = this;
                    var select = $(
                            '<select class="form-select"><option value="">All</option></select>'
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
                            select.append('<option value="' + d + '">' + d + "</option>");
                        });
                });
        }
    });

    // Ensure table is populated (optional fallback for empty data)
    if ($("#multi-filter-select tbody tr").length === 0) {
        $("#multi-filter-select tbody").append(
            '<tr><td colspan="7" class="text-center">No data available</td></tr>');
    }
});
</script>
@endsection
