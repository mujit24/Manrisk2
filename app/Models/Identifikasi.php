<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Identifikasi extends Model
{
    use HasFactory;
    protected $table = 'identifikasi';

    public function namaKategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id', 'id');
    }

    public function namaDivisi()
    {
        return $this->belongsTo(Divisi::class, 'divisi_id', 'id');
    }

    // public function pengukuran()
    // {
    //     return $this->hasOne(Pengukuran::class, 'resiko_id');
    // }

    // public function pengendalian()
    // {
    //     return $this->hasOne(Pengendalian::class, 'resiko_id');
    // }

    // public function monitoring()
    // {
    //     return $this->hasOne(Monitoring::class, 'resiko_id');
    // }
}
