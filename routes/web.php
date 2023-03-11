<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SpotController;
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
Route::get('/home', [App\Http\Controllers\HomeController::class, 'home'])->name('home');
Route::resource('detail',(HomeController::class));
Route::get('rute/{slug}',[HomeController::class,'getRoute'])->name('cek-rute');
Route::get('kategori-spot/{slug}',[HomeController::class,'getCategory'])->name('kategori-spot');
Route::post('posts',[HomeController::class,'storeRatings'])->name('store-ratings');

// Route BACKEND
Route::resource('spot',(SpotController::class));
Route::resource('category',(CategoryController::class));
Route::delete('/deleteimage/{id}',[SpotController::class,'deleteImage'])->name('delete-image');

// ROUTE DataTable
Route::get('data-category',[\App\Http\Controllers\DataController::class,'categories'])->name('data-category');
Route::get('data-spot',[\App\Http\Controllers\DataController::class,'spots'])->name('data-spot');


Route::get('dashboard',[\App\Http\Controllers\Dashboard::class,'index'])->name('dashboard');

// Route Toko
Route::get('data-toko',[\App\Http\Controllers\TokoController::class,'index'])->name('toko.listToko');
Route::get('tambah-toko',[\App\Http\Controllers\TokoController::class,'create'])->name('toko.tambahToko');
Route::post('simpan-toko',[\App\Http\Controllers\TokoController::class,'store'])->name('toko.simpanToko');
Route::get('list-toko',[\App\Http\Controllers\TokoController::class,'listToko'])->name('list-toko');
Route::delete('hapus-toko/{id}',[\App\Http\Controllers\TokoController::class,'destroy'])->name('toko.hapusToko');
Route::get('detail-toko/{id}',[\App\Http\Controllers\TokoController::class,'detailToko'])->name('toko.detailToko');

// Route Galeri Produk
Route::post('simpan-produk',[\App\Http\Controllers\TokoController::class,'simpanProduk'])->name('toko.simpanProduk');
Route::delete('hapus-foto-produk/{id}',[\App\Http\Controllers\TokoController::class,'hapusFotoProduk'])->name('toko.hapusFotoProduk');

