@extends('layout.app')

@section('title', 'Add Pelaksana RTU')

@section('content')
<div class="page-inner">
    <div class="page-header">
        <h3 class="fw-bold mb-3">Tambah Pelaksana RTU</h3>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Tambah Pelaksana RTU</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('pelrtu.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="nama_pelrtu">Nama Pelaksana RTU</label>
                            <input type="text" name="nama_pelrtu" id="nama_pelrtu" class="form-control"
                                value="{{ old('nama_pelrtu') }}" required>
                            @error('nama_pelrtu')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="foto_ttd">Upload Tanda Tangan</label>
                            <input type="file" name="foto_ttd" id="foto_ttd" class="form-control" accept="image/png"
                                value="{{ old('foto_ttd') }}" required>
                            @error('foto_ttd')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        @if (session('error'))
                        <p class="error" id="error-msg">⚠️ {{ session('error') }}</p>
                        @endif
                        @if (session('success'))
                        <p class="success" id="success-msg">✅ {{ session('success') }}</p>
                        @endif
                        <button type="submit" class="btn btn-primary mt-2 mx-2">Add</button>
                        <a href="{{ route('pelrtu.index') }}" class="btn btn-secondary mt-2 mx-auto">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection