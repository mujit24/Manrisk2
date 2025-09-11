<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Approval extends Model
{
    use HasFactory;
    protected $table = 'app_detail';


    public function namaApproval()
    {
        return $this->belongsTo(Approval_Divisi::class, 'app_divisi_id', 'id');
    }
}
