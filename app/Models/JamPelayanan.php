<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JamPelayanan extends Model
{
    protected $table = "tbl_jam_pelayanan";
    use HasFactory;

    protected $fillable = [
        'jam_buka',
        'jam_tutup',
    ];
}
