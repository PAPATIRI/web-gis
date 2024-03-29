<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\GaleriProduk;
use App\Models\Spot;
use App\Models\Toko;
use Illuminate\Http\Request;

class ListTokoController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        /**
         * Menambahkan except disini maksdunya untuk menjalankan proses dari method tersebut
         * Tidak harus melakukan autentikasi terlebih dahulu 
         */
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function listToko()
    {
        return view('frontend.ListToko');
    }

    public function index()
    {
        /**
         * $categorySpot dan $spots sama-sama memanggil tabel spot
         * dengan chain method with ke getCategory agar relasi tersebut bisa digunakan
         * pada file view welcome.blade
         * 
         * $categories akan digunakan pada header di file views/layouts/frontend
         */
        $tokoKerajinan = Toko::where('status_toko',1)->paginate(8);

        return view('frontend.ListToko', [
            'tokoKerajinan' => $tokoKerajinan,
        ]);
    }

    // public function show(Request $request,$id)
    // {
    //     /**
    //      * Menampilkan detail dari spot yang dipilih beradasrkan slugnya
    //      */
    //     $tokoKerajinan = Toko::where('id', $id)->first();
    //     $galeriProduk = GaleriProduk::where('fkid_toko',$id)->get();

    //     return view('frontend.DetailToko', [
    //         'tokoKerajinan' => $tokoKerajinan,
    //         'galeriProduk' => $galeriProduk
    //     ]);
    // }

    public function getRoute($id)
    {
        /**
         * Menampilkan rute spot berdasarkan lokasi spot yang dipilih
         */
        $tokoKerajinan = Toko::where('id', $id)->first();
        return view('frontend.RouteSpot', [
            'tokoKerajinan' => $tokoKerajinan,
        ]);
    }
}
