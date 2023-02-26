<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    public function spot()
    {
        /** 
        Relasi many to many dari tabel category ke tabel spot
        */
        return $this->belongsToMany(Spot::class);
    }
}
