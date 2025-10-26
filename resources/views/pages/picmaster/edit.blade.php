@extends('layout.app')

@section('title', 'Edit Pelaksana Master II')

@section('content')
<div class="page-inner">
    <div class="page-header">
        <h3 class="fw-bold mb-3">Edit Pelaksana Master II</h3>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Edit Pelaksana Master II</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('picmaster.update', $picmaster->id_picmaster) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="nama_picmaster">Nama Pelaksana</label>
                            <input type="text" name="nama_picmaster" id="nama_picmaster" class="form-control"
                                value="{{ old('nama_picmaster', $picmaster->nama_picmaster) }}" required>
                            @error('nama_picmaster')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="foto_ttd">Upload Tanda Tangan</label>

                            <!-- Display current signature -->
                            @if($picmaster->foto_ttd)
                            <div class="mb-2">
                                <label class="d-block text-muted small">Tanda Tangan Saat Ini:</label>
                                <img src="{{ asset('storage/' . $picmaster->foto_ttd) }}" alt="Current Signature"
                                    class="img-thumbnail"
                                    style="max-width: 200px; max-height: 100px; object-fit: contain;">
                            </div>
                            @endif

                            <input type="file" name="foto_ttd" id="foto_ttd" class="form-control" accept="image/png">
                            <small class="form-text text-muted">Biarkan kosong jika tidak ingin mengubah tanda
                                tangan</small>

                            @error('foto_ttd')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            ⚠️ {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        @endif

                        @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            ✅ {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        @endif

                        <div class="mt-3">
                            <button type="submit" class="btn btn-primary">Update</button>
                            <a href="{{ route('picmaster.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection