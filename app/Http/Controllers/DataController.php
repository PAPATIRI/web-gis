<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Spot;
use Illuminate\Http\Request;

class DataController extends Controller
{
    public function categories()
    {
        /**
         * Membuat fungsi datatables untuk menampilkan data category
         * menambahkan column action pada bagian addColumn yang mana memiliki file view berupa
         * tombol edit dan hapus data category. 
         */
        $categories = Category::orderBy('created_at', 'DESC');
        return datatables()->of($categories)
            ->addColumn('action', 'backend.category.action')
            ->addIndexColumn()
            ->rawColumns(['action'])
            ->toJson();
    }

    public function spots()
    {
        /** Membuat fungsi datatables untuk menampilkan data spots
         *  pada bagian addcolumn kita membuat function untuk memanggil relasi many to many ke tabel category
         *  jadi setiap data spot yang memiliki kategori akan menampilkan nama kategori berdasarkan id category
         * yang tersimpan di tabel pivot 
         */
        $spots = Spot::orderBy('created_at', 'DESC')->get();
        $spots->load('category');

        return datatables()->of($spots)
            ->addColumn('category', function (Spot $model) {
                return $model->getCategory->map(function ($getCategory) {
                    $result = ($getCategory->name == 1) ? 'Belum ada Kategori' : $getCategory->name;
                    return $result;
                })->implode(',');
                 //return $model->category->name;
            })
            ->addColumn('action', 'backend.spot.action')
            ->addIndexColumn()
            ->rawColumns(['action'])
            ->toJson();
    }
}
