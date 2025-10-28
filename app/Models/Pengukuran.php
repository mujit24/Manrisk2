<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengukuran extends Model
{
    use HasFactory;
    protected $table = 'pengukuran';

    public function namaResiko()
    {
        return $this->belongsTo(Resiko::class, 'resiko_id', 'id');
    }

    public function namaBobotInhern()
    {
        return $this->belongsTo(Bobot::class, 'inhern_bobot_id', 'id');
    }

    public function namaKemungkinan()
    {
        return $this->belongsTo(Kemungkinan::class, 'inhern_kemungkinan_id', 'id');
    }

    public function namaDampak()
    {
        return $this->belongsTo(Dampak::class, 'inhern_dampak_id', 'id');
    }
}
