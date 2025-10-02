@extends('layout.app')

@section('title', 'Edit Gardu Induk')

@section('content')
<div class="page-inner">
    <div class="page-header">
        <h3 class="fw-bold mb-3">Edit Gardu Induk</h3>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Edit Gardu Induk</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('gardu.update', $gardu->id_gi) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="nama_gi">Nama Gardu Induk</label>
                            <input type="text" name="nama_gi" value="{{ old('nama_gi', $gardu->nama_gi) }}"
                                class="form-control" maxlength="25" required>
                        </div>
                        <div class="form-group">
                            <label for="nama_dcc">Nama DCC</label>
                            <input type="text" name="nama_dcc" value="{{ old('nama_dcc', $gardu->nama_dcc) }}"
                                class="form-control" maxlength="10" required>
                        </div>
                        <div class="form-group">
                            <label for="alamat_gi">Alamat</label>
                            <input type="text" name="alamat_gi" value="{{ old('alamat_gi', $gardu->alamat_gi) }}"
                                class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="ip_gi">IP</label>
                            <input type="text" name="ip_gi" value="{{ old('ip_gi', $gardu->ip_gi) }}"
                                class="form-control" maxlength="15" required>
                        </div>
                        <div class="form-group">
                            <label for="no_hp">No HP</label>
                            <input type="text" name="no_hp" value="{{ old('no_hp', $gardu->no_hp) }}"
                                class="form-control" maxlength="12" required>
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
                        <button type="submit" class="btn btn-primary mt-2 mx-2">Update Gardu Induk</button>
                        <a href="{{ route('gardu.index') }}" class="btn btn-secondary mt-2 mx-auto">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
