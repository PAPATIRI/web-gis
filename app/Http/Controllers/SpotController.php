<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\ImageSpot;
use App\Models\Spot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class SpotController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /**
         * Menampilkan view spot index yangh berisikan data dari tabel Spot
         */
        return view('backend.spot.index', [
            'title' => 'Spot'
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
         * Menampilkan form create spot dan juga menampilkan pilihan kategori dari tabel kategori
         */
        $category = Category::all();
        return view('backend.spot.create', [
            'title' => 'Add Spot',
            'category' => $category
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
         * Proses validasi dimana nilai atau value dari properti yang ada tidak boleh kosong
         */
        $this->validate($request, [
            'category_id' => 'required',
            'description' => 'required',
            'location' => 'required',
            'cover' => 'image|required'
        ]);

        /**
         * Melakukan proses input data baru dengan mengambil nilai dari masing-masing properti
         */
        $spot = new Spot;
        $spot->name = $request->input('name');
        $spot->slug = Str::slug($request->name);
        $spot->description = $request->input('description');
        $spot->location = $request->input('location');

        /**
         * Jika terdapat file gambar/cover utama yang di input maka kan menjalankan proses ini
         * dan menyimpan gambar tesebut ke folder public/uploads/covers/
         * proses store untuk file gambar tanpa menggunakan perintah php artisan storage:link dimana jika kita
         * melakukan storing file gambar laravel akan membuatkan folder storage untuk menyimpan fiile gambar tesebut
         * 
         * disini file gambar akan langsung disimpan ke folder public jadi jika nanti aplikasi ini ingin di upload
         * ke shared hosting kita tidak perlu menjalankan command artisan storage pada SSH
         * Karena ada beberapa shared hosting yang belum support SSH
         */
        if ($request->hasFile('cover')) {
            $file = $request->file('cover');
            $imageName = time() . '_' . $file->getClientOriginalName();
            $file->move('uploads/covers/', $imageName);
            $spot->cover = $imageName;           
        }

        /**
         * Setelah semua data didapat jalankan proses penyimpanan ke tabel spot
         */
        $spot->save();

        /**
         * Dan juga melakukan proses penyimpanan ke tabel pivot category_spot
         * dengan memanfaatkan method getCategory pada model spot yang mempunyai relasi
         * belongstoMany ke tabel category
         * 
         * Data yang akan di tampung di tabel pivot yaitu spot_id yang baru saja disimpan
         * dan category_id dari input select option pada form create spot.
         */
        $spot->getCategory()->sync($request->category_id);

        /**
         * Jika menambahkan file gambar lainnya proses ini akan dijalankan 
         * dan data file gambar tersebut akan di tampung pada tabel image_spots data yang dismpan
         * file gambar dan spot_id dari tiap-tiap gambar
         * 
         * dan file gambar tersebut juga akan langsung disimpan ke folder public
         */
        if ($request->hasFile("images")) {
            $files = $request->file("images");

            foreach ($files as $file) {
                $imageName = time() . '_' . $file->getClientOriginalName();
                //$imageName = MorePictures::upload($file->getRealPath(),$file->getClientOriginalName());
                $request['spot_id'] = $spot->id;
                $request['image'] = $imageName;
                $file->move('uploads/imageSpots/', $imageName);
               
                $imageSpot = new ImageSpot([
                    'spot_id' => $spot->id,
                    'image' => $imageName,
                ]);
                $imageSpot->save();
            }
        }

        /**
         * Setelh semua proses di jalankan maka akan di redirect ke halaman index dari spot
         */
        if ($spot) {
            return redirect()->route('spot.index')->with('success', 'Data berhasil disimpan');
        } else {
            return redirect()->route('spot.index')->with('error', 'Data gagal disimpan');
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Spot $spot)
    {
        /**
         * Menampilkan form edit dan melakukan passing parameter ke form edit tersebut
         * untuk menampilkan nilai / isi dari data yang dipilih
         */
        $category = Category::all();
        $spot = Spot::findOrFail($spot->id);
        return view('backend.spot.edit', compact('category', 'spot'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Spot $spot)
    {
        /**
         * Proses yang sama dengan method store di atas yaitu validasi data
         */
        $this->validate($request, [
            'name' => 'required',
            'category_id' => 'required',
            'description' => 'required',
            'location' => 'required',
        ]);

        /**
         * Jika data ditemukan lakukan proses request nilai dari masing-masing properti yang ada di form edit
         */
        $spot = Spot::findOrFail($spot->id);
        $spot->name = $request->input('name');
        $spot->slug = Str::slug($request->name);
        $spot->description = $request->input('description');
        $spot->location = $request->input('location');

        /**
         * Jika akan mengganti gambar yang sudah ada 
         * lakukan proses hapus gambar yang lama lalu 
         * simpan gambar yanhg baru di upload
         */
        if ($request->hasFile("cover")) {

            if (File::exists("uploads/covers/" . $spot->cover)) {
                File::delete("uploads/covers/" . $spot->cover);
            }
            $file = $request->file("cover");
            // $uploadedFileUrl = CoverStorage::replace($spot->cover,$file->getRealPath(),$file->getClientOriginalName());
            // $spot->cover = $uploadedFileUrl;
            $spot->cover = time() . '_' . $file->getClientOriginalName();
            $file->move('uploads/covers/', $spot->cover);
            $request['cover'] = $spot->cover;
        }

        /**
         * Jika berhasil proses update akan berjalan begitu juga dengan data yang ada di tabel pivot
         * bila terjadi perubahan data kategori akan terupdate juga
         */
        $spot->update();
        $spot->getCategory()->sync($request->category_id);

        /**
         * Untuk proses update 'gambar lainnya atau gambar tambahan untuk spot' 
         * harus di lakukan secara manual
         * yaitu hapus gambar yang ingin dihapus baru tambahkan gambar baru untuk mengganti gambar yang lama
         * bila proses ini dilakukan tanpa menghapus gambar.maka gambar yang baru di input akan menjadi 
         * data gambar baru, tidak mengganti gambar yang ingin diubah / update.
         */
        if ($request->hasFile("images")) {
            $files = $request->file("images");

            foreach ($files as $file) {
                $imageName = time() . '_' . $file->getClientOriginalName();
                //$imageName = MorePictures::upload($file->getRealPath(),$file->getClientOriginalName());
                $request['spot_id'] = $spot->id;
                $request['image'] = $imageName;
                $file->move('uploads/imageSpots/', $imageName);
               
                $imageSpot = new ImageSpot([
                    'spot_id' => $spot->id,
                    'image' => $imageName,
                ]);
                $imageSpot->save();
            }
        }

        if ($spot) {
            return redirect()->route('spot.index')->with('success', 'Data berhasil disimpan');
        } else {
            return redirect()->route('spot.index')->with('error', 'Data gagal disimpan');
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
         * Proses destroy akan menghapus semua data dari data spot yang dipilih
         * begitu juga dengan gambar cover utama dan gambar lainnya
         * akan ikut terhapus juga
         */
        $spot = Spot::findOrFail($id);

        if (File::exists("uploads/covers/" . $spot->cover)) {
            File::delete("uploads/covers/" . $spot->cover);
        }

        $images = ImageSpot::where("spot_id", $spot->id)->get();
        foreach ($images as $images) {
            if (File::exists("uploads/imageSpots/" . $images->image)) {
                File::delete("uploads/imageSpots/" . $images->image);
            }
            $images->delete();
        }

        $spot->delete();
        return back();
    }

    public function deleteImage($id)
    {
        /**
         * method ini hanya akan di jalankan jika kita ingin menghapus data gambar lainnya dari
         * tabel ImageSpot
         */
        $imageSpot = ImageSpot::findOrFail($id);
        if (File::exists("uploads/imageSpots/" . $imageSpot->image)) {
            File::delete("uploads/imageSpots/" . $imageSpot->image);
        }
        ImageSpot::find($id)->delete();
        //MorePictures::delete($imageSpot->image);    
        return back();
    }
}
