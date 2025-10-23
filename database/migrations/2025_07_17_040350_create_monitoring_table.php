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
        Schema::create('monitoring', function (Blueprint $table) {
            $table->id();
            $table->integer('resiko_id')->unsigned()->nullable();
            $table->text('jangka_waktu')->nullable();
            $table->text('peluang_perbaikan')->nullable();
            $table->text('status_mitigasi')->nullable();
            $table->text('keterangan')->nullable();
            $table->text('evidence')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('monitoring');
    }
};
