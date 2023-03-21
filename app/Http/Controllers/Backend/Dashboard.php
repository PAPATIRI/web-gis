<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\GaleriProduk;
use App\Models\RatingToko;
use Illuminate\Http\Request;
use App\Models\Toko;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user()->id;
        $totalToko = Toko::where('fkid_user',$user)->count();
        $getProduk = Toko::where('fkid_user',$user)->get();

        $getProdukArray = [];
        foreach($getProduk as $produk){
            $getProdukArray[] = $produk->id;
        }

        
        $countRating = RatingToko::whereIn('fkid_toko',$getProdukArray)->count();
        $sumRating = RatingToko::whereIn('fkid_toko',$getProdukArray)->select(RatingToko::raw('sum(rating_toko) as totalRating'))->first();
        if($countRating == 0){
            $overalRating = 0;
        }else{
            $overalRating = $sumRating['totalRating']/$countRating;
        }


        $overalProduk = GaleriProduk::whereIn('fkid_toko',$getProdukArray)->count();

        return view('backend.pages.dashboard', compact('totalToko','overalRating','overalProduk'));
        // return view('backend.pages.dashboardtest');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
