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
        Schema::create('identifikasi', function (Blueprint $table) {
            $table->id();
            $table->year('tahun')->nullable();
            $table->integer('divisi_id')->unsigned()->nullable();
            $table->text('sasaran')->nullable();
            $table->text('tujuan')->nullable();
            $table->text('event')->nullable();
            $table->integer('kategori_id')->unsigned()->nullable();
            $table->text('nama_resiko')->nullable();
            $table->text('penyebab_resiko')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('identifikasi');
    }
};
