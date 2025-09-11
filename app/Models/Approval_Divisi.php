<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Approval_Divisi extends Model
{
    use HasFactory;
    protected $table = 'app_divisi';

    public function namaDivisi()
    {
        return $this->belongsTo(Divisi::class, 'divisi_id', 'organization_id');
    }

    public function namaPekerja()
    {
        return $this->belongsTo(Employee::class, 'user_id', 'user_id');
    }

    public function namaKadiv()
    {
        return $this->belongsTo(Employee::class, 'app_kadiv', 'user_id');
    }
}
