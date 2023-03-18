<?php

namespace App\Http\Controllers;

use App\Models\GaleriProduk;
use App\Models\JamPelayanan;
use App\Models\RatingToko;
use Illuminate\Database\Eloquent\Model;
use \App\Models\Toko;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;


use Illuminate\Http\Request;

class TokoController extends Controller
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
        $title = 'Toko Saya';
        $pemilikToko = Auth::user()->id;
        $daftarTokoSaya = Toko::where('fkid_user',$pemilikToko)->get();

        // dd($daftarTokoSaya);
        return view('backend.pages.toko', compact('title','daftarTokoSaya'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Tambah Toko Baru';
        $jamPelayanan = JamPelayanan::all();
        return view('backend.pages.tambahToko',compact('title','jamPelayanan'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'sampul_toko' => 'image|required'
        ]);

        // Proses Input dan upload file gambar foto sampul toko
        $file = $request->file('sampul_toko');
        $namaFile = $file->getClientOriginalName();
        $file->move('uploads/Foto Sampul Toko/', $namaFile);
       
        // Proses simpan nilai dari inputan ke array untuk disimpan dalam database
        $data = [
            'fkid_user'     =>$request->fkid_user,
            'nama_toko'     =>$request->nama_toko,
            'lokasi_toko'   =>$request->lokasi_toko,
            'alamat_detail_toko'   =>$request->alamat_detail_toko,
            'website_toko'  =>$request->website_toko,
            'kontak_toko'   =>$request->kontak_toko,
            'deskripsi_toko'=>$request->deskripsi_toko,
            'jam_buka'      =>$request->jamBuka,
            'jam_tutup'     =>$request->jamTutup,
            'status_toko'   =>$request->status_toko,
            'sampul_toko'   =>$namaFile,
            'slug' => Str::slug($request->nama_toko)
        ];
        Toko::create($data);
        return response()->json([
            'state' => 'success',
            'message' => 'Toko baru telah selesai dibuat.',
            'title' => 'Berhasil..!',
        ]);
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
        $title = 'Ubah Data Toko';
        $jamPelayanan = JamPelayanan::all();
        $data = Toko::where('id',$id)->first();
        return view('backend.pages.ubahToko',compact('title','jamPelayanan','data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // dd($request->all());

        // $this->validate($request,[
        //     'sampul_toko' => 'image|required'
        // ]);

        // Proses Input dan upload file gambar foto sampul toko
        // $file = $request->file('sampul_toko');
        // $namaFile = $file->getClientOriginalName();
        // $file->move('uploads/Foto Sampul Toko/', $namaFile);
       
        // Proses update nilai dari inputan ke array untuk disimpan dalam database
     
        Toko::where('id',$request->id_toko)->update([
            'fkid_user'     =>$request->fkid_user,
            'nama_toko'     =>$request->nama_toko,
            'lokasi_toko'   =>$request->lokasi_toko,
            'alamat_detail_toko'   =>$request->alamat_detail_toko,
            'website_toko'  =>$request->website_toko,
            'kontak_toko'   =>$request->kontak_toko,
            'deskripsi_toko'=>$request->deskripsi_toko,
            'jam_buka'      =>$request->jamBuka,
            'jam_tutup'     =>$request->jamTutup,
            'status_toko'   =>$request->status_toko,
            'slug' => Str::slug($request->nama_toko)
            // 'sampul_toko'   =>$namaFile,

        ]);
        return response()->json([
            'state' => 'success',
            'message' => 'Berhasil mengubah data Toko.',
            'title' => 'Berhasil..!',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Toko::where('id',$id)->delete();
        return response()->json([
            'state' => 'success',
            'message' => 'Toko anda telah dihapus.',
            'title' => 'Berhasil..!',
        ]);
    }

    public function detailToko(Request $request,$id){
        $title = 'Detail Toko';
        $item = Toko::where('id',$id)->first();
        $galeriProduk = GaleriProduk::where('fkid_toko',$id)->get();
        $countRating = RatingToko::where('fkid_toko',$id)->count();
        $sumRating = RatingToko::where('fkid_toko',$id)->select(RatingToko::raw('sum(rating_toko) as totalRating'))->first();
        if($countRating == 0){
            $overalRating = 0;
        }else{
            $overalRating = $sumRating['totalRating']/$countRating;
        }
        return view('backend.pages.detailToko', compact('title','item','overalRating','galeriProduk'));
    }

    public function listToko(){
        $pemilikToko    = Auth::user()->id;
        $daftarTokoSaya = Toko::where('fkid_user',$pemilikToko)->count();
        return json_encode($daftarTokoSaya);
    }

    public function simpanProduk(Request $request){
        $this->validate($request,[
            'gambar_produk' => 'image|required'
        ]);

        // Proses Input dan upload file gambar foto sampul toko
        $file = $request->file('gambar_produk');
        $namaFile = $file->getClientOriginalName();
        $file->move('uploads/Galeri Produk/', $namaFile);
       
        // Proses simpan nilai dari inputan ke array untuk disimpan dalam database
        $data = [
            'fkid_toko'         =>$request->fkid_toko,
            'nama_produk'       =>$request->nama_produk,
            'deskripsi_produk'  =>$request->deskripsi_produk,
            'gambar_produk'     =>$namaFile,
        ];
        GaleriProduk::create($data);
        return response()->json([
            'state' => 'success',
            'message' => 'Produk baru berhasil diupload.',
            'title' => 'Berhasil..!',
        ]);
    }

    public function hapusFotoProduk(Request $request,$id){
            // dd($request->id);
            GaleriProduk::where('id',$request->id)->delete();
            return response()->json([
                'state' => 'success',
                'message' => 'Produk telah dihapus.',
                'title' => 'Berhasil..!',
            ]);
    }

    public function detailProduk(Request $request){
        // dd($request->id);
        $data = GaleriProduk::where('id',$request->id)->first();
        return view('backend.modal.modal-detailProduk', compact('data'));
    }

    public function editProduk(Request $request){
        // dd($request->id);
        $data = GaleriProduk::where('id',$request->id)->first();
        return view('backend.modal.modal-editProduk', compact('data'));
    }

    public function updateProduk(Request $request){

        // dd($request->id_produk);

        GaleriProduk::where('id',$request->id_produk)->update([
            'nama_produk'       => $request->nama_produk,
            'deskripsi_produk'  => $request->deskripsi_produk,
            // 'gambar_produk'     => 'Test'
            // 'gambar_produk'     => $request->gambar_produk
        ]);

        return response()->json([
            'state' => 'success',
            'message' => 'Produk telah diupdate.',
            'title' => 'Berhasil..!',
        ]);
    }
}
