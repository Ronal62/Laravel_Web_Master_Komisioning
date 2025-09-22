<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\KeypointController;
use Illuminate\Support\Facades\Route;

// Root route (redirects to login)
Route::get('/', function () {
    return view('pages.auth.login');
})->name('login');

// Login POST route
Route::post('/login', [AdminController::class, 'login'])->name('login.post');

// Register routes
Route::get('/register', function () {
    return view('pages.auth.register');
})->name('register');
Route::post('/register', [AdminController::class, 'register'])->name('register.post');
Route::post('/admin', [AdminController::class, 'admin'])->name('admin.store');

// Logout route
Route::post('/logout', [AdminController::class, 'logout'])->name('logout');

Route::get('/admin/add', [AdminController::class, 'add'])->name('admin.add');

// Admin routes (protected by admin authentication)
Route::middleware('auth:admin')->group(function () {
    // Dashboard route
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // Admin resource routes (excluding create)
    Route::resource('admin', AdminController::class)->except(['create']);

    // Custom add route

    // Keypoint routes
    Route::resource('keypoint', KeypointController::class);
    Route::get('/keypoint/{keypoint}/note', [KeypointController::class, 'note'])->name('keypoint.note');

    // Forms
    Route::get('/feeder-inc', function () {
        return view('pages.feeder-inc.index');
    })->name('feeder-inc');
    Route::get('/absen', function () {
        return view('pages.absen.index');
    })->name('absen');

    // Data
    Route::get('/data', function () {
        return view('pages.data.index');
    })->name('data');
    Route::get('/data/keypoint', [KeypointController::class, 'index'])->name('data.keypoint');
    Route::get('/data/feeder', function () {
        return view('pages.data.feeder');
    })->name('data.feeder');
    Route::get('/data/absen', function () {
        return view('pages.data.absen');
    })->name('data.absen');

    // Data Pengusahaan
    Route::get('/datapengusahaan', function () {
        return view('pages.datapengusahaan.index');
    })->name('datapengusahaan');
    Route::get('/datapengusahaan/gardu', function () {
        return view('pages.gardu_induk.index');
    })->name('datapengusahaan.gardu');
    Route::get('/datapengusahaan/lbs', function () {
        return view('pages.merklbs.index');
    })->name('datapengusahaan.lbs');
    Route::get('/datapengusahaan/modem', function () {
        return view('pages.modem.index');
    })->name('datapengusahaan.modem');
    Route::get('/datapengusahaan/sectoral', function () {
        return view('pages.sectoral.index');
    })->name('datapengusahaan.sectoral');
});