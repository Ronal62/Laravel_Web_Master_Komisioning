<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\KeypointController;
use Illuminate\Support\Facades\Route;

// Root route (redirects to dashboard)
Route::get('/', function () {
    return view('pages.dashboard.index');
})->name('dashboard');

// Resource routes for Keypoint (defines index, create, store, show, edit, update, destroy)
Route::resource('keypoint', KeypointController::class);

// Alias for 'keypoint' route to point to index
Route::get('/keypoint', [KeypointController::class, 'index'])->name('keypoint');

// Custom route for note
Route::get('/keypoint/{keypoint}/note', [KeypointController::class, 'note'])->name('keypoint.note');

// Dashboard
Route::get('/dashboard', function () {
    return view('pages.dashboard.index');
})->name('dashboard');

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

// tb_admin
Route::resource('tb-admin', AdminController::class); // Or 'admins' as preferred
