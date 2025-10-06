@extends('layout.app')

@section('title', 'Edit Modem')

@section('content')
<div class="page-inner">
    <div class="page-header">
        <h3 class="fw-bold mb-3">Edit Modem</h3>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Edit Mode,</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('modem.update', $modem->id_modem) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="nama_modem">Nama Modem</label>
                            <input type="text" name="nama_modem" id="nama_modem" class="form-control"
                                value="{{ old('nama_modem', $modem->nama_modem) }}" required>
                            @error('nama_modem')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="sinyal">Sinyal</label>
                            <input type="text" name="sinyal" id="sinyal" class="form-control"
                                value="{{ old('sinyal', $modem->sinyal) }}" required>
                            @error('sinyal')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        @if (session('error'))
                        <p class="error" id="error-msg">⚠️ {{ session('error') }}</p>
                        @endif
                        @if (session('success'))
                        <p class="success" id="success-msg">✅ {{ session('success') }}</p>
                        @endif
                        <button type="submit" class="btn btn-primary mt-2 mx-2">Update Merk LBS</button>
                        <a href="{{ route('modem.index') }}" class="btn btn-secondary mt-2 mx-auto">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
