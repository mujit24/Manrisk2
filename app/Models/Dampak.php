<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dampak extends Model
{
    use HasFactory;
    protected $table = 'dampak';

    public function namaKategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id', 'id');
    }
}
