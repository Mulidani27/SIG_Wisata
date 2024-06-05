<?php

use App\Http\Controllers\CardWisata;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MapController;
use App\Http\Controllers\WisataController;
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



route::get('crud-wisata', [WisataController::class,'index'])->name("data.show");
route::get('create-wisata', [WisataController::class,'create'])->name("crud.create");
route::post('wisata', [WisataController::class,'store'])->name("crud.store");
route::get('wisata/{crud}/edit', [WisataController::class,'edit'])->name("crud.edit");
route::patch('wisata/{crud}/update', [WisataController::class,'update'])->name("crud.update");
route::delete('wisata/{crud}', [WisataController::class,'destroy'])->name("crud.destroy");
route::get('wisata/{crud}', [WisataController::class,'show'])->name("crud.show");



Route::get('/card', [CardWisata::class, 'index'])->name('card.index');
