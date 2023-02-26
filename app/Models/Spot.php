<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Spot extends Model
{
    use HasFactory;
    protected $guarded = [];


    public function category()
    {
        /** 
        method ini digunakan untuk membuat relasi belongsTo atau 1 to 1
        ke tabel kategori. method ini digunakan 
        */
        return $this->belongsTo(Category::class);
    }
    
    public function getCategory()
    {
        /** 
        method ini digunakan untuk membuat relasi belongstomany atau banyak ke banyak
        ke tabel kategori dari tabel spot.
        */
        return $this->belongsToMany(Category::class);
    }

    public function getImages()
    {
        /** 
        method ini digunakan untuk mendapatkan list gambar pada tabel ImageSpot
        sesuai dengan id spotnya 
        */
        return $this->hasMany(ImageSpot::class);
    }

    public function getImage()
    {
        /** 
        method berfungsi untuk menampilkan data gambar/cover utama dari tabel spot
        jika tidak ada gambar yang diupload maka kita akan menggantinya dengan image placeholder
        */
        if (substr($this->cover, 0, 5) == "https") {
            return $this->cover;
        }

        if ($this->cover) {
            return asset('uploads/covers/' .$this->cover);
        }

        return 'https://via.placeholder.com/150x200.png?text=No+Cover';
    }
}
