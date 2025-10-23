<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Risk_Divisi extends Model
{
    use HasFactory;
    protected $table = 'risk_divisi';

    public function namaDivisi()
    {
        return $this->belongsTo(Divisi::class, 'divisi_id', 'id');
    }

    public function namaDampak()
    {
        return $this->belongsTo(Dampak::class, 'divisi_id', 'id');
    }
}
