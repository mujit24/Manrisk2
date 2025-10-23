<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('app_detail', function (Blueprint $table) {
            $table->id();
            $table->integer('app_divisi_id')->unsigned()->nullable();
            $table->year('tahun')->nullable();
            $table->integer('divisi_id')->unsigned()->nullable();
            $table->text('sasaran_nama')->nullable();
            $table->text('tujuan_nama')->nullable();
            $table->text('event_nama')->nullable();
            $table->text('kategori_nama')->nullable();
            $table->text('resiko_nama')->nullable();
            $table->text('resiko_penyebab')->nullable();
            $table->text('dampak')->nullable();
            $table->text('strategi')->nullable();
            $table->text('prosedur')->nullable();
            $table->integer('inhern_dampak')->unsigned()->nullable();
            $table->integer('inhern_kemungkinan')->unsigned()->nullable();
            $table->integer('inhern_nilai')->unsigned()->nullable();
            $table->text('inhern_bobot')->nullable();
            $table->text('rencana')->nullable();
            $table->integer('exp_kemungkinan')->unsigned()->nullable();
            $table->integer('exp_dampak')->unsigned()->nullable();
            $table->integer('exp_nilai')->unsigned()->nullable();
            $table->text('exp_bobot')->nullable();
            $table->text('pic')->nullable();
            $table->text('jangka_waktu')->nullable();
            $table->text('peluang_perbaikan')->nullable();
            $table->text('status_mitigasi')->nullable();
            $table->text('keterangan')->nullable();
            $table->text('evidence')->nullable();
            $table->text('app_name')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('app_detail');
    }
};
