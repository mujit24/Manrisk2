<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengendalian extends Model
{
    use HasFactory;
    protected $table = 'pengendalian';

    public function namaResiko()
    {
        return $this->belongsTo(Resiko::class, 'resiko_id', 'id');
    }

    public function namaKategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id', 'id');
    }

    public function namaPengukuran()
    {
        return $this->belongsTo(Pengukuran::class, 'pengukuran_id', 'id');
    }

    public function namaBobotExp()
    {
        return $this->belongsTo(Bobot::class, 'exp_bobot_id', 'id');
    }

    public function namaKemungkinan()
    {
        return $this->belongsTo(Kemungkinan::class, 'exp_kemungkinan_id', 'id');
    }

    public function namaDampak()
    {
        return $this->belongsTo(Dampak::class, 'exp_dampak_id', 'id');
    }
}
