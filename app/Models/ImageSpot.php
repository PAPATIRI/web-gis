<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImageSpot extends Model
{
    use HasFactory;
    protected $guarded = [];
    
    public function spot()
    {
        /** 
        relasi belongsto dari imagespot ke tabel spot
        */
        return $this->belongsTo(Spot::class);
    }

    public function ListImages()
    {
        if (substr($this->image, 0, 5) == "https") {
            return $this->image;
        }

        if ($this->image) {
            return asset('uploads/imageSpots/' .$this->image);
            //return $this->cover;
        }
    }
}
