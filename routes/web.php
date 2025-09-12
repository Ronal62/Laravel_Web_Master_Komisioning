<?php

use App\Http\Controllers\KeypointController;
use Illuminate\Support\Facades\Route;

// Root route (redirects to dashboard)
Route::get('/', function () {
    return view('pages.dashboard.index');
})->name('dashboard');

// Dashboard
Route::get('/dashboard', function () {
    return view('pages.dashboard.index');
})->name('dashboard');

// Forms
Route::get('/keypoint', function () {
    return view('pages.keypoint.add'); // Changed to add.blade.php for Keypoint in Forms
})->name('keypoint');
Route::get('/feeder-inc', function () {
    return view('pages.feeder-inc.index'); // Assuming a feeder-inc directory exists
})->name('feeder-inc');
Route::get('/absen', function () {
    return view('pages.absen.index');
})->name('absen');

// Data
Route::get('/data', function () {
    return view('pages.data.index');
})->name('data');
Route::get('/data/keypoint', function () {
    return view('pages.keypoint.index'); // Changed to index.blade.php for Data Keypoint
})->name('data.keypoint');
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


Route::get('/add', function () {
    return view('add');
})->name('keypoint.add');
Route::post('/keypoint', [KeypointController::class, 'store'])->name('keypoint.store');
