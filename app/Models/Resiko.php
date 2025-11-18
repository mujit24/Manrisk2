<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resiko extends Model
{
    use HasFactory;
    protected $table = 'indf_resiko';

    // sasaran = KPI
    public function namaSasaran()
    {
        return $this->belongsTo(Sasaran::class, 'sasaran_id', 'id');
    }

    // tujuan = program kerja
    public function namaTujuan()
    {
        return $this->belongsTo(Tujuan::class, 'tujuan_id', 'id');
    }

    // event = kegiatan
    public function namaEvent()
    {
        return $this->belongsTo(Event::class, 'event_id', 'id');
    }

    public function namaKategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id', 'id');
    }

    public function throughTujuan()
    {
        return $this->hasOneThrough(
            Tujuan::class,    // model tujuan akhir yang ingin diambil
            Event::class,     // model perantara
            'id',             // kunci lokal di Event yg dirujuk oleh Resiko? (lihat catatan di bawah)
            'id',             // kunci lokal di Tujuan
            'event_id',       // fk di Resiko yang menunjuk ke Event
            'tujuan_id'       // fk di Event yang menunjuk ke Tujuan
        );
    }


    public function namaDivisi()
    {
        return $this->setConnection('mysql_erp') // gunakan koneksi ke erp_new
            ->belongsTo(Divisi::class, 'divisi_id', 'organization_id');
    }


    public function namaPengukuran()
    {
        return $this->hasOne(Pengukuran::class, 'resiko_id', 'id');
    }

    public function namaPengendalian()
    {
        return $this->hasOne(Pengendalian::class, 'resiko_id', 'id');
    }

    public function namaMonitoring()
    {
        return $this->hasOne(Monitoring::class, 'resiko_id', 'id');
    }
}
