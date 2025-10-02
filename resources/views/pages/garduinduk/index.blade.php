@extends('layout.app')

@section('title', 'Gardu Induk')

@section('content')
<div class="page-inner">
    <div class="page-header">
        <h3 class="fw-bold mb-3">Data Gardu Induk</h3>
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
                <a href="{{ route('gardu.index') }}">Data Gardu Induk</a>
            </li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Data Gardu Induk</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <form action="{{ route('gardu.add') }}" method="GET" style="display:inline;">
                                    <button type="submit" class="btn btn-primary">
                                        <span class="btn-label">
                                            <i class="fas fa-plus"></i>
                                        </span>
                                        Tambah Gardu Induk
                                    </button>
                                </form>
                            </div>
                        </div>
                        <table id="multi-filter-select" class="display table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Gardu Induk</th>
                                    <th>Nama DCC</th>
                                    <th>Alamat</th>
                                    <th>IP</th>
                                    <th>No HP</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Gardu Induk</th>
                                    <th>Nama DCC</th>
                                    <th>Alamat</th>
                                    <th>IP</th>
                                    <th>No HP</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @isset($garduinduks)
                                @forelse ($garduinduks as $index => $garduinduk)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $garduinduk->nama_gi }}</td>
                                    <td>{{ $garduinduk->nama_dcc }}</td>
                                    <td>{{ $garduinduk->alamat_gi }}</td>
                                    <td>{{ $garduinduk->ip_gi }}</td>
                                    <td>{{ $garduinduk->no_hp }}</td>
                                    <td>
                                        <a href="{{ route('gardu.show', $garduinduk->id_gi) }}" type="button"
                                            class="btn btn-icon btn-round btn-primary">
                                            <i class="far fa-clone"></i>
                                        </a>
                                        <a href="{{ route('gardu.edit', $garduinduk->id_gi) }}" type="button"
                                            class="btn btn-icon btn-round btn-warning">
                                            <i class="fa fa-pen"></i>
                                        </a>
                                        <form action="{{ route('gardu.destroy', $garduinduk->id_gi) }}" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-icon btn-round btn-danger"
                                                onclick="return confirm('Are you sure you want to delete this garduinduk?')">
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
