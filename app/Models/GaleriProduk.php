<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GaleriProduk extends Model
{
    protected $table = "tbl_galeri_produk";
    use HasFactory;

    protected $fillable = [
        'fkid_toko',
        'nama_produk',
        'deskripsi_produk',
        'gambar_produk',
    ];

    public function toko()
    {
        return $this->belongsTo(Toko::class, 'fkid_toko');
    }
}
