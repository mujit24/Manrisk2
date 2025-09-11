<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Monitoring extends Model
{
    use HasFactory;
    protected $table = 'monitoring';

    public function namaResiko()
    {
        return $this->belongsTo(Resiko::class, 'resiko_id', 'id');
    }

    public function namaPengukuran()
    {
        return $this->belongsTo(Pengukuran::class, 'pengukuran_id', 'id');
    }

    public function namaPengendalian()
    {
        return $this->belongsTo(Pengendalian::class, 'pengendalian_id', 'id');
    }
}
