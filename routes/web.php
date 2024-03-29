<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ListTokoController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

// Route FRONTEND
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('welcome');
Route::resource('detail',(HomeController::class));
Route::get('rute/{id}',[ListTokoController::class,'getRoute'])->name('cek-rute');
Route::post('posts',[HomeController::class,'storeRatings'])->name('store-ratings');
Route::get('/toko', [App\Http\Controllers\ListTokoController::class, 'index'])->name('toko');
Route::get('/detailtoko/{id}', [App\Http\Controllers\DetailTokoController::class, 'show'])->name('detailtoko');
// Route Rating Toko
Route::post('detailtoko',[\App\Http\Controllers\DetailTokoController::class,'tambahRating'])->name('toko.tambahRating');
Route::get('detail-foto/{id}',[\App\Http\Controllers\DetailTokoController::class,'detailProduk'])->name('toko.detailFoto');

Route::get('dashboard',[\App\Http\Controllers\Backend\Dashboard::class,'index'])->name('dashboard');

// Route Toko
Route::get('data-toko',[\App\Http\Controllers\Backend\TokoController::class,'index'])->name('toko.listToko');
Route::get('tambah-toko',[\App\Http\Controllers\Backend\TokoController::class,'create'])->name('toko.tambahToko');
Route::post('simpan-toko',[\App\Http\Controllers\Backend\TokoController::class,'store'])->name('toko.simpanToko');
Route::post('ubah-toko',[\App\Http\Controllers\Backend\TokoController::class,'update'])->name('toko.ubahToko');
Route::get('list-toko',[\App\Http\Controllers\Backend\TokoController::class,'listToko'])->name('list-toko');
Route::get('edit-toko/{id}',[\App\Http\Controllers\Backend\TokoController::class,'edit'])->name('toko.editToko');

Route::delete('hapus-toko/{id}',[\App\Http\Controllers\Backend\TokoController::class,'destroy'])->name('toko.hapusToko');
Route::get('detail-toko/{id}',[\App\Http\Controllers\Backend\TokoController::class,'detailToko'])->name('toko.detailToko');

// Route Galeri Produk
Route::post('simpan-produk',[\App\Http\Controllers\Backend\TokoController::class,'simpanProduk'])->name('toko.simpanProduk');
Route::delete('hapus-foto-produk/{id}',[\App\Http\Controllers\Backend\TokoController::class,'hapusFotoProduk'])->name('toko.hapusFotoProduk');
Route::get('detail-produk/{id}',[\App\Http\Controllers\Backend\TokoController::class,'detailProduk'])->name('toko.detailProduk');
Route::get('edit-produk/{id}',[\App\Http\Controllers\Backend\TokoController::class,'editProduk'])->name('toko.editProduk');
Route::put('update-produk',[\App\Http\Controllers\Backend\TokoController::class,'updateProduk'])->name('toko.updateProduk');

// Route User
Route::post('update-user',[\App\Http\Controllers\Backend\UserController::class,'update'])->name('user.update');
