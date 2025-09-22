@extends('layout.app')

@section('title', 'admin')

@section('content')
<div class="page-inner">
    <div class="page-header">
        <h3 class="fw-bold mb-3">Data Admin</h3>
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
                <a href="{{ route('admin.index') }}">Data Admin</a>
            </li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Data Admin</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <form action="{{ route('admin.add') }}" method="GET" style="display:inline;">
                                    <button type="submit" class="btn btn-primary">
                                        <span class="btn-label">
                                            <i class="fas fa-plus"></i>
                                        </span>
                                        Tambah Admin
                                    </button>
                                </form>
                            </div>
                        </div>
                        <table id="multi-filter-select" class="display table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Admin</th>
                                    <th>Username</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Admin</th>
                                    <th>Username</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @isset($admins)
                                @forelse ($admins as $index => $admin)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $admin->nama_admin }}</td>
                                    <td>{{ $admin->username }}</td>
                                    <td>
                                        <a href="{{ route('admin.show', $admin->id_admin) }}" type="button"
                                            class="btn btn-icon btn-round btn-primary">
                                            <i class="far fa-clone"></i>
                                        </a>
                                        <a href="{{ route('admin.edit', $admin->id_admin) }}" type="button"
                                            class="btn btn-icon btn-round btn-warning">
                                            <i class="fa fa-pen"></i>
                                        </a>
                                        <form action="{{ route('admin.destroy', $admin->id_admin) }}" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-icon btn-round btn-danger"
                                                onclick="return confirm('Are you sure you want to delete this admin?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center">No data available</td>
                                </tr>
                                @endforelse
                                @else
                                <tr>
                                    <td colspan="4" class="text-center">No data available</td>
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
