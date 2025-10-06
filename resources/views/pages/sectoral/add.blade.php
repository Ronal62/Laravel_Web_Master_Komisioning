@extends('layout.app')

@section('title', 'Add Sectoral')

@section('content')
<div class="page-inner">
    <div class="page-header">
        <h3 class="fw-bold mb-3">Tambah Sectoral</h3>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Tambah Sectoral Baru</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('sectoral.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="nama_sec">Nama Sectoral</label>
                            <input type="text" name="nama_sec" id="nama_sec" class="form-control"
                                value="{{ old('nama_sec') }}" required>
                            @error('nama_sec')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        @if (session('error'))
                        <p class="error" id="error-msg">⚠️ {{ session('error') }}</p>
                        @endif
                        @if (session('success'))
                        <p class="success" id="success-msg">✅ {{ session('success') }}</p>
                        @endif
                        <button type="submit" class="btn btn-primary mt-2 mx-2">Add Sectoral</button>
                        <a href="{{ route('sectoral.index') }}" class="btn btn-secondary mt-2 mx-auto">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
