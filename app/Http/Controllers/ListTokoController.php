<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Spot;
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
        $categorySpot = Spot::with('getCategory')->get();
        $spots = Spot::with('getCategory')->get();
        //$spotsSearch = Spot::with('getCategory')->get();
        //return dd($spots);

        return view('frontend.ListToko', [
            'spots' => $spots,
            'categorySpot' => $categorySpot,
        ]);
    }

    public function show($slug)
    {
        /**
         * Menampilkan detail dari spot yang dipilih beradasrkan slugnya
         */
        $categories = Category::all();
        $spots = Spot::where('slug', $slug)->first();
        return view('frontend.DetailSpot', [
            'spots' => $spots,
            'categories' => $categories
        ]);
    }

    public function getRoute($slug)
    {
        /**
         * Menampilkan rute spot berdasarkan lokasi spot yang dipilih
         */
        $categories = Category::all();
        $spots = Spot::where('slug', $slug)->first();
        return view('frontend.RouteSpot', [
            'spots' => $spots,
            'categories' => $categories
        ]);
    }

    public function getCategory($slug)
    {
        /**
         * Menampilkan data spot beradasarkan kategori spot yang dipilih
         */
        $categories = Category::all();
        $category = Category::where('id', $slug)->orWhere('slug', $slug)->first();
        
        // pada $spot di bawah kita memanggil relasi spot() dari model category jadi dengan format
        // seperti di bawah kita bisa langsung mendapatkan hasil dari spot yang mempunyai kategori yang kita pilih
        $spot = $category->spot()->get();
        return view('frontend.CategorySpot', [
            'categories' => $categories,
            'spot' => $spot,
            'category' => $category
        ]);
    }
}
