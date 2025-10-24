@extends('layout.app')

@section('title', 'Form Absen')

@section('content')
<div class="page-inner">
    <div class="page-header">
        <h3 class="fw-bold mb-3">Form Absen</h3>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Form Absensi</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('absen.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="tgl_absen">Waktu Absen</label>
                            <input type="datetime-local" name="tgl_absen" class="form-control"
                                value="{{ now()->format('Y-m-d\TH:i') }} " readonly required>
                        </div>
                        <div class="form-group">
                            <label for="nama_absen">Nama Absen</label>
                            <input type="text" name="nama_absen" class="form-control"
                                value="{{ auth()->user()->nama_admin ?? '' }}" readonly required>
                        </div>
                        <div class="form-group">
                            <label for="jenis_absen">Jenis Absen</label>
                            <select class="form-control select2 @error('jenis_absen') is-invalid @enderror"
                                id="jenis_absen" name="jenis_absen">
                                <option value="">Pilih Jenis Absen</option>
                                @foreach ($jenisAbsens as $jenis)
                                <option value="{{ $jenis->jenis_absen }}"
                                    {{ old('jenis_absen') == $jenis->jenis_absen ? 'selected' : '' }}>
                                    {{ $jenis->jenis_absen }}
                                </option>
                                @endforeach
                            </select>
                            @error('jenis_absen')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="ket_absen">Keterangan Absen</label>
                            <input type="text" name="ket_absen" class="form-control" required>
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
                        <button type="submit" class="btn btn-primary mt-2 mx-2">Save</button>
                        <a href="{{ route('absen.index') }}" class="btn btn-secondary mt-2 mx-auto">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const now = new Date();
        const year = now.getFullYear();
        const month = String(now.getMonth() + 1).padStart(2, '0');
        const day = String(now.getDate()).padStart(2, '0');
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');

        const localDateTime = `${year}-${month}-${day}T${hours}:${minutes}`;
        document.querySelector('input[name="tgl_absen"]').value = localDateTime;
    });
</script>
@endsection
