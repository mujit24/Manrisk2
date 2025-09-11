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
        Schema::create('kemungkinan', function (Blueprint $table) {
            $table->id();
            $table->string('kmn_level', 10)->nullable();
            $table->string('kmn_nama', 500)->nullable();
            $table->string('kmn_keterangan', 500)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kemungkinan');
    }
};
