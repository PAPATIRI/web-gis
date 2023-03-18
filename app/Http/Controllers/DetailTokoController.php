<?php

namespace App\Http\Controllers;

use App\Models\GaleriProduk;
use App\Models\Toko;
use Illuminate\Http\Request;

class DetailTokoController extends Controller
{
    //
    public function index(){
        return view('frontend.DetailToko');
    }

    public function show(Request $request,$id)
    {
        /**
         * Menampilkan detail dari spot yang dipilih beradasrkan slugnya
         */
        $tokoKerajinan = Toko::where('id', $id)->first();
        $galeriProduk = GaleriProduk::where('fkid_toko',$id)->get();

        return view('frontend.DetailToko', [
            'tokoKerajinan' => $tokoKerajinan,
            'galeriProduk' => $galeriProduk
        ]);
    }
}
