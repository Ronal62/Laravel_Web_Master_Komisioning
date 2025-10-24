@extends('layout.app')

@section('title', 'Add Pelaksana Master II')

@section('content')
<div class="page-inner">
    <div class="page-header">
        <h3 class="fw-bold mb-3">Tambah Pelaksana Master II</h3>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Tambah Pelaksana Master II</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('picmaster.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="nama_picmaster">Nama Pelaksana</label>
                            <input type="text" name="nama_picmaster" id="nama_picmaster" class="form-control"
                                value="{{ old('nama_picmaster') }}" required>
                            @error('nama_picmaster')
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
                        <a href="{{ route('picmaster.index') }}" class="btn btn-secondary mt-2 mx-auto">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
