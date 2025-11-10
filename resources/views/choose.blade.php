@extends('layout.authapp')

@section('title', 'choose')

@section('content')
<div class="login-card">
    <div class="logo">
        <img src="logopln1.png" alt="PLN Logo">
        <h1>PLN Login</h1>
    </div>
    <form class="choice-form">
        <div class="form-group">
            <a href="{{ route('login') }}" class="btn-link">Web Komisioning</a>
        </div>
        <div class="form-group">
            <a href="http://10.5.19.55:8080" class="btn-link secondary">Web Beban Induk</a>
        </div>
    </form>
    <div class="tagline">Terangi Nusantara, Wujudkan Indonesia Terang ⚡</div>
</div>
@endsection