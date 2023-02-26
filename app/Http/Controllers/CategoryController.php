<?php

namespace App\Http\Controllers;
use Illuminate\Support\Str;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /**
         * Menampilkan halaman utama dari menu kategori pada halaman backend
         * Data akan ditampilkan menggunakan plugin datatable secara server side 
         * Konfigurasi data table ada pada DataController method CATEGORY dan ajax
         * server side ada pada halaman index.blade pada folder backend/category
         */
        $category = Category::all();
        return view('backend.category.index', [
            'title' => 'List Category',
            'category' => $category
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         /**
         * Memanggil form input create data kategori
         */
        return view('backend.category.create', [
            'title' => 'Create Category'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         /**
         * validasi field nama kategori tidak boleh kosong
         */
        $this->validate($request, [
            'name' => 'required'
        ]);

        /**
         * Storing data ke database
         */
        $category = new Category();
        $category->name = $request->input('name');
        $category->slug = Str::slug($request->name, '-');
        $category->save();
        /**
         * return ke halaman index kategori jika proses storing data berhasil akan menampilkan pesan berhasil
         * simpan data. 
         */
        if ($category) {
            return redirect()->route('category.index')->with('success', 'Data berhasil disimpan');
        } else {
            return redirect()->route('category.index')->with('error', 'Data gagal disimpan');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        /**
         * Menampilkan form edit kategori berdasarkan data yang dipilih
         * dan melakukan passing parameter category yang mana parameter tersebut akan digunakan untuk
         * menampilkan data yang dipilih 
         */
        return view('backend.category.edit',[
            'title' => 'Update Category',
            'category' => $category
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        /**
         * Lakukan validasi terlebih dahulu sebelum melakukan update 
         */
        $this->validate($request, [
            'name' => 'required'
        ]);


        /**
         * Proses update data jika data ada lakukan proses update berdasarkan id data yang dipilih
         */
        $category = Category::findOrFail($category->id);
        $category->name = $request->input('name');
        $category->slug = Str::slug($request->name, '-');
        $category->update();

        /**
         * jika proses update berhasil kembali ke halaman index kategori
         */
        if ($category) {
            return redirect()->route('category.index')->with('success', 'Data berhasil diupdate');
        } else {
            return redirect()->route('category.index')->with('error', 'Data gagal diupdate');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        /**
         * Proses hapus data kategori
         * setelah memilih data yang akan dihapus jalankan proses update 
         * kembali ke halaman index jika berhasil.
         */
        $category = Category::findOrfail($id);
        $category->delete();

        if ($category) {
            return redirect()->route('category.index')->with('success', 'Data berhasil dihapus');
        } else {
            return redirect()->route('category.index')->with('error', 'Data gagal dihapus');
        }
    }
}
