@extends('layout.authapp')

@section('title', 'register')

@section('content')
<div class="login-card">
    <div class="logo">
        <img src="logopln1.png" alt="PLN Logo">
        <h1>PLN Register</h1>
    </div>
    <form action="{{ route('register.post') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Nama</label>
            <input type="text" id="nama_admin" name="nama_admin" placeholder="Masukkan nama" required>
        </div>
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" placeholder="Masukkan username" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Masukkan password" required>
        </div>
        <button type="submit" class="btn">Register Now</button>
        @if ($errors->any())
        <p class="error" id="error-msg">⚠️ {{ $errors->first() }}</p>
        @endif
        @if (session('error'))
        <p class="error" id="error-msg">⚠️ {{ session('error') }}</p>
        @endif
        @if (session('success'))
        <p class="success" id="success-msg">✅ {{ session('success') }}</p>
        @endif
    </form>
    <div class="register-link tagline">
        <a class="link" href="{{ route('login') }}"><span class="sub-item">Already have an account? Login
                here</span></a>
    </div>
    <div class="tagline">Terangi Nusantara, Wujudkan Indonesia Terang ⚡</div>
</div>
@endsection
