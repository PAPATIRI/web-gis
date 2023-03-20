<?php

namespace App\Http\Controllers;

use App\Models\GaleriProduk;
use App\Models\RatingToko;
use App\Models\Toko;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

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
        $galeriProduk = GaleriProduk::where('fkid_toko',$id)->paginate(6, ['*'], 'galeriToko');
        $ratingToko = RatingToko::orderBy('created_at', 'desc')->where('fkid_toko', $id)->paginate(4);
        // rating toko rata-rata
        $countRating = RatingToko::where('fkid_toko',$id)->count();
        $sumRating = RatingToko::where('fkid_toko',$id)->select(RatingToko::raw('sum(rating_toko) as totalRating'))->first();
        if($countRating == 0){
            $overalRating = 0;
        }else{
            $overalRating = $sumRating['totalRating']/$countRating;
        }

        if ($request->ajax()) {
            return view('frontend.components.ratingToko', compact('ratingToko'));
        }

        return view('frontend.DetailToko', [
            'tokoKerajinan' => $tokoKerajinan,
            'galeriProduk' => $galeriProduk,
            'ratingToko'=>$ratingToko,
            'overalRating'=>round($overalRating),
        ]);
    }

     public function tambahRating(Request $request){
        $data = [
            'nama' => $request->nama,
            'rating_toko' => $request->rating,
            'komentar' => $request->komentar,
            'fkid_toko' => $request->fkid_toko
        ];
        RatingToko::create($data);
        return back()->withInput();
     }

     public function detailProduk(Request $request){
        $data = GaleriProduk::where('id',$request->id)->first();
        return view('frontend.modal.modal-detailFoto', compact('data'));
     }
}
