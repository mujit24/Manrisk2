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
        Schema::create('indf_resiko', function (Blueprint $table) {
            $table->id();
            $table->integer('sasaran_id')->unsigned()->nullable();
            $table->integer('tujuan_id')->unsigned()->nullable();
            $table->integer('event_id')->unsigned()->nullable();
            $table->integer('kategori_id')->unsigned()->nullable();
            $table->text('resiko_nama')->nullable();
            $table->text('resiko_penyebab')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('indf_resiko');
    }
};
