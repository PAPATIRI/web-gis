<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RatingToko extends Model
{
    protected $table = "tbl_rating_toko";
    use HasFactory;

    protected $fillable = [
        'fkid_toko',
        'rating_toko',
        'komentar',
    ];

    public function toko()
    {
        return $this->belongsTo(Toko::class, 'fkid_toko');
    }
}
