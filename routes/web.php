<?php

use App\Http\Controllers\CardWisata;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MapController;
use App\Http\Controllers\WisataController;
use App\Http\Controllers\KomentarController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\StatistikController;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;
use App\Http\Controllers\GeojsonController;

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
Route::post('/wisata/{id}/uploadGambar', [MapController::class, 'uploadGambar'])->name('wisata.uploadGambar');

    

// routes/web.php



Route::middleware('auth:admin')->group(function() {
    Route::get('crud-wisata', [WisataController::class, 'index'])->name('data.show');
    Route::get('create-wisata', [WisataController::class, 'create'])->name('crud.create');
    Route::post('wisata', [WisataController::class, 'store'])->name('crud.store');
    Route::get('wisata/{crud}/edit', [WisataController::class, 'edit'])->name('crud.edit');
    Route::patch('wisata/{crud}/update', [WisataController::class, 'update'])->name('crud.update');
    Route::delete('wisata/{crud}', [WisataController::class, 'destroy'])->name('crud.destroy');
    Route::get('wisata/{crud}', [WisataController::class, 'show'])->name('crud.show');
    Route::post('/wisata/{id}/delete-single-gambar-lain', [WisataController::class, 'deleteSingleGambarLain'])->name('wisata.deleteSingleGambarLain');

});


Route::get('/card', [CardWisata::class, 'index'])->name('card.index');
Route::get('/wisata', [CardWisata::class, 'index'])->name('wisata.index');



Route::post('/wisata/{id_wisata}/komentars', [KomentarController::class, 'store'])->name('komentars.store');
Route::get('/wisata/{id_wisata}/komentars', [KomentarController::class, 'index'])->name('komentars.index');




Route::get('/admin/login', [AdminController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminController::class, 'login']);
Route::post('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');


Route::get('/statistik', [StatistikController::class, 'index'])->name('statistik');




Route::middleware('auth:admin')->group(function() {
Route::get('/geojson', [GeojsonController::class, 'index'])->name('geojson.index');
Route::post('/geojson/upload', [GeojsonController::class, 'upload'])->name('geojson.upload');
Route::delete('/geojson/delete/{id}', [GeojsonController::class, 'delete'])->name('geojson.delete');
});




