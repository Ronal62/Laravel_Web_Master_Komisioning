@extends('layout.authapp')

@section('title', 'login')

@section('content')
<div class="login-card">
    <div class="logo">
        <img src="logopln1.png" alt="PLN Logo">
        <h1>PLN Login</h1>
    </div>
    <div class="form-group">
        <label for="username">Username</label>
        <input type="text" id="username" placeholder="Masukkan username">
    </div>
    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" id="password" placeholder="Masukkan password">
    </div>
    <button class="btn" onclick="login()">Masuk</button>
    <p class="error" id="error-msg">⚠️ Username atau password salah!</p>
    <p class="success" id="success-msg">✅ Login berhasil!</p>
    <div class="tagline">Terangi Nusantara, Wujudkan Indonesia Terang ⚡</div>
</div>
@endsection
