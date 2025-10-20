<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\KeypointController;
use App\Http\Controllers\ExportPdfController;
use App\Http\Controllers\GarduindukController;
use App\Http\Controllers\MerklbsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ModemController;
use App\Http\Controllers\SectoralController;;
use App\Http\Controllers\PenyulanganController;

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

    //Gardu Induk
    Route::resource('garduindux', GarduindukController::class);

    // Dashboard route
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // Admin resource routes (excluding create)
    Route::resource('admin', AdminController::class)->except(['create']);

    // Keypoint routes
    Route::resource('keypoint', KeypointController::class);
    Route::get('/keypoint/{id}/clone', [KeypointController::class, 'clone'])->name('keypoint.clone');
    Route::post('/keypoint/clone', [KeypointController::class, 'storeClone'])->name('keypoint.clone.store');
    Route::get('/keypoint/data', [KeypointController::class, 'data'])->name('keypoint.data');
    Route::post('/keypoint/data', [KeypointController::class, 'data'])->name('keypoint.data');


    Route::get('/keypoint/export/pdf', [KeypointController::class, 'exportPdfFiltered'])->name('keypoint.exportpdfall');
    Route::get('/keypoint/export/excel', [KeypointController::class, 'exportExcelFiltered'])->name('keypoint.exportexcelall');


    Route::get('/keypoint/{id}/exportpdf', [ExportPdfController::class, 'exportpdf'])->name('keypoint.exportpdf');



    // Penyulangan routes
    Route::resource('penyulangan', PenyulanganController::class);
    Route::get('/penyulangan/{id}/clone', [PenyulanganController::class, 'clone'])->name('penyulangan.clone');
    Route::post('/penyulangan/clone', [PenyulanganController::class, 'storeClone'])->name('penyulangan.clone.store');
    Route::get('/penyulangan/data', [PenyulanganController::class, 'data'])->name('penyulangan.data');
    Route::post('/penyulangan/data', [PenyulanganController::class, 'data'])->name('penyulangan.data');
    Route::get('/penyulangan/export/pdf', [PenyulanganController::class, 'exportPdfFiltered'])->name('penyulangan.exportpdfall');
    Route::get('/penyulangan/export/excel', [PenyulanganController::class, 'exportExcelFiltered'])->name('penyulangan.exportexcelall');






    // Forms
    Route::get('/absen', function () {
        return view('pages.absen.index');
    })->name('absen');
    // Data
    Route::get('/data', function () {
        return view('pages.data.index');
    })->name('data');
    Route::get('/data/keypoint', [KeypointController::class, 'index'])->name('data.keypoint');
    Route::get('/data/penyulangan', [PenyulanganController::class, 'index'])->name('data.penyulangan');
    Route::get('/data/absen', function () {
        return view('pages.data.absen');
    })->name('data.absen');

    // Data Pengusahaan
    Route::prefix('datapengusahaan')->group(function () {
        // Gardu Induk routes
        Route::get('gardu', [GarduindukController::class, 'index'])->name('gardu.index');
        Route::get('gardu/add', [GarduindukController::class, 'create'])->name('gardu.add');
        Route::post('gardu', [GarduindukController::class, 'store'])->name('gardu.store');
        Route::get('gardu/{gardu}', [GarduindukController::class, 'show'])->name('gardu.show');
        Route::get('gardu/{gardu}/edit', [GarduindukController::class, 'edit'])->name('gardu.edit');
        Route::put('gardu/{gardu}', [GarduindukController::class, 'update'])->name('gardu.update');
        Route::delete('gardu/{gardu}', [GarduindukController::class, 'destroy'])->name('gardu.destroy');

        // Merk LBS routes
        Route::get('merk', [MerklbsController::class, 'index'])->name('merk.index');
        Route::get('merk/add', [MerklbsController::class, 'create'])->name('merk.add');
        Route::post('merk', [MerklbsController::class, 'store'])->name('merk.store');
        Route::get('merk/{merk}/edit', [MerklbsController::class, 'edit'])->name('merk.edit');
        Route::put('merk/{merk}', [MerklbsController::class, 'update'])->name('merk.update');
        Route::delete('merk/{merk}', [MerklbsController::class, 'destroy'])->name('merk.destroy');


        // Modem routes
        Route::get('modem', [ModemController::class, 'index'])->name('modem.index');
        Route::get('modem/add', [ModemController::class, 'create'])->name('modem.add');
        Route::post('modem', [ModemController::class, 'store'])->name('modem.store');
        Route::get('modem/{modem}/edit', [ModemController::class, 'edit'])->name('modem.edit');
        Route::put('modem/{modem}', [ModemController::class, 'update'])->name('modem.update');
        Route::delete('modem/{modem}', [ModemController::class, 'destroy'])->name('modem.destroy');

        //sectoral routes
        Route::get('sectoral', [SectoralController::class, 'index'])->name('sectoral.index');
        Route::get('sectoral/add', [SectoralController::class, 'create'])->name('sectoral.add');
        Route::post('sectoral', [SectoralController::class, 'store'])->name('sectoral.store');
        Route::get('sectoral/{sectoral}/edit', [SectoralController::class, 'edit'])->name('sectoral.edit');
        Route::put('sectoral/{sectoral}', [SectoralController::class, 'update'])->name('sectoral.update');
        Route::delete('sectoral/{sectoral}', [SectoralController::class, 'destroy'])->name('sectoral.destroy');



        // Placeholder routes for other menu items
        // Route::get('lbs', [LbsController::class, 'index'])->name('lbs.index');
        // Route::get('modem', [ModemController::class, 'index'])->name('modem.index');
        // Route::get('sectoral', [SectoralController::class, 'index'])->name('sectoral.index');
    });
});
