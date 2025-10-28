<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
    protected $table = 'indf_event';

    public function namaSasaran()
    {
        return $this->hasOneThrough(
            Sasaran::class,
            Tujuan::class,
            'id',         // PK Tujuan
            'id',         // PK Sasaran
            'tujuan_id',  // FK Event -> Tujuan
            'sasaran_id'  // FK Tujuan -> Sasaran
        );
    }

    public function namaTujuan()
    {
        return $this->belongsTo(Tujuan::class, 'tujuan_id', 'id');
    }
}
