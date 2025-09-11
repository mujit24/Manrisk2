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
        Schema::create('dampak', function (Blueprint $table) {
            $table->id();
            $table->string('dampak_level', 10)->nullable();
            $table->string('dampak_nama', 1000)->nullable();
            $table->string('dampak_keterangan', 1000)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dampak');
    }
};
