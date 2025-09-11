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
        Schema::create('indf_sasaran', function (Blueprint $table) {
            $table->id();
            $table->year('tahun')->nullable();
            $table->integer('divisi_id')->unsigned()->nullable();
            $table->text('sasaran_nama')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('indf_sasaran');
    }
};
