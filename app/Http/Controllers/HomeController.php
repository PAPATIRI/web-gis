<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Spot;
use App\Models\Toko;
use Illuminate\Http\Request;

class HomeController extends Controller
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
        $this->middleware('auth')->except('index', 'show', 'getRoute', 'getCategory');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function home()
    {
        return view('welcome');
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
        $tokoKerajinan = Toko::all();

        return view('welcome', [
            'tokoKerajinan' => $tokoKerajinan,
        ]);
    }

    public function show($slug)
    {
        /**
         * Menampilkan detail dari spot yang dipilih beradasrkan slugnya
         */
        $tokoKerajinan = Toko::where('slug', $slug)->first();
        return view('frontend.DetailToko', [
            'tokoKerajinan' => $tokoKerajinan,
        ]);
    }

    public function getRoute($slug)
    {
        /**
         * Menampilkan rute spot berdasarkan lokasi spot yang dipilih
         */
        $categories = Category::all();
        $spots = Toko::where('slug', $slug)->first();
        return view('frontend.RouteSpot', [
            'spots' => $spots,
            'categories' => $categories
        ]);
    }
}
