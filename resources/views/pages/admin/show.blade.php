@extends('layout.app')

@section('title', 'Show Admin')

@section('content')
<div class="page-inner">
    <div class="page-header">
        <h3 class="fw-bold mb-3">Detail Admin</h3>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Admin: {{ $admin->nama_admin }}</h4>
                </div>
                <div class="card-body">
                    <p><strong>Nama:</strong> {{ $admin->nama_admin }}</p>
                    <p><strong>Username:</strong> {{ $admin->username }}</p>
                    <a href="{{ route('admin.index') }}" class="btn btn-primary">Back to List</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
