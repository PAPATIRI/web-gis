<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon ;

class RatingToko extends Model
{
    protected $table = "tbl_rating_toko";
    use HasFactory;

    protected $fillable = [
        'fkid_toko',
        'nama',
        'rating_toko',
        'komentar',
    ];

    public function toko()
    {
        return $this->belongsTo(Toko::class, 'fkid_toko');
    }
    public function getCreatedAtAttribute()
    {
        return Carbon::parse($this->attributes['created_at'])->translatedFormat('d F Y');
        
    }
}
