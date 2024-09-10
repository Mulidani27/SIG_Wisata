<?php

use App\Http\Controllers\CardWisata;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MapController;
use App\Http\Controllers\WisataController;
use App\Http\Controllers\KomentarController;
use App\Http\Controllers\AdminController;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/wisataa', function () {
    return view('mapswisata');
});

Route::get('/coba', function () {
    return view('coba');
});

Route::get('/wisata', function () {
    return view('mapswisata');
})->name('wisata');

Route::get('wisata/map/{map}', [MapController::class, 'index'])->name('map.show');
Route::get('wisata/view/{map}', [MapController::class, 'viewlokasi'])->name('map.view');


    

// routes/web.php



Route::middleware('auth:admin')->group(function() {
    Route::get('crud-wisata', [WisataController::class, 'index'])->name('data.show');
    Route::get('create-wisata', [WisataController::class, 'create'])->name('crud.create');
    Route::post('wisata', [WisataController::class, 'store'])->name('crud.store');
    Route::get('wisata/{crud}/edit', [WisataController::class, 'edit'])->name('crud.edit');
    Route::patch('wisata/{crud}/update', [WisataController::class, 'update'])->name('crud.update');
    Route::delete('wisata/{crud}', [WisataController::class, 'destroy'])->name('crud.destroy');
    Route::get('wisata/{crud}', [WisataController::class, 'show'])->name('crud.show');
});
Route::get('/data/show', [WisataController::class, 'show'])->name('data.show')->middleware('admin');

Route::get('/card', [CardWisata::class, 'index'])->name('card.index');
Route::get('/wisata', [CardWisata::class, 'index'])->name('wisata.index');


Route::get('/komentar', [KomentarController::class, 'index'])->name('komentar.index');
Route::post('/komentar/kirim', [KomentarController::class, 'kirimKomentar'])->name('komentar.kirim');





Route::get('/admin/login', [AdminController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminController::class, 'login']);
Route::post('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');
Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->middleware('auth:admin')->name('dashboard');



