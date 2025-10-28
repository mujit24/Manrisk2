<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tujuan extends Model
{
    use HasFactory;
    protected $table = 'indf_tujuan';

    public function namaSasaran()
    {
        return $this->belongsTo(Sasaran::class, 'sasaran_id', 'id');
    }
}
