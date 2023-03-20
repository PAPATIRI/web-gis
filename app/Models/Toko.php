<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Toko extends Model
{
    protected $table = "tbl_toko";
    use HasFactory;

    protected $fillable = [
        // 'id',
        'fkid_user',
        'nama_toko',
        'lokasi_toko',
        'alamat_detail_toko',
        'website_toko',
        'kontak_toko',
        'deskripsi_toko',
        'jam_buka',
        'jam_tutup',
        'status_toko',
        'sampul_toko',
        'slug'
    ];

    public function pemilik()
    {
        return $this->belongsTo(User::class, 'fkid_user');
    }
}
