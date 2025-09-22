@extends('layout.app')

@section('title', 'Edit Admin')

@section('content')
<div class="page-inner">
    <div class="page-header">
        <h3 class="fw-bold mb-3">Edit Admin</h3>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Edit Admin: {{ $admin->nama_admin }}</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.update', $admin->id_admin) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="nama_admin">Nama Admin</label>
                            <input type="text" name="nama_admin" class="form-control" value="{{ $admin->nama_admin }}"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" name="username" class="form-control" value="{{ $admin->username }}"
                                required>
                        </div>

                        <div class="form-group">
                            <label for="password">Password (leave blank to keep unchanged)</label>
                            <input type="password" name="password" class="form-control">

                        </div>
                        @if ($errors->any())
                        <p class="error" id="error-msg">⚠️ {{ $errors->first() }}</p>
                        @endif
                        @if (session('error'))
                        <p class="error" id="error-msg">⚠️ {{ session('error') }}</p>
                        @endif
                        @if (session('success'))
                        <p class="success" id="success-msg">✅ {{ session('success') }}</p>
                        @endif
                        <button type="submit" class="btn btn-primary">Update</button>
                        <a href="{{ route('admin.index') }}" class="btn btn-secondary">Cancel</a>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
